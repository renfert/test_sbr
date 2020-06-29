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

    public function getAdminCourses(){
        $this->db->select("COUNT(*) as total, status");
        $this->db->from("course_helper T0");
        $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
        $this->db->group_by("status");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getStudentCourses($userId){
        $this->db->select("COUNT(*) as total, status");
        $this->db->from("course_helper T0");
        $this->db->join("mycourse T1", "T0.mycourse_id = T1.id");
        $this->db->where("myuser_id", $userId);
        $this->db->group_by("status");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }
}