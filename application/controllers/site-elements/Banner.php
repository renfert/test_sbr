<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Banner extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('site-elements/Banner_Model');
    }

    /* 
    =============================================
    Returns: Id of the last registered banner
    ============================================== 
    */
	public function create(){
        $resultBannerCreate = $this->Banner_Model->create();
        echo json_encode($resultBannerCreate);
    }


    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function getBanner(){
        $sectionId = $this->input->post("sectionId");
        $getBanner = $this->Banner_Model->getBanner($sectionId);
        echo json_encode($getBanner);
    }
    

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
    public function editBanner(){
        $dataReceiveFromPost = array(
            'bannerName' => $this->input->post("bannerName"),
            'subHeader' => $this->input->post("subHeader"),
            'bannerId' => $this->input->post("bannerId"),
            'header' => $this->input->post("header"),
            'headerColor' => $this->input->post("headerColor"),
            'subHeaderColor' => $this->input->post("subHeaderColor"),
            "buttonId" =>  $this->input->post("buttonId"),
            "buttonTitle" => $this->input->post("buttonTitle"),
            "buttonUrl" => $this->input->post("buttonUrl"),
            "buttonTarget" => $this->input->post("buttonTarget"),
            "buttonStyle" => $this->input->post("buttonStyle"),
            "buttonColor" => $this->input->post("buttonColor"),
            "buttonHoverColor" => $this->input->post("buttonHoverColor"),
        );
        $resultBannerEdit = $this->Banner_Model->editBanner($dataReceiveFromPost);
        echo json_encode($resultBannerEdit);
    }
    
}
