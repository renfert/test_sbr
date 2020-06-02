<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }

    /* 
    =============================================
    Returns: Id of the last registered banner
    ============================================== 
    */
	public function create(){
        $buttonId = $this->createButton();
        $data = array(
            "image" => "default_banner.png",
            "button_id" => $buttonId,
            "header" => "Sabiorealm",
            "subheader" => "Improve your skills and become the best in digital design.",
            "header_color" => "#fff",
            "subheader_color" => "#fff",
        );
        $this->db->insert("banner", $data);
        $bannerId = $this->db->insert_id();
        $this->registerOnSectionTable($bannerId);
        return $this->db->insert_id(); 
    }

    /* 
    =============================================
    Returns: NA
    ============================================== 
    */
    private function registerOnSectionTable($bannerId){
        $sectionPosition = $this->getPositionForThisSection();
        $data = array(
            "position" => $sectionPosition,
            "banner_id" => $bannerId,
            "product_list_id" => 1,
            "testimonial_id" => 1,
            "text_and_media_id" => 1,
            "type" => "banner"
        );
        $this->db->insert("section", $data);
    }

    /* 
    =============================================
    Returns: Int: section position
    ============================================== 
    */
    private function getPositionForThisSection(){
        $this->db->select("count(id) as totalSections");
        $this->db->from("section");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            $numberOfSections = $result[0]->totalSections;
        }

        return $numberOfSections;
    }

    /* 
    =============================================
    Returns: Id of the last registered button
    ============================================== 
    */
    private function createButton(){
        $data = array(
            "title" => "SEE ALL COURSES",
            "color" => "#240D3E",
            "color_hover" => "#4285f4",
            "style" => "plain"
        );
        $this->db->insert("button", $data);
        return $this->db->insert_id();
    }

    
     
    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function getBanner($sectionId){
        $this->db->select("*");
        $this->db->from("section T0");
        $this->db->join("banner T1", "T0.banner_id = T1.id");
        $this->db->join("button T2", "T1.button_id = T2.id");
        $this->db->where("T0.id", $sectionId);
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
	public function editBanner($dataReceiveFromPost){
        $data = array(
            "title" => $dataReceiveFromPost["buttonTitle"],
            "url" => $dataReceiveFromPost["buttonUrl"],
            "target" => $dataReceiveFromPost["buttonTarget"],
            "color" => $dataReceiveFromPost["buttonColor"],
            "color_hover" => $dataReceiveFromPost["buttonHoverColor"],
            "style" => $dataReceiveFromPost["buttonStyle"],
        );
        $this->db->where("id", $dataReceiveFromPost["buttonId"]);
        $this->db->update("button", $data);

        $data = array(
            "image" => $dataReceiveFromPost["bannerName"],
            "subheader" => $dataReceiveFromPost["subHeader"],
            "header" => $dataReceiveFromPost["header"],
            "header_color" => $dataReceiveFromPost["headerColor"],
            "subheader_color" => $dataReceiveFromPost["subHeaderColor"],
        );
        $this->db->where("id", $dataReceiveFromPost["bannerId"]);
        if($this->db->update("banner", $data)){
            return true;
        }else{
            return false;
        }
        
    }
}