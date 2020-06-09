<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
  
	public function getRegisteredStuentsPerMonth(){
        $this->db->select("DATE_FORMAT(creation_date, '%b') as label, COUNT(*) as value");
        $this->db->from("myuser T0");
        $this->db->where("T0.id !=", 1);
        $this->db->where("T0.myrole_id", 3);
        $this->db->group_by("DATE_FORMAT(creation_date, '%b')");
        $this->db->order_by("creation_date");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
    }

    public function getRegisteredInstructorsPerMonth(){
        $this->db->select("DATE_FORMAT(creation_date, '%b') as label, COUNT(*) as value");
        $this->db->from("myuser T0");
        $this->db->where("T0.id !=", 1);
        $this->db->where("T0.myrole_id", 2);
        $this->db->group_by("DATE_FORMAT(creation_date, '%b')");
        $this->db->order_by("creation_date");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
    }
}