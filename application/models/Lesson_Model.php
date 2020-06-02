<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->load->model('Course_Model');
    }
    
   
	public function create($dataArray){
        $lessonType = $dataArray["dataToCreate"]["type_mylesson_id"];
        $moduleId = $dataArray["moduleId"];
        $courseId = $this->getCourseIdByModuleId($moduleId);  
        if($lessonType == 1 OR $lessonType == 2 OR $lessonType == 3 OR $lessonType == 4){
            $fileName = $dataArray["dataToCreate"]["path"];
            $fileExtension = $this->getFileExtension($fileName);
            $dataArray["dataToCreate"]["ext"] = $fileExtension;
        }
        if($lessonType == 5){
            $url = $this->getTalkyRandomUrl();
            $dataArray["dataToCreate"]["url"] = $url;
        }
        $position = $this->getPositionForThisLesson($moduleId);
        $dataArray["dataToCreate"]["position"] = $position;

        $this->db->insert("mylesson",  $dataArray["dataToCreate"]);
        $lessonId = $this->db->insert_id();
        
        $data = array(
            'myuser_id' => 1,
            'mycourse_id' => $courseId,
            'mymodule_id' => $moduleId,
            'mylesson_id' => $lessonId,
            'mygroup_id' => 1,
            'question_id' => 1,
            'answer_id' => 1,
            'program_id' => 1
        );
        $this->db->insert("relationship", $data);
       
        /* Enroll users in this lesson */
        $courseId = $this->getCourseIdByModuleId($moduleId);
        $this->enrollUsersIntoLesson($lessonId, $courseId);

        return $lessonId;

    }

   
    public function edit($dataArray){
        $lessonId = $dataArray["lessonId"];
        $this->db->where("id", $lessonId);
        $this->db->update("mylesson", $dataArray["dataToUpdate"]);
    }

    
    public function enrollUsersIntoLesson($lessonId,$courseId){
        $users = $this->usersAssignedInTheCourse($courseId);
        foreach($users as $row){
            $data = array(
                'myuser_id' => $row->myuser_id,
                'mylesson_id' => $lessonId ,
                'mycourse_id' => $courseId
            );
            $this->db->insert("lesson_status", $data);
        }
    }

    public function enrollUserIntoLesson($lessonId,$courseId,$userId){
        $data = array(
            'myuser_id' => $userId,
            'mylesson_id' => $lessonId ,
            'mycourse_id' => $courseId
        );
        $this->db->insert("lesson_status", $data);
    }

    public function removeUserFromLesson($lessonId,$courseId,$userId){
        $this->db->where("myuser_id", $userId);
        $this->db->where("mylesson_id", $lessonId);
        $this->db->where("mycourse_id", $courseId);
        if($this->db->delete("lesson_status")){
            return true;
        }else{
            return false;
        }

    }


    private function usersAssignedInTheCourse($courseId){   
        $this->db->select("myuser_id");
        $this->db->distinct();
        $this->db->from("relationship");
        $this->db->where("mycourse_id", $courseId);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->result();
        }
    }

   

    private function getTalkyRandomUrl(){
        $part1 = substr(md5(microtime()),1,rand(100,400));
        $part2 = substr(md5(microtime()),1,rand(100,400));
        $part3 = substr(md5(microtime()),1,rand(100,400));
        $url = "https://talky.io/". $part1 . "-" .$part2 ."-" .$part3 ; 
        return $url;
    }

    private function getFileExtension($fileName){
        $words = explode('.', $fileName);
        return $words[1];
    }

    private function getCourseIdByModuleId($moduleId){
        $this->db->select("*");
        $this->db->from("relationship");
        $this->db->where("mymodule_id", $moduleId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result[0]->mycourse_id;
        }
    }

    private function getPositionForThisLesson($moduleId){
        $this->db->select("T0.mycourse_id as courseId,count(T0.mylesson_id) as totalLessons");
        $this->db->from("relationship T0");
        $this->db->where("T0.mymodule_id", $moduleId);
        $this->db->where("T0.mylesson_id !=", 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            $numberOfLessons = $result[0]->totalLessons;
        }

        return $numberOfLessons + 1;
    }

    
	public function reorder($lessons){
        $x = 0;
        foreach($lessons as $key=>$val){
            $lessonId = $key;
            $position = $val;

            $data = array(
                'position' => $position
            );

            $this->db->where("id", $lessonId);
            $this->db->update("mylesson", $data);
        }
    }

    
    
    public function listing($moduleId){
        $this->db->select("T1.id,T1.title,T1.position,T1.path,T1.ext,T1.real_name,T1.date,T1.time,T1.description,T1.url,T1.approval,T1.retest,T1.type_mylesson_id,T1.status, T2.status as lessonStatus");  
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join('mylesson T1', 'T0.mylesson_id = T1.id');
        $this->db->join('lesson_status T2', 'T1.id = T2.mylesson_id');
        $this->db->where("T0.mymodule_id", $moduleId);
        $this->db->where("T1.id !=", 1);
        $this->db->where("T1.status", null);
        $this->db->where("T2.myuser_id", getUserId());
        $this->db->group_by("T1.id");
        $this->db->order_by('position', 'ASC');
      
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

   
    public function get($lessonId){
        $this->db->select("*");  
        $this->db->from("mylesson");
        $this->db->where("id", $lessonId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
    }

    
	public function delete($lessonId){
        /* Delete from relationship */
        $this->db->where('mylesson_id',$lessonId);
        $this->db->delete("relationship");

        /* Delete from lesson_status */
        $this->db->where("mylesson_id", $lessonId);
        $this->db->delete("lesson_status");
        
        /* Delete from mylesson */
        $this->db->where('id',$lessonId);
        $this->db->delete("mylesson");
        return true;
    }


     
    public function finish($lessonId, $studentId){
        $data = array(
            "status" => "finished" 
        );

        $this->db->where("mylesson_id", $lessonId);
        $this->db->where("myuser_id", $studentId );
        $this->db->update("lesson_status", $data);

        $courseId = $this->getCourseIdByLessonId($lessonId);
        $courseProgress = $this->Course_Model->progress($courseId);

        if($courseProgress == 100){
            $this->Course_Model->generateCertificate($courseId);
        }
    }

    private function getCourseIdByLessonId($lessonId){
        $this->db->select("mycourse_id");
        $this->db->distinct();
        $this->db->from("relationship");
        $this->db->where("mylesson_id", $lessonId);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result()[0]->mycourse_id;
        }
    }

    public function getUserRetest($lessonId){
        $this->db->select("T0.retest");
        $this->db->distinct();
        $this->db->from("lesson_status T0");
        $this->db->where("T0.myuser_id", getUserId());
        $this->db->where("T0.mylesson_id", $lessonId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }
}