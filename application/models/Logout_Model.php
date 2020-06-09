<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout_Model extends CI_Model {

    function __construct(){
        parent::__construct();  
        $this->load->helper('url');
    }

    public function doLogout(){
        $data = array(
            "status" => "off",
        );
        $this->db->where('id',getUserId());
        $this->db->update("myuser",$data);
        $this->Activity_Model->save("logout", 1, 1, null, 1, null,null,null,null);
        $this->session->sess_destroy();
        $this->load->view('index.html');
    }
    
}
?>