<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	/* 
    =============================================
    Returns: array with only one object
    ============================================== 
    */
	public function getSettingsInformation(){
		$this->db->select("*");
		$result=$this->db->get("settings");
		if($result->num_rows()>0){
			return $result->row();
		}
		else{
			return false;
		}
	
	}

	  /* 
    =============================================
    Edit settings
    ============================================== 
    */
	public function edit($params){	
		if($this->db->update("settings", $params)){
			return true;
		}else{
			return false;
		}
    }
}