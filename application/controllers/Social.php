<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Social extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Social_Model');
    }

    /* 
    =============================================
    Returns: Id of the last registered link or FALSE if category already exist
    ============================================== 
    */
	public function create(){
        $dataReceiveFromPost = array(
            'socialMedia' => $this->input->post("socialMedia"),
            'url' => $this->input->post("url"),
        );
        $resultSocialCreate = $this->Social_Model->create($dataReceiveFromPost);
        echo json_encode($resultSocialCreate);
    }

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
    public function edit(){
        $dataReceiveFromPost = array(
            'socialMedia' => $this->input->post("socialMedia"),
            'url' => $this->input->post("url"),
            'socialMediaId' =>  $this->input->post("socialMediaId"),
        );
        $resultSocialEdit = $this->Social_Model->edit($dataReceiveFromPost);
        echo json_encode($resultSocialEdit);
    }

    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function listing(){
        $socialMediaList = $this->Social_Model->listing();
        echo json_encode($socialMediaList);
    }

    
    /* 
    =============================================
    Returns: Boolean - TRUE if the delete was successful and FALSE if not.
    ============================================== 
    */
    public function delete(){
        $socialMediaId = $this->input->post("socialMediaId");
        $resultSocialMediaDelete = $this->Social_Model->delete($socialMediaId);
        echo json_encode($resultSocialMediaDelete);
    }


}
