<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
    
    /* 
    =============================================
    Reorder positions
    ============================================== 
    */
	public function reorder($sections){
        $x = 0;
        foreach($sections as $key=>$val){
            $sectionId = $key;
            $position = $val;

            $data = array(
                'position' => $position
            );

            $this->db->where("id", $sectionId);
            $this->db->update("section", $data);
        }
    }

    
    /* 
    =============================================
    Returns: Boolean - TRUE if the delete was successful and FALSE if not.
    ============================================== 
    */
	public function delete($sectionId){
        $this->db->where('id',$sectionId);
        if($this->db->delete("section")){
            return true;
        }else{
            return false;
        }
    }
    
    
    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function listing(){
        $this->db->select("*");
        $this->db->from("section");
        $this->db->order_by('position', 'ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }
}