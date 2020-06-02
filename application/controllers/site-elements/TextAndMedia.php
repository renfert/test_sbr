<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class TextAndMedia extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('site-elements/TextAndMedia_Model');
    }

    /* 
    =============================================
    Returns: Id of the last registered testimonial
    ============================================== 
    */
	public function create(){
        $resultTextAndMediaCreate = $this->TextAndMedia_Model->create();
        echo json_encode($resultTextAndMediaCreate);
    }


    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function get(){
        $sectionId = $this->input->post("sectionId");
        $getTextandMedia = $this->TextAndMedia_Model->get($sectionId);
        echo json_encode($getTextandMedia);
    }
    

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
    public function edit(){
        $dataReceiveFromPost = array(
            'header' => $this->input->post("header"),
            'subHeader' => $this->input->post("subHeader"),
            'content' => $this->input->post("content"),
            'mediaName' => $this->input->post("mediaName"),
            'mediaAlign' => $this->input->post("mediaAlign"),
            'buttonTitle' => $this->input->post("buttonTitle"),
            'buttonTarget' => $this->input->post("buttonTarget"),
            'buttonUrl' => $this->input->post("buttonUrl"),
            'buttonStyle' => $this->input->post("buttonStyle"),
            'buttonColor' => $this->input->post("buttonColor"),
            'buttonHoverColor' => $this->input->post("buttonHoverColor"),
            'buttonId' => $this->input->post("buttonId"),
            'textAndMediaId' => $this->input->post("textAndMediaId"),

        );
        $resultTextAndMediaEdit = $this->TextAndMedia_Model->edit($dataReceiveFromPost);
        echo json_encode($resultTextAndMediaEdit);
    }
    
}
