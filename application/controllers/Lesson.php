<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Lesson extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Lesson_Model');
    }
    

    

    /* 
    =============================================
    This is the main function that receives requests for creating lessons.
    It will redirect you to more specific functions depending on the type of lesson.
    ============================================== 
    */
	public function create(){
        $postInformation = $this->input->post();
        $dataArray = array();
        foreach($postInformation as $key=>$value){
            if($key != "moduleId" && $key != "lessonId" && $key != "file"){
                $dataArray["dataToCreate"][$key] = $value;
            }
        }
        $dataArray["moduleId"] = $this->input->post("moduleId");
        $resultCreateLesson = $this->Lesson_Model->create($dataArray);
        echo json_encode($resultCreateLesson);
    }

   
    /* 
    =============================================
    Returns boolean: TRUE if success and FALSE if failed
    ============================================== 
    */
    public function edit(){
        $postInformation = $this->input->post();
        $dataArray = array();
        foreach($postInformation as $key=>$value){
            if($key != "lessonId" AND $key != "moduleId" && $key != "file"){
                $dataArray["dataToUpdate"][$key] = $value;
            }
        }
        $dataArray["lessonId"] = $this->input->post("lessonId");
        $resultEditLesson = $this->Lesson_Model->edit($dataArray);
        echo json_encode($resultEditLesson);
    }

    public function changeExamStatus(){
        $examId = $this->input->post("examId");
        $data = array(
            'status' => null
        );
        $this->db->where("id", $examId);
        $this->db->update("mylesson", $data);
    }



    /* 
    =============================================
    Returns: Array of objects 
    Obs: The only lesson that we do not list is with ID = 1 because it is a standard lesson used for internal controls.
    ============================================== 
    */
    public function listing(){
        $moduleId = $this->input->post("moduleId");
        $lessonList = $this->Lesson_Model->listing($moduleId);
        echo json_encode($lessonList);
    }

     /* 
    =============================================
    Returns: Object
    ============================================== 
    */
    public function get(){
        $lessonId = $this->input->post("lessonId");
        $lesson = $this->Lesson_Model->get($lessonId);
        echo json_encode($lesson);
    }

     /* 
    =============================================
    Reorder lesson positions
    ============================================== 
    */
	public function reorder(){
        $this->Lesson_Model->reorder($this->input->post("lesson"));
    }

    /* 
    =============================================
    Returns: Boolean - TRUE if the delete was successful and FALSE if not.
    ============================================== 
    */
    public function delete(){
        $lessonId = $this->input->post("lessonId");
        $resultLessonDelete = $this->Lesson_Model->delete($lessonId);
        echo json_encode($resultLessonDelete);
    }

     /* 
    =============================================
    Returns: Boolean 
    ============================================== 
    */
    public function finish(){
        $lessonId = $this->input->post("lessonId");
        $studentId = $this->input->post("studentId");
        $resultLesson = $this->Lesson_Model->finish($lessonId,$studentId);
        echo json_encode($resultLesson);
    }

    public function getUserRetest(){
        $lessonId = $this->input->post("lessonId");
        $retest = $this->Lesson_Model->getUserRetest($lessonId);
        echo json_encode($retest);
    }

    
}
