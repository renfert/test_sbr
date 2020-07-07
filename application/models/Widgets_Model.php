<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH  . "vendor/autoload.php";
use Aws\S3\S3Client;
class Widgets_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->load->model("Verify_Model");
        $this->load->model("User_Model");
    }
    

    public function getTotalNumberOfStudents(){
        $coursesId = array();
        $enrolledCourses = $this->User_Model->getEnrolledCourses(getUserId());
        foreach ($enrolledCourses as $key => $value) {
            $courseId = $value->id;
            array_push($coursesId, $courseId);
        }
        $this->db->select("COUNT(DISTINCT T1.id) as totalStudents");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("myuser T1", "T0.myuser_id = T1.id");
        $this->db->where("T1.myrole_id", 3);
        $this->db->where_in("T0.mycourse_id", $coursesId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result()[0]->totalStudents;
        }
    }

    public function getTotalNumberOfUsers(){
        $this->db->select("COUNT(*) as total");
        $this->db->from("myuser");
        $this->db->where("id !=", 1);
        $query = $this->db->get();
        return $query->result()[0]->total;
    }

  
    public function getTotalNumberOfCourses(){
        $this->db->select("DISTINCT COUNT(DISTINCT mycourse_id) as totalCourses");
        $this->db->from("relationship T0");
        $this->db->where("T0.mycourse_id !=", 1);
        $this->db->where("T0.myuser_id", getUserId());
        $query = $this->db->get();
        return $query->result()[0]->totalCourses;
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