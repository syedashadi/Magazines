<?php

class My_User extends My_Model{
    
    const DB_TABLE = 'users';
    const DB_TABLE_PK = 'id';
    
    const USER_TYPE_ADMIN = 0;
    const USER_TYPE_USER = 1;
    
    public $id, $type, $username, $password, $first_name, $last_name;
    
    public function get_users_of_type($type){
        $query = $this->db->get_where($this::DB_TABLE, array(
            'type' => $type
        ));
        $ret_val = array();
        foreach($query->result() as $row){
            $user = new self;
            $user->populate($row);
            $ret_val[$row->{$this::DB_TABLE_PK}] = $user;
        }
        return $ret_val;
    }
    
    public function check_login($username='', $password='', $type=1){
        $query = $this->db->get_where($this::DB_TABLE, array(
            'username' => $username,
            'password' => $password,
            'type' => $type,
        ), 1);
        $user = new self;
        $user->populate($query->row());
        return $query->row() ? $user : false;
    }
    
}

