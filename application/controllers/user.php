<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function index(){ // website's landing page
        
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('My_User');
        if($this->session->userdata('logged_type') === My_User::USER_TYPE_USER){
            redirect('/user/welcome/');
        }
        
        $this->load->view('bootstrap/header');
        
        $rules_array = array(
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required|alpha'
            ),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'required|alpha'
            ),
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|alpha_numeric'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|alpha_numeric'
            ),
        );
        
        switch ($this->input->post('form_type')){
            case 'register':
                $this->form_validation->set_rules($rules_array);
                break;
            case 'login':
            case 'admin_login':
                $this->form_validation->set_rules(array($rules_array[2], $rules_array[3],));
                break;
            }
        
        
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        
        if(!$this->form_validation->run()){
            $this->load->view('home_page');
        }else{
            switch ($this->input->post('form_type')){
            case 'register':
                $this->register();
                break;
            case 'login':
                $this->login(My_User::USER_TYPE_USER);
                break;
            case 'admin_login':
                $this->login(My_User::USER_TYPE_ADMIN);
                break;
            }
            
        }
        
        $this->load->view('bootstrap/footer');
    }

    public function manage(){
        // we will use the index function to display all users
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('My_User');
        $this->load->library('table');
        $this->load->helper('html');
        if(!$this->session->userdata('logged_id')){
            redirect('/user/');
        }
        
        $this->load->view('bootstrap/header');

        // retreive all users of type user
        $users_from_db = $this->My_User->get_users_of_type(My_User::USER_TYPE_USER);
        
        $users_array = array();
        $delete_confirmation_js = 'onclick="return confirm(\'Really delete?\')"';
        foreach($users_from_db as $user){
            $users_array[] = array(
                $user->id,
                $user->username,
                $user->first_name,
                $user->last_name,
                anchor('user/delete/' . $user->id, 'Delete', $delete_confirmation_js),
            );   
        }
        
        
        $this->load->view("users", array(
            'users' => $users_array,
        ));
        $this->load->view('bootstrap/footer');
        
    }
    
    public function welcome(){
        // this page loads a user of type user login successfully
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('My_User');
        
        $this->load->view('bootstrap/header');
        
        
        $this->load->view('user_welcome');
        
        $this->load->view('bootstrap/footer');
    }
    
    public function login($type){
        
        $user = new My_User();
        $logged_user = $user->check_login($this->input->post('username'), $this->input->post('password'), $type);
        if($logged_user){
            $this->session->set_userdata(array('logged_id' => $logged_user->id));
            $this->session->set_userdata(array('logged_username' => $logged_user->username));
            $this->session->set_userdata(array('logged_type' => $type));
            $type == My_User::USER_TYPE_USER ? redirect('/user/welcome/') : redirect('/magazine/');
        } else{
            $this->load->view('home_page', array('login_data' =>array('error_login' => true,))); 
        }
        
    }
    
    public function logout(){
        $this->load->library('session');
        $this->load->helper('url');
        $this->session->sess_destroy();
        redirect('/user/');
    }
    
    public function register(){
        $user = new My_User();
        $user->type = My_User::USER_TYPE_USER;
        $user->first_name = $this->input->post('first_name');
        $user->last_name = $this->input->post('last_name');
        $user->username = $this->input->post('username');
        $user->password = $this->input->post('password');
        $user->save();
        $this->load->view('home_page', array('register_data' =>array('success' => true,)));   
    }
    
}