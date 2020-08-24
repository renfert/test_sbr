<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
  /*-------------------------- 
      Save a new review 
      Return: INT
  ---------------------------*/
	public function saveReview($data){
    $this->db->insert("reviews", $data);
    $reviewId =  $this->db->insert_id();
    return $reviewId;
  }

  /*--------------------------------------- 
      Listing all reviews from specific course
  ----------------------------------------*/
  public function listing($courseId){
    $this->db->select("T0.comment, T0.rate,  DATE_FORMAT(T0.date, '%d/%m/%Y') as date, T1.name, T1.avatar");
    $this->db->from("reviews T0");
    $this->db->join("myuser T1", "T0.myuser_id = T1.id");
    $this->db->where("T0.mycourse_id", $courseId);
    $query = $this->db->get();
    if($query->num_rows() > 0 ){
      return $query->result();
    }
  }
}