<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Builder extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Builder_Model');
    }


    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function listHeader(){
        $headerList = $this->Builder_Model->listHeader();
        echo json_encode($headerList);
    }

    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function listFooter(){
        $footerList = $this->Builder_Model->listFooter();
        echo json_encode($footerList);
    }

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
    public function editFooter(){
        $dataReceiveFromPost = array(
            'copyright' => $this->input->post("copyright"),
            'color' => $this->input->post("color"),
        );
        $resultFooterEdit = $this->Builder_Model->editFooter($dataReceiveFromPost);
        echo json_encode($resultFooterEdit);
    }

    /* 
    =============================================
    Returns: Boolean - TRUE if the edit was successful and FALSE if not.
    ============================================== 
    */
    public function editHeader(){
        $dataReceiveFromPost = array(
            'logoName' => $this->input->post("logoName"),
            'logoStickyName' => $this->input->post("logoStickyName"),
            'logoSize' => $this->input->post("logoSize"),
            'color' => $this->input->post("color"),
        );
        $resultHeaderEdit = $this->Builder_Model->editHeader($dataReceiveFromPost);
        echo json_encode($resultHeaderEdit);
    }

    
}
