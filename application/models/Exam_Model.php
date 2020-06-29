<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->load->model('Lesson_Model');
    }
    
    public function getExamOverview($examId,$studentId){
        $sql = "
            SELECT(SELECT COUNT(DISTINCT T1.id) from relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id 
            WHERE T0.mylesson_id = $examId AND  T1.id !=1 AND T1.status != 'temporary') AS totalQuestions,
            
            (SELECT COUNT(DISTINCT T1.id) FROM relationship T0 INNER JOIN question T1 on T0.question_id = T1.id INNER JOIN users_answers T2 ON T1.id = T2.question_id WHERE T0.mylesson_id = $examId AND T1.id != 1 AND T1.status != 'temporary' AND T2.score = 100 AND T2.myuser_id =  $studentId ) as totalCorrectQuestions,

            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = $examId AND T1.id != 1 AND T1.status != 'temporary' AND T2.score = 0 AND T2.myuser_id =  $studentId ) as totalWrongQuestions,
            
            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = $examId AND T1.id != 1 AND T1.status != 'temporary' AND T2.score > 50 AND T2.myuser_id =  $studentId ) as totalAboveAverageQuestions,
            
            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = $examId AND T1.id != 1 AND T1.status != 'temporary' AND T2.score < 50 AND T2.score IS NOT NULL AND T2.myuser_id =  $studentId ) as totalBelowAverageQuestions,
            
            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = $examId AND T1.id != 1 AND T1.status != 'temporary' AND T2.score IS NULL AND T2.myuser_id =  $studentId ) as waitingEvaluationQuestions,

            (SELECT DISTINCT score FROM lesson_status WHERE myuser_id = $studentId AND mylesson_id = $examId) as yourScore
        ";

        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

   
	public function finish($answers, $examId){
        $this->clearExam($examId);
        foreach($answers as $id => $answer){
            $questionId = $id;
            $questionType = $this->getQuestionType($id);
            $questionWeight = $this->getQuestionWeight($id);

            if($questionType == 2){
                $this->doAutomaticCorrection($id, $answers[$id]);
            }else{
                $data = array(
                    'myuser_id' => getUserId(),
                    'question_id' =>  $id,
                    'answer' => $answer,
                );
                $this->db->insert("users_answers", $data);

            }
        }

        $this->updateExamRetest($examId);
           
    }

    private function clearExam($examId){
        $this->db->select("*");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->where("T0.mylesson_id", $examId);
        $this->db->where("T0.question_id !=", 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                $questionId = $row->question_id;
                /* Clear all users answers */
                $this->db->where("question_id", $questionId);
                $this->db->where("myuser_id", getUserId());
                $this->db->delete("users_answers");

                /* Clear exam score */
                
                $data = array(
                    'score' => null
                );

                $this->db->where("myuser_id", getUserId());
                $this->db->where("mylesson_id", $examId);
                $this->db->update("lesson_status", $data);
            }
        }
    }

    private function getExamId($questionId){
        $this->db->select("mylesson_id");
        $this->db->distinct();
        $this->db->from("relationship");
        $this->db->where("question_id", $questionId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result()[0]->mylesson_id;
        }
    }

    private function doAutomaticCorrection($questionId, $answers){
        $examId = $this->getExamId($questionId);
        $questionScore = $this->getQuestionScore($questionId, $examId);


        $correctAnswers = $this->getCorrectionAnswers($questionId);
        if(array_count_values($answers) == array_count_values($correctAnswers)){ 
            $this->updateExamScore($questionScore, $examId, getUserId());
            $score = 100;
        }else{
            $score = 0;
            $this->updateExamScore(0, $examId , getUserId());
        }


        foreach($answers as $answer){
            $data = array(
                'myuser_id' => getUserId(),
                'question_id' => $questionId,
                'answer' => $answer,
                'score' => $score
            );
            $this->db->insert("users_answers", $data);
        }


        $currentExamScore = $this->getCurrentExamScore($examId, getUserId());
        $examApproval = $this->get($examId)[0]->approval; 
        if($currentExamScore >= $examApproval){
            $this->Lesson_Model->finish($examId, getUserId());
        }
        
    }   


    public function getQuestionScore($questionId,$examId){
        $weightTotalExam = $this->getTotalWeightOfExam($examId);
        $questionWeight = $this->getQuestionWeight($questionId);
        $questionScore = ((100 * $questionWeight) / $weightTotalExam);
        return $questionScore;
    }

    private function updateExamRetest($examId){
        $retest = $this->getRetest($examId);
        $data = array(
            'retest' => $retest
        );

        $this->db->where("mylesson_id", $examId);
        $this->db->where("myuser_id", getUserId());
        $this->db->update("lesson_status", $data);

    }

    public function updateExamScore($questionScore, $examId, $studentId){
        $currentExamScore = $this->getCurrentExamScore($examId, $studentId);
        $newScore = $currentExamScore + $questionScore;
        
        /* Bug fix */
        if( $newScore >= 98 ){
            $newScore = 100;
        }

       

        $data = array(
            'score' => $newScore,
        );

        $this->db->where("mylesson_id", $examId);
        $this->db->where("myuser_id", $studentId);
        $this->db->update("lesson_status", $data);
    }

    private function getCurrentExamScore($examId, $studentId){
        $this->db->select("T0.score");
        $this->db->distinct();
        $this->db->from("lesson_status T0");
        $this->db->where("T0.myuser_id", $studentId);
        $this->db->where("T0.mylesson_id", $examId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result()[0]->score;
            if($result == null){
                return 0;
            }else{
                return $query->result()[0]->score;
            }
        }
    }


    private function getRetest($examId){    
        $this->db->select("(T0.retest + 1) as retest");
        $this->db->distinct();
        $this->db->from("lesson_status T0");
        $this->db->where("T0.mylesson_id" , $examId);
        $this->db->where("T0.myuser_id", getUserId());
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result()[0]->retest;
        }
    }

    private function getTotalWeightOfExam($examId){
        $weight = 0;
        $this->db->select("T0.id, T0.weight");
        $this->db->distinct();
        $this->db->from("question T0");
        $this->db->join("relationship T1", "T0.id = T1.question_id");
        $this->db->where("T1.mylesson_id" , $examId);
        $this->db->where("T0.id !=", 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
               $weight = $weight + $row->weight;
            }
            return $weight;
        }
    }

    private function getCorrectionAnswers($questionId){
        $correctAnswerArray = array();

        $this->db->select("T1.id");
        $this->db->from("relationship T0");
        $this->db->join("answer T1", "T0.answer_id = T1.id ");
        $this->db->where("T0.question_id = ".$questionId."");
        $this->db->where("T0.answer_id !=", 1);
        $this->db->where("T1.correct", "correct");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                array_push($correctAnswerArray, $row->id);
            }
        }

        return $correctAnswerArray;
    }

    private function getQuestionType($questionId){
        $this->db->select("type_question_id");
        $this->db->from("question");
        $this->db->where("id", $questionId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result()[0]->type_question_id;
        }
    }

    private function getQuestionWeight($questionId){
        $this->db->select("weight");
        $this->db->from("question");
        $this->db->where("id", $questionId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result()[0]->weight;
        }
    }

    public function get($examId){
        $this->db->select("*");
        $this->db->distinct();
        $this->db->from("mylesson");
        $this->db->where("id", $examId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

}