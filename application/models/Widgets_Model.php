<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH  . "vendor/autoload.php";
use Aws\S3\S3Client;
class Widgets_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->load->model("Verify_Model");
	}

    public function getTotalNumberOfUsers(){
        $this->db->select("COUNT(*) as total");
        $this->db->from("myuser");
        $this->db->where("id !=", 1);
        $query = $this->db->get();
        return $query->result()[0];
    }

  
    public function getTotalNumberOfCourses(){
        $this->db->select("COUNT(*) as total");
        $this->db->from("mycourse");
        $this->db->where("id !=", 1);
        $query = $this->db->get();
        return $query->result()[0];
    }
   
    public function getStorage(){
        $clientS3 = S3Client::factory(array(
            'region' => 'us-east-1', 
            'version' => 'latest',   
            'credentials' => [
                    'key' => 'AKIA5AQZS5JMAWUELDG7',
                    'secret' => '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',
                ]
        ));

        $subDomain = $this->Verify_Model->getSubDomainName();

        $size = 0;
        $bucket = "sabiorealm";
        $objects = $clientS3->getIterator('ListObjects', array(
            "Bucket" => $bucket,
            "Prefix" => $subDomain
        ));
        $i = 0;
        foreach ($objects as $object) {
            $size = $size+$object['Size'];
        }
    
        return $this->formatSizeUnits($size);
    }

    public function formatSizeUnits($bytes) {
        return number_format($bytes / 1073741824, 2);
    }

}