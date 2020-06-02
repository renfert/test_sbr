<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
    
    /* 
    =============================================
    Returns: Id of the last registered category or FALSE if category already exist
    ============================================== 
    */
	public function create($categoryName){
        /* Verify if this category exist */
        $this->db->where("name", $categoryName);
        $query = $this->db->get("mycategory");
        if($query->num_rows() > 0){
            return false;
        }else{
            $data = array(
                'name' => $categoryName
            );
            $this->db->insert("mycategory", $data);
            return $this->db->insert_id();
        }
    }

    
    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
	public function edit($dataReceiveFromPost){
        $categoryName = $dataReceiveFromPost["name"];
        $categoryId = $dataReceiveFromPost["id"];
        /* Verify if this category exist */
        $this->db->where("name", $categoryName);
        $query = $this->db->get("mycategory");
        if($query->num_rows() > 0){
            return false;
        }else{
            $data = array(
                'name' => $categoryName
            );
            $this->db->where("id", $categoryId);
            if($this->db->update("mycategory", $data)){
                return true;
            }else{
                return false;
            }
        }
    }

    
    /* 
    =============================================
    Returns: Boolean - TRUE if the delete was successful and FALSE if not.
    ============================================== 
    */ 
	public function delete($categoryId){
        $this->db->where('id',$categoryId);
        if($this->db->delete("mycategory")){
            return true;
        }else{
            return false;
        }
    }
    
    
    /* 
    =============================================
    Returns: Array of objects 
    Obs: The only category that we do not list is with ID = 1 because it is a standard category used for internal controls.
    ============================================== 
    */
    public function listing(){
        $this->db->select("*");
        $this->db->from("mycategory");
        $this->db->where("id !=", 1 );
        $query = $this->db->get();
       
        if($query->num_rows() > 0){
            return $query->result();
        }
    }
}