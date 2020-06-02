<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Link extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Link_Model');
    }

    /* 
    =============================================
    Returns: Id of the last registered link or FALSE if category already exist
    ============================================== 
    */
	public function create(){
        $dataReceiveFromPost = array(
            'title' => $this->input->post("title"),
            'url' => $this->input->post("url"),
            'target' => $this->input->post("target"),
        );
        $resultLinkCreate = $this->Link_Model->create($dataReceiveFromPost);
        echo json_encode($resultLinkCreate);
    }

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
    public function edit(){
        $dataReceiveFromPost = array(
            'linkId' => $this->input->post("linkId"),
            'title' => $this->input->post("title"),
            'url' => $this->input->post("url"),
            'target' => $this->input->post("target")
        );
        $resultLinkEdit = $this->Link_Model->edit($dataReceiveFromPost);
        echo json_encode($resultLinkEdit);
    }

    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function listing(){
        $linkList = $this->Link_Model->listing();
        echo json_encode($linkList);
    }

    
    /* 
    =============================================
    Returns: Boolean - TRUE if the delete was successful and FALSE if not.
    ============================================== 
    */
    public function delete(){
        $linkId = $this->input->post("linkId");
        $resultLinkDelete = $this->Link_Model->delete($linkId);
        echo json_encode($resultLinkDelete);
    }

     /* 
    =============================================
    Reorder link positions
    ============================================== 
    */
	public function reorder(){
        $this->Link_Model->reorder($this->input->post("links"));
    }

}
