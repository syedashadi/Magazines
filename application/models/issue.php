<?php

class Issue extends My_Model{
    
    const DB_TABLE = "issues";
    const DB_TABLE_PK = "issue_id";
	
    public $issue_id;
    public $publication_id;
    public $issue_number;
    public $issue_date_publication;
    public $issue_cover;
    
    public function check_duplicate_by_number($issue_number){
        $query = $this->db->get_where($this::DB_TABLE, array(
        'issue_number' => $issue_number,
        ));
        return $query->result() ? true : false;
    }
	
}