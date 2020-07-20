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
}