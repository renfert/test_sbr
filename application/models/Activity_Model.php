<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
    public function save($type, $courseId, $lessonId, $leadName,$programId,$courseTitle,$lessonTitle,$moduleTitle,$programTitle){
		$data = array(
            "type" => $type,
            "mycourse_id" => $courseId,
            "mylesson_id" => $lessonId,
			"lead_name" => $leadName,
			"program_id" => $programId,
			"program_title" => $programTitle,
			"course_title" => $courseTitle,
			"lesson_title" => $lessonTitle,
			"module_title" => $moduleTitle,
            "date" => getCurrentDate("Y-m-d H:i:s"),
            "create_user" => getUserId(),
        );

		if($this->db->insert("activities", $data)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	public function listingAll(){
		$this->db->select("T0.id,T0.create_user,T0.mylesson_id,T0.mycourse_id,T0.program_id,T0.type,T0.lead_name,T0.date,T0.course_title,T0.lesson_title,T0.module_title,T0.program_title,T1.name,T1.avatar,T2.title");
		$this->db->distinct();
		$this->db->from("activities T0");
		$this->db->join("myuser T1", "T0.create_user = T1.id");
		$this->db->join("mycourse T2", "T0.mycourse_id = T2.id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
	}

}