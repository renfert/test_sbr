<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Integrations_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
    
    public function getIntegrations(){
        $this->db->select("*");
        $this->db->from("integrations");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result()[0];
        }
    }


    public function saveAnalytics($id){
        $data = array(
            'ga_id' => $id
        );

        $this->db->update("integrations", $data);
    }

    public function saveFbPixel($id){
        $data = array(
            'fb_id' => $id
        );

        $this->db->update("integrations", $data);
    }

    public function saveTagManager($id){
        $data = array(
            'gtm_id' => $id
        );

        $this->db->update("integrations", $data);
    }

    public function saveMpAccessToken($id){
        $data = array(
            'mp_access_token' => $id
        );

        $this->db->update("integrations", $data);
    }

    public function saveMpPreference($preferenceId){    
        $data = array(
            'preference_id' => $preferenceId
        );

        $this->db->update("integrations", $data);
    }
}