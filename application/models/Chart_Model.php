<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
  
	public function getStudentsChart(){
        $this->db->select("DATE_FORMAT(creation_date, '%b') as label, COUNT(*) as value");
        $this->db->from("myuser T0");
        $this->db->where("T0.id != 1 AND T0.myrole_id = 3");
        $this->db->group_by("creation_date");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
        }
        return $result;
    }

    public function getSalesChart(){
        $this->db->select("DATE_FORMAT(transaction_date, '%b') as label, SUM(value) as value");
        $this->db->from("payments");
        $this->db->group_by("transaction_date");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
        }
        return $result;
    }
}