<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Magazine extends CI_Controller {


    public function index() // manage magazines page
    {
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('table');
        $this->load->model(array('Issue', 'Publication'));
        $this->load->library('pagination');
        $this->load->helper('html');
        $this->load->model('My_User');
        
        if(!$this->session->userdata('logged_id')){
            redirect('/user/');
        }
        
        $this->load->view('bootstrap/header');
        
        // preparing pagination
        $config['base_url'] = 'http://saas.local/Magazines/index.php/magazine/index';
        $config['total_rows'] = $this->db->count_all_results('issues');
        $config['per_page'] = 2;
        $this->pagination->initialize($config);
        
        // getting the page for pagination
        $page = $this->uri->segment(3,0); // if segment 3 doesn't exits, set page to 0
        
        $magazines = array();
        $issues = $this->Issue->get($config['per_page'], $page);
        $delete_confirmation_js = 'onclick="return confirm(\'Really delete?\')"';
        foreach($issues as $issue){
            $publication = new Publication();
            $publication->load($issue->publication_id);
            $magazines[] = array(
                $issue->issue_id,
                $publication->publication_name,
                $issue->issue_number,
                $issue->issue_date_publication,
                $issue->issue_cover ? img('upload/' . str_replace(strrchr($issue->issue_cover, '.'), '_thumb'.strrchr($issue->issue_cover, '.'), $issue->issue_cover)) : 'N',
                anchor('magazine/view/' . $issue->issue_id, 'View') . ' | ' .
                anchor('magazine/delete/' . $issue->issue_id, 'Delete', $delete_confirmation_js),
            );   
        }
        
        
        $this->load->view("magazines", array(
            'magazines' => $magazines,
        ));
        $this->load->view('bootstrap/footer');
    }
    
    public function add(){
        $this->load->helper('url');
        $this->load->library('session');
		$this->load->model('My_User');
        $this->load->library('table');
        $this->load->model(array('Issue', 'Publication'));
        $this->load->view('bootstrap/header');

        
        $upload_config = array(
            'upload_path' => 'upload',
            'allowed_types' => 'gif|png|jpg',
            'max_size' => 600,
            'max_width' => 1920,
            'max_height' => 1080,
        );
        $this->load->library('upload', $upload_config);
        
        $this->load->helper('form');
        $this->load->model("Publication");
        
        $publications = $this->Publication->get();
        $publication_form_options = array();
        foreach($publications as $id => $publication){
            $publication_form_options[$id] = $publication->publication_name;
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules(array(
            array(
                'field' => 'publication_id',
                'label' => 'Publication Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'issue_number',
                'label' => 'Issue Number',
                'rules' => 'required|is_numeric|callback_check_duplicate'
            ),
            array(
                'field' => 'issue_date_publication',
                'label' => 'Publication Date',
                'rules' => 'required|callback_date_validation'
            ),
        ));
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        // checking selected file for cover
        $check_file_upload = false;
        if(isset($_FILES['issue_cover']['error']) && $_FILES['issue_cover']['error'] != 4){
            $check_file_upload = true;
        }
        if(!$this->form_validation->run() || ($check_file_upload && !$this->upload->do_upload('issue_cover'))){
            $this->load->view("magazine_add_form", array(
                "publication_form_options" => $publication_form_options,
            ));
        } else{
            $this->load->model('Issue');
            $issue = new Issue();
            $issue->publication_id = $this->input->post('publication_id');
            $issue->issue_number = $this->input->post('issue_number');
            $issue->issue_date_publication = $this->input->post('issue_date_publication');
            $upload_data = $this->upload->data();
            if(isset($upload_data['file_name'])){
                $issue->issue_cover = $upload_data['file_name'];
            }
            $issue->save();
            
            // making thumbnail of uploaded image for future use
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'upload/' .$issue->issue_cover;
            $config['create_thumb'] = true;
            $config['maintain_ration'] = true;
            $config['width'] = 75;
            $config['height'] = 50;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();  // the resulting thumbnail name is same as the cover name appended with '_thumb'
            
            // success message after saving the new issue
            $this->load->view('magazine_form_success', array(
                'issue' => $issue,
            ));
        }
        $this->load->view('bootstrap/footer');
    }
    
    public function date_validation($input){
        $test_date = explode('-', $input);
        if(count($test_date) == 3 && checkdate($test_date[1], $test_date[2], $test_date[0])){
            return true;
        }
        $this->form_validation->set_message('date_validation', 'The %s field must be in YYYY-MM-DD format.');
        return false;
    }
    
    public function check_duplicate($input){
        $this->load->model('Issue');
        if($this->Issue->check_duplicate_by_number($input)){
            $this->form_validation->set_message('check_duplicate', 'The %s already exists.');
            return false;
        }
        return true;    
    }
    
    public function view($issue_id){
		$this->load->helper('url');
        $this->load->library('session');
		$this->load->model('My_User');
        $this->load->library('table');
        $this->load->model(array('Issue', 'Publication'));
        $this->load->view('bootstrap/header');
        $this->load->helper('html');
        $issue = new Issue();
        $issue->load($issue_id);
        if(!$issue->issue_id){
            show_404();
        }
        $publication = new Publication();
        $publication->load($issue->publication_id);
        $this->load->view('magazine', array(
            'issue' => $issue,
            'publication' => $publication,
        ));
        $this->load->view('bootstrap/footer');
    }
    
    public function delete($issue_id){
		$this->load->helper('url');
        $this->load->library('session');
		$this->load->model('My_User');
        $this->load->library('table');
        $this->load->model(array('Issue', 'Publication'));
        $this->load->view('bootstrap/header');
        $this->load->helper('html');
        $this->load->model(array('Issue'));
        $issue = new Issue();
        $issue->load($issue_id);
        if(!$issue->issue_id){
            show_404();
        }
        $issue->delete();
        $this->load->view('issue_deleted', array(
            'issue_id' => $issue_id,
        ));
        $this->load->view('bootstrap/footer');
    }
}
