<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
    
    public function get($courseId,$userId){
        $this->db->select("*");
        $this->db->from("myuser_has_certificate");
        $this->db->where("myuser_id", $userId);
        $this->db->where("mycourse_id", $courseId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function listing($userId){
        $this->db->select("T0.date as date, T1.title as course");
        $this->db->from("myuser_has_certificate T0");
        $this->db->join("mycourse T1", "T0.mycourse_id = T1.id ");
        $this->db->where("T0.myuser_id = $userId");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }
}