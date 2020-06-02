<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }

    /* 
    =============================================
    Returns: Id of the last registered testimonial
    ============================================== 
    */
	public function create(){
        /* Create a testimonial */
        $data = array(
            "header" => "Meet our customers",
            "subheader" => "See what our customers have to say about us"
        );
        $this->db->insert("testimonial", $data);
        $testimonialId = $this->db->insert_id();

        for ($i=1; $i < 5 ; $i++) { 
            $personId = $this->createPerson();
            $data = array(
                "testimonial_id" => $testimonialId,
                "persons_id" => $personId
            );
            $this->db->insert("testimonial_has_persons", $data);
        }

        $this->registerOnSectionTable($testimonialId);
        return $testimonialId;
    }

    /* 
    =============================================
    Returns: NA
    ============================================== 
    */
    private function registerOnSectionTable($testimonialId){
        $sectionPosition = $this->getPositionForThisSection();
        $data = array(
            "position" => $sectionPosition,
            "banner_id" => 1,
            "product_list_id" => 1,
            "testimonial_id" => $testimonialId,
            "text_and_media_id" => 1,
            "type" => "testimonial"
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

    private function createPerson(){
        $data = array(
            "name" => "Tom lima",
            "occupation" => "CEO / Pugmania",
            "comment" => "Simply the best customer service and attention to detail.",
            "photo" => "tom.png",
            "position" => 0
        );
        $this->db->insert("persons", $data);
        return $this->db->insert_id();
    }


     
    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function get($sectionId){
        $this->db->select("T1.header, T1.subheader, T1.id");
        $this->db->from("section T0");
        $this->db->join("testimonial T1", "T0.testimonial_id = T1.id");
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
	public function edit($dataReceiveFromPost){
        $data = array(
            "header" => $dataReceiveFromPost["header"],
            "subheader" => $dataReceiveFromPost["subHeader"]
        );
        $this->db->where("id", $dataReceiveFromPost["testimonialId"]);
        if($this->db->update("testimonial", $data)){
            return true;
        }else{
            return false;
        }
    }
}