<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lead_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
	}

   
    public function listing(){
        $this->db->select("name,email,creation_date");
        $this->db->from("myuser");
        $this->db->where("lead is NOT NULL", NULL, FALSE);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }


}