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
		$this->db->from("settings");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
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
		finishStep(4);
		if($this->db->update("settings", $params)){
			return true;
		}else{
			return false;
		}
	}
	
	/* 
    =============================================
    Edit primary color
    ============================================== 
    */
	public function editPrimaryColor($params){	
		if($this->db->update("settings", $params)){
			return true;
		}else{
			return false;
		}
    }
}