<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Persons extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Persons_Model');
    }

    /* 
    =============================================
    Returns: Id of the last registered person or FALSE if category already exist
    ============================================== 
    */
	public function create(){
        $testimonialId = $this->input->post("testimonialId");
        $resultPersonCreate = $this->Persons_Model->create($testimonialId);
        echo json_encode($resultPersonCreate);
    }

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
    public function edit(){
        $dataReceiveFromPost = array(
            'personId' => $this->input->post("personId"),
            'avatar' => $this->input->post("avatar"),
            'name' => $this->input->post("name"),
            'occupation' => $this->input->post("occupation"),
            'comment' => $this->input->post("comment")
        );
        $resultPersonEdit = $this->Persons_Model->edit($dataReceiveFromPost);
        echo json_encode($resultPersonEdit);
    }

    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function listing(){
        $testimonialId = $this->input->post("testimonialId");
        $personsList = $this->Persons_Model->listing($testimonialId);
        echo json_encode($personsList);
    }

    
    /* 
    =============================================
    Returns: Boolean - TRUE if the delete was successful and FALSE if not.
    ============================================== 
    */
    public function delete(){
        $personId = $this->input->post("personId");
        $resultPersonDelete = $this->Persons_Model->delete($personId);
        echo json_encode($resultPersonDelete);
    }

     /* 
    =============================================
    Reorder persons positions
    ============================================== 
    */
	public function reorder(){
        $this->Persons_Model->reorder($this->input->post("persons"));
    }

}
