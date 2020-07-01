<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductList_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }

    /* 
    =============================================
    Returns: Id of the last registered product list
    ============================================== 
    */
	public function create(){
        $data = array(
            "number_of_products" => 5,
            "header" => "See our amazing courses",
            "subheader" => "Enjoy the knowledge"
        );
        $this->db->insert("product_list", $data);
        $productListId = $this->db->insert_id();
        $this->registerOnSectionTable($productListId);
        return $productListId; 
    }

    /* 
    =============================================
    Returns: NA
    ============================================== 
    */
    private function registerOnSectionTable($productListId){
        $sectionPosition = $this->getPositionForThisSection();
        $data = array(
            "position" => $sectionPosition,
            "banner_id" => 1,
            "product_list_id" => $productListId,
            "testimonial_id" => 1,
            "text_and_media_id" => 1,
            "type" => "product-list"
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
    Returns: Array of objects 
    ============================================== 
    */
    public function get($sectionId){
        $this->db->select("T1.id,T1.number_of_products,T1.header,T1.subheader");
        $this->db->from("section T0");
        $this->db->join("product_list T1", "T0.product_list_id = T1.id");
        $this->db->where("T0.id", $sectionId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $productList = $query->result();
            $limitNumberOfCourses = $productList[0]->number_of_products;
            $courses =  $this->getCourses($limitNumberOfCourses);

            $result["productList"] =   $productList;
            $result["courses"] = $courses;
        }
        return $result;
    }

    private function getCourses($limit){
        $currentDate = getCurrentDate("Y-m-d");
        $this->db->select("
        T0.id,
        T0.title,
        T0.description,
        T0.photo,
        T0.price,
        T0.creation_date,
        DATE_FORMAT(T0.release_date, '%d/%m/%Y') as release_date, 
        DATE_FORMAT(T0.expiration_date, '%d/%m/%Y') as expiration_date, 
        DATEDIFF(T0.expiration_date, '$currentDate') as expirationDays,
        DATEDIFF(T0.release_date, '$currentDate') as releaseDays,
        T0.spotlight,
        T0.validity,
        T0.preview, 
        T1.name, 
        T2.currency");
        $this->db->from("mycourse T0");
        $this->db->join("myuser T1", "T0.creation_user = T1.id");
        $this->db->join("settings T2", "1 = 1");
        $this->db->limit($limit);
        $this->db->where("T0.id !=", 1);
        $this->db->where("spotlight !=", null);
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
            "number_of_products" => $dataReceiveFromPost["limitListOfCourses"],
            "header" => $dataReceiveFromPost["header"],
            "subheader" => $dataReceiveFromPost["subHeader"],
        );
        $this->db->where("id", $dataReceiveFromPost["productListId"]);
        if($this->db->update("product_list", $data)){
            return true;
        }else{
            return false;
        }
    }
}