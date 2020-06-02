<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Builder_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
     
    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function listHeader(){
        $this->db->select("*");
        $this->db->from("header");
        $this->db->where("id", 1 );
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function listFooter(){
        $this->db->select("*");
        $this->db->from("footer");
        $this->db->where("id", 1 );
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
	public function editFooter($dataReceiveFromPost){
        $data = array(
            "copyright" => $dataReceiveFromPost["copyright"],
            "color" => $dataReceiveFromPost["color"],
        );
        $this->db->where("id", 1);
        if($this->db->update("footer", $data)){
            return true;
        }else{
            return false;
        }
    }

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
	public function editHeader($dataReceiveFromPost){
        $data = array(
            "logo" => $dataReceiveFromPost["logoName"],
            "logo_size" => $dataReceiveFromPost["logoSize"],
            "color" => $dataReceiveFromPost["color"],
        );
        $this->db->where("id", 1);
        if($this->db->update("header", $data)){
            return true;
        }else{
            return false;
        }
    }
}