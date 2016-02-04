<?php

class Publication extends My_Model{
    
    const DB_TABLE = "publications";
    const DB_TABLE_PK = "publication_id";
	
    public $publication_id;
    public $publication_name;
	
}