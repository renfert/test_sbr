<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Social_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
    
    /* 
    =============================================
    Returns: Id of the last registered link 
    ============================================== 
    */
	public function create($dataReceiveFromPost){
        $data = array(
            'name' => $dataReceiveFromPost["socialMedia"],
            'url' => $dataReceiveFromPost["url"],
        );
        $this->db->insert("social_networks", $data);
        $socialId =  $this->db->insert_id();     
        $data = array(
            'footer_id' => 1,
            'social_networks_id' => $socialId
        );
        $this->db->insert("footer_has_social_networks", $data);
        return $socialId;
    }


    
    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
	public function edit($dataReceiveFromPost){
        $data = array(
            'name' => $dataReceiveFromPost["socialMedia"],
            'url' => $dataReceiveFromPost["url"],
        );
        $this->db->where("id",$dataReceiveFromPost["socialMediaId"]);
        if($this->db->update("social_networks", $data)){
            return true;
        }else{
            return false;
        }
        
    }

    
    /* 
    =============================================
    Returns: Boolean - TRUE if the delete was successful and FALSE if not.
    ============================================== 
    */ 
	public function delete($socialMediaId){
        /* Delete from footer_has_social_networks */
        $this->db->where("social_networks_id", $socialMediaId);
        $this->db->delete("footer_has_social_networks");

        /* Delete from social_networks */
        $this->db->where('id',$socialMediaId);
        if($this->db->delete("social_networks")){
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
        $this->db->from("footer_has_social_networks T0");
        $this->db->join('social_networks T1', 'T0.social_networks_id  = T1.id');
        $this->db->where("T0.footer_id", 1 );
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

}