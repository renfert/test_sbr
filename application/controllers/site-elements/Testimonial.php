<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Testimonial extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('site-elements/Testimonial_Model');
    }

    /* 
    =============================================
    Returns: Id of the last registered testimonial
    ============================================== 
    */
	public function create(){
        $resultTestimonialCreate = $this->Testimonial_Model->create();
        echo json_encode($resultTestimonialCreate);
    }


    /* 
    =============================================
    Returns: Array of objects 
    ============================================== 
    */
    public function get(){
        $sectionId = $this->input->post("sectionId");
        $getTestimonial = $this->Testimonial_Model->get($sectionId);
        echo json_encode($getTestimonial);
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
            'testimonialId' => $this->input->post("testimonialId"),
        );
        $resultTestimonialEdit = $this->Testimonial_Model->edit($dataReceiveFromPost);
        echo json_encode($resultTestimonialEdit);
    }
    
}
