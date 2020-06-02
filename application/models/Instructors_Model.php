<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructors_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
	}

   
    public function getInstructorCourses($instructorId){
        $this->db->select("mycourse_id");
        $this->db->from("relationship");
        $this->db->where("myuser_id", getUserId());
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }


}