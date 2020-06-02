<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	/* 
    =============================================
    Returns: Array with only one object
    ============================================== 
    */  
	public function getCompanyInformation(){
		$this->db->select("*");
		$result=$this->db->get("mycompany");
		if($result->num_rows()>0){
			return $result->row();
		}
		else{
			return false;
		}
	}
}