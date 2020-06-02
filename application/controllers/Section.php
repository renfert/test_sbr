<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Section extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Section_Model');
    }


    /* 
    =============================================
    Reorder section positions
    ============================================== 
    */
	public function reorder(){
        $this->Section_Model->reorder($this->input->post("sections"));
    }


    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function listing(){
        $sectionList = $this->Section_Model->listing();
        echo json_encode($sectionList);
    }

    
    
    /* 
    =============================================
    Returns: Boolean - TRUE if the delete was successful and FALSE if not.
    ============================================== 
    */
    public function delete(){
        $sectionId = $this->input->post("sectionId");
        $resultSectionDelete = $this->Section_Model->delete($sectionId);
        echo json_encode($resultSectionDelete);
    }
}
