<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Category_Model');
    }

   
	public function create(){
        $categoryName  = $this->input->post("name");
        $resultCategoryCreate = $this->Category_Model->create($categoryName);
        echo json_encode($resultCategoryCreate);
    }

    
    public function edit(){
        $dataReceiveFromPost = array(
            'name' => $this->input->post("name"),
            'id' => $this->input->post("id")
        );
        $resultCategoryEdit = $this->Category_Model->edit($dataReceiveFromPost);
        echo json_encode($resultCategoryEdit);
    }

   
    public function listing(){
        $categoryList = $this->Category_Model->listing();
        echo json_encode($categoryList);
    }

    
    
    public function delete(){
        $categoryId = $this->input->post("id");
       
        
        if($this->checkIfCategoryBelongToAnyCourse($categoryId)){
            $this->recategorizeCourseWithThisCategory($categoryId);
        };

       
        if($categoryId != 1){
            $resultCategoryDelete = $this->Category_Model->delete($categoryId);
            echo json_encode($resultCategoryDelete);
        }else{
            return false;
        }
    }


   
    private function checkIfCategoryBelongToAnyCourse($categoryId){
        $this->db->select("*");
        $this->db->from("mycourse");
        $this->db->where("mycategory_id", $categoryId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

   
    private function recategorizeCourseWithThisCategory($categoryId){
        $data = array(
            'mycategory_id' => 1
        );
        $this->db->where("mycategory_id", $categoryId);
        $this->db->update("mycourse", $data);
    }
}
