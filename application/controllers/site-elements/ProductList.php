<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class ProductList extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('site-elements/ProductList_Model');
    }

    /* 
    =============================================
    Returns: Id of the last registered product list
    ============================================== 
    */
	public function create(){
        $resultProductListCreate = $this->ProductList_Model->create();
        echo json_encode($resultProductListCreate);
    }


    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function get(){
        $sectionId = $this->input->post("sectionId");
        $get = $this->ProductList_Model->get($sectionId);
        echo json_encode($get);
    }
    

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
    public function edit(){
        $dataReceiveFromPost = array(
            'productListId' => $this->input->post("productListId"),
            'subHeader' => $this->input->post("subHeader"),
            'header' => $this->input->post("header"),
            'limitListOfCourses' => $this->input->post("limitListOfCourses"),
        );
        $resultProductListEdit = $this->ProductList_Model->edit($dataReceiveFromPost);
        echo json_encode($resultProductListEdit);
    }
    
}
