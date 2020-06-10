<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('Verify_Model');
        $this->load->model('Lesson_Model');
    }


    
	public function create($dataReceiveFromPost){
        $this->db->insert("mycourse", $dataReceiveFromPost);
        $courseId =  $this->db->insert_id();
        $this->Activity_Model->save("course-created", $courseId, 1, null, 1, null,null,null,null);
     
      
        /* Enroll adm in a course */
        $this->enrollUserIntoCourse($courseId, 1);

        /* Enroll user creator*/
        if(getUserId() != 1){
            $this->enrollUserIntoCourse($courseId, getUserId());
        }
       
        return $courseId;
    }

  

  
    public function listing(){
        $this->db->select("
            T0.id,
            T0.title,
            T0.photo,
            (SELECT count(DISTINCT mylesson_id ) - 1 FROM relationship WHERE mycourse_id = T0.id ) as lessons,
            (SELECT count(DISTINCT mylesson_id) FROM lesson_status WHERE mycourse_id = T0.id AND myuser_id = ".getUserId()." AND status = 'finished') as finishedLessons
        ");
        $this->db->distinct();
        $this->db->from("mycourse T0");
        $this->db->join("relationship T1", "T0.id = T1.mycourse_id");
        $this->db->where("T1.myuser_id" , getUserId() );
        $this->db->where("T0.id !=", 1);
        $this->db->order_by("T0.id", "DESC");
        $query = $this->db->get();
       
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function listingAll($category){
        if($category == '' OR $category == 1){
            $this->db->select("T0.id,T0.title,T0.description,T0.photo,T0.price,T0.creation_date,T0.release_date,T0.expiration_date,T0.spotlight,T0.validity,T0.preview, T1.name, T2.currency");
            $this->db->from("mycourse T0");
            $this->db->join("myuser T1", "T0.creation_user = T1.id");
            $this->db->join("settings T2", "1 = 1");
            $this->db->where("T0.id !=", 1);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }
        }else{
            $this->db->select("T0.id,T0.title,T0.description,T0.photo,T0.price,T0.creation_date,T0.release_date,T0.expiration_date,T0.spotlight,T0.validity,T0.preview, T1.name, T2.currency");
            $this->db->from("mycourse T0");
            $this->db->join("myuser T1", "T0.creation_user = T1.id");
            $this->db->join("settings T2", "1 = 1");
            $this->db->where("T0.id !=", 1);
            $this->db->where("T0.mycategory_id", $category);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }
        }
    }

   
    public function get($courseId){
        $this->db->select("*");
        $this->db->from("mycourse");
        $this->db->where("id" , $courseId );
        $query = $this->db->get();
       
        if($query->num_rows() > 0){
            return $query->row();
        }
    }

  
    public function progress($courseId){
        $lessons = $this->getLessonsListFromCourse($courseId);
        $lessonList = $lessons["lessons"];

        $numberOfLessons = $lessons["numberOfLessons"]; 
        $completedLessons = $this->getLessonsCompletedByTheUser($lessonList);

        $percentageOfCourseCompleted = (($completedLessons * 100) / $numberOfLessons);
        
        return $percentageOfCourseCompleted;
    }

    public function generateCertificate($courseId){
        $course = $this->get($courseId);
        $certificate = $course->certificate;
        $courseTitle = $course->title;
        $courseId = $course->id;

        $data = array(
            'certificate' => $certificate,
            'myuser_id' => getUserId(),
            'mycourse_id' => $courseId,
            'course' => $courseTitle,
            'date' => getCurrentDate("Y-m-d")
        );
        $this->db->insert("myuser_has_certificate", $data);
    }




    private function getLessonsCompletedByTheUser($responseLessons){
        $where = array();
        foreach($responseLessons as $value){
            array_push($where, $value->mylesson_id);
        };
        $this->db->select("*");
        $this->db->from("lesson_status");
        $this->db->where("myuser_id", getUserId() );
        $this->db->where("status", "finished");
        $this->db->where_in("mylesson_id", $where);
        $query = $this->db->get();
        if($query->num_rows() >= 0){
            return $query->num_rows();
        }   
    }

    private function getLessonsListFromCourse($courseId){
        $this->db->select("mylesson_id");
        $this->db->distinct();
        $this->db->from("relationship");
        $this->db->where("mycourse_id" , $courseId );
        $this->db->where("mylesson_id !=", 1);
        $query = $this->db->get();
       
        if($query->num_rows() > 0){
            $returnData["lessons"] = $query->result();
            $returnData["numberOfLessons"] = $query->num_rows();
            return $returnData;
        }
    }

    public function enrollUserIntoCourse($courseId,$userId){
        if($this->Verify_Model->userIsInCourse($userId, $courseId) == false){
            
            /*  Enroll user into course */
            $userRole =  $this->User_Model->getUserRole($userId);
            $data = array(
                'myuser_id' => $userId,
                'mycourse_id' => $courseId,
                'mymodule_id' => 1,
                'mylesson_id' => 1,
                'mygroup_id' => 1,
                'question_id' => 1,
                'answer_id' => 1,
                'program_id' => 1
            );
            $this->db->insert("relationship", $data);

            /* Enroll this user into all lessons of this course */
            $lessons = $this->getLessonsListFromCourse($courseId);
            if($lessons != null){
                foreach($lessons["lessons"] as $lesson){
                    $lessonId  = $lesson->mylesson_id;
                    $this->Lesson_Model->enrollUserIntoLesson($lessonId, $courseId, $userId);
                }
            }

            /* Course helper */
            $data = array(
                "myuser_id" => $userId,
                "mycourse_id" => $courseId,
                'enroll_date' => getCurrentDate("Y-m-d")
            );
            $this->db->insert("course_helper", $data);
        }
    }

    public function enrollUsersIntoCourse($courseId, $users){
        foreach($users as $userId){
            $this->enrollUserIntoCourse($courseId, $userId);
        }
        return true;
    }

    public function removeUserFromCourse($userId, $courseId){
        $roleId = $this->User_Model->getUserRole($userId);

        /* Remove user from course */
        $this->db->where('myuser_id', $userId);
        $this->db->where('mycourse_id', $courseId);
        $this->db->where('mymodule_id', 1);
        $this->db->where('mylesson_id', 1);
        $this->db->where('mygroup_id', 1);
        $this->db->where('question_id', 1);
        $this->db->where('answer_id', 1);
        $this->db->delete("relationship"); 

        /* Remove user from all lessons of this course */
        $lessons = $this->getLessonsListFromCourse($courseId);
        foreach($lessons["lessons"] as $lesson){
            $lessonId  = $lesson->mylesson_id;
            $deleteResult = $this->Lesson_Model->removeUserFromLesson($lessonId, $courseId, $userId);
        }

        return $deleteResult;
    }

   

	public function edit($dataReceiveFromPost){
        $data = array(
            'title' => $dataReceiveFromPost["title"],
            'description' => $dataReceiveFromPost["description"],
            'photo' => $dataReceiveFromPost["photo"],
            'price' => $dataReceiveFromPost["price"],
            'release_date' => $dataReceiveFromPost["release_date"],
            'expiration_date' => $dataReceiveFromPost["expiration_date"],
            'spotlight' => $dataReceiveFromPost["spotlight"],
            'validity' => $dataReceiveFromPost["validity"],
            'preview' => $dataReceiveFromPost["preview"],
            'comments' => $dataReceiveFromPost["comments"],
            'mycategory_id' => $dataReceiveFromPost["mycategory_id"],
            'certificate' => $dataReceiveFromPost["certificate"],
        );
        $this->db->where("id" , $dataReceiveFromPost["id"]);
        if($this->db->update("mycourse", $data)){
            $this->Activity_Model->save("course-edited", $dataReceiveFromPost["id"], 1, null, 1, null,null,null,null);
            return true;
        }else{
            return false;
        }
    }

    public function delete($courseId){
        $courseTitle = $this->get($courseId)->title;
        $this->Activity_Model->save("course-deleted", 1, 1, null, 1, $courseTitle,null,null,null);

        /* Delete from program_has_mycourse */
        $this->db->where("mycourse_id", $courseId);
        if($this->db->delete("program_has_mycourse") == false){
            return false;
        }

        /* Delete from lesson_status */
        $this->db->where("mycourse_id", $courseId);
        if($this->db->delete("lesson_status") == false){
            return false;
        }

        /* Delete from activities */
        $this->db->where("mycourse_id", $courseId);
        if($this->db->delete("activities") == false){
            return false;
        }
        
        /* Delete from relationship */
        $this->db->where("mycourse_id", $courseId);
        if($this->db->delete("relationship") == false){
            return false;
        }

        /* Delete from mycourse */
        $this->db->where("id", $courseId);
        if($this->db->delete("mycourse") == false){
            return false;
        }
        
        return true;
    }

    public function getPersonsOutsideTheCourse($courseId){
        $this->db->select("T0.id as key, T0.name as label");
        $this->db->distinct();
        $this->db->from("myuser T0");
        $this->db->where("T0.id not in (SELECT myuser_id FROM relationship WHERE mycourse_id = $courseId)");
        $query = $this->db->get(); 
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }


    public function updateCourseStatus($courseId,$status){
        if($status == "finished"){
            $data = array(
                "status" => "finished",
                "end_date" => getCurrentDate("Y-m-d")
            );
        }else{
            $data = array(
                "status" => "in_progress"
            );
        }

        $this->db->where("myuser_id", getUserId());
        $this->db->where("mycourse_id", $courseId);
        $this->db->update("course_helper", $data);
    }
}