<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->load->model("Exam_Model");
        $this->load->model("Lesson_Model");
    }
    
    

	public function create($dataReceiveFromPost){
        $position = $this->getPositionForThisQuestion($dataReceiveFromPost["examId"]);
        $moduleId = $this->getModuleIdByLessonId($dataReceiveFromPost["examId"]);
        $courseId = $this->getCourseIdByModuleId($moduleId);

        $data = array(
            'weight' => $dataReceiveFromPost["weight"],
            'type_question_id' => $dataReceiveFromPost["type"],
            'image' => $dataReceiveFromPost["questionImageName"],
            'question' => $dataReceiveFromPost["question"],
            'position' => $position,
            'feedback' => $dataReceiveFromPost["feedback"]
        );

        $this->db->insert("question", $data);
        $questionId = $this->db->insert_id();

        $data = array(
            'myuser_id' => 1,
            'mycourse_id' => $courseId,
            'mymodule_id' => $moduleId,
            'mylesson_id' => $dataReceiveFromPost["examId"],
            'mygroup_id' => 1,
            'question_id' => $questionId,
            'answer_id' => 1,
            'program_id' => 1
        );
        $this->db->insert("relationship", $data);
        return $questionId;
    }

	public function createTemporary($dataReceiveFromPost){
        $position = $this->getPositionForThisQuestion($dataReceiveFromPost["examId"]);
        $moduleId = $this->getModuleIdByLessonId($dataReceiveFromPost["examId"]);
        $courseId = $this->getCourseIdByModuleId($moduleId);

        $data = array(
            'weight' => 1,
            'type_question_id' => 1,
            'image' => null,
            'question' => 'temporary',
            'position' => $position,
            'feedback' => null,
            'status' => 'temporary'
        );

        $this->db->insert("question", $data);
        $questionId = $this->db->insert_id();


        $data = array(
            'myuser_id' => 1,
            'mycourse_id' => $courseId,
            'mymodule_id' => $moduleId,
            'mylesson_id' => $dataReceiveFromPost["examId"],
            'mygroup_id' => 1,
            'question_id' => $questionId,
            'answer_id' => 1,
            'program_id' => 1
        );
        $this->db->insert("relationship", $data);
        return $questionId;
    }

    private function getPositionForThisQuestion($examId){
        $this->db->select("count(T0.question_id) as totalQuestions");
        $this->db->from("relationship T0");
        $this->db->where("T0.mylesson_id", $examId);
        $this->db->where("T0.question_id !=", 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            $numberOfQuestions = $result[0]->totalQuestions;
        }

        return $numberOfQuestions + 1;
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


    private function getModuleIdByLessonId($lessonId){
        $this->db->select("*");
        $this->db->from("relationship");
        $this->db->where("mylesson_id", $lessonId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result[0]->mymodule_id;
        }
    }

    private function getLessonIdByQuestionId($questionId){
        $this->db->select("mylesson_id");
        $this->db->distinct();
        $this->db->from("relationship");
        $this->db->where("question_id", $questionId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result[0]->mylesson_id;
        }
    }

    
	public function reorder($modules){
        $x = 0;
        foreach($modules as $key=>$val){
            $moduleId = $key;
            $position = $val;

            $data = array(
                'position' => $position
            );

            $this->db->where("id", $moduleId);
            $this->db->update("mymodule", $data);
        }
    }

    
    
	public function edit($dataReceiveFromPost){
        $questionId = $dataReceiveFromPost["questionId"];
        $question = $dataReceiveFromPost["question"];
        $questionImageName = $dataReceiveFromPost["questionImageName"];
        $type = $dataReceiveFromPost["type"];
        $weight = $dataReceiveFromPost["weight"];
        $feedback = $dataReceiveFromPost["feedback"];
        $status = $dataReceiveFromPost["status"];
    
        $data = array(
            'weight' => $weight,
            'question' => $question,
            'image' => $questionImageName,
            'feedback' => $feedback,
            'type_question_id' => $type,
            'status' => $status,

        );
        $this->db->where("id", $questionId);
        if($this->db->update("question", $data)){
            return true;
        }else{
            return false;
        }
        
    }

    
    
	public function delete($questionId){

        /* Delete question imagem */
        $this->deleteQuestionImage($questionId);

        /* Delete from relationship */
        $this->db->where('question_id',$questionId);
        $this->db->delete("relationship");
        
        /* Delete from question */
        $this->db->where('id',$questionId);
        $this->db->delete("question");
    }

    
   
    private function deleteQuestionImage($questionId){
        $this->db->select("*");
        $this->db->from("question");
        $this->db->where("id", $questionId);  
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result =  $query->result();
            $img = $result[0]->image;
            if($img != null){
                $path ='./assets/uploads/question/'.$img.'';
                echo $path;
                if(file_exists($path)) {
                    unlink($path);
                }
            }
        }
    }
    
    
   
    public function listing($examId){
        $this->db->select("T1.id,T1.feedback, T1.weight, T1.position, T1.question, T1.question, T1.image, T1.type_question_id");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("question T1", "T0.question_id = T1.id");
        $this->db->join("users_answers T2", "T1.id = T2.question_id", "left");
        $this->db->where("T0.mylesson_id", $examId);
        $this->db->where("T1.id !=", 1);
        $this->db->where("T1.status !=", "temporary");
        $this->db->order_by('position', 'ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function avaliateFeedback($questionId,$avaliation){
        $data = array(
            'feedback_useful' => $avaliation
        );

        $this->db->where("question_id", $questionId);
        $this->db->where("myuser_id", getUserId());
        if($this->db->update("users_answers", $data)){
            return true;
        }else{
            return false;
        }
        
    }

    public function correction($dataReceiveFromPost){

        /* Update answer score */
        $data = array(
            "score" => $dataReceiveFromPost["score"],
            "feedback" => $dataReceiveFromPost["feedback"],
            "feedback_user" => getUserId(),   
        );
        $this->db->where("question_id", $dataReceiveFromPost["questionId"]);
        $this->db->where("myuser_id", $dataReceiveFromPost["studentId"]);
        $this->db->update("users_answers", $data);

        /* Update exam score */
        $examId = $this->getLessonIdByQuestionId($dataReceiveFromPost["questionId"]);

        $totalQuestionScore = $this->Exam_Model->getQuestionScore($dataReceiveFromPost["questionId"], $examId);
        $questionScore = (($totalQuestionScore * $dataReceiveFromPost["score"]) / 100);

        $this->Exam_Model->updateExamScore($questionScore, $examId, $dataReceiveFromPost["studentId"]);
      
        /* Verify if the lesson is finished */
        $examOverview = $this->Exam_Model->getExamOverview($examId,$dataReceiveFromPost["studentId"]);
        $waitingEvaluationQuestions = $examOverview[0]->waitingEvaluationQuestions;
        $userScore = $examOverview[0]->yourScore;

        $exam = $this->Exam_Model->get($examId);
        $examApproval = $exam[0]->approval;

        if($userScore >= $examApproval){
            echo $examId;
            echo $dataReceiveFromPost["studentId"];
            $this->Lesson_Model->finish($examId, $dataReceiveFromPost["studentId"]);
        }

    }

   
}