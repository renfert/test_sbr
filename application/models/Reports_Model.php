<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Group_Model');
    $this->load->model('Course_Model');
    $this->load->model('User_Model');
    $this->load->model('Verify_Model');
  }


  /*--------------------------
  Exams report by group id
  ---------------------------*/
  public function getExamsReportsByGroup($groupId)
  {
    $ar = array();
    $courses = $this->Group_Model->getCoursesInsideGroup($groupId);
    // Get all courses from this group

    foreach ($courses as $course) {
      $courseTitle = $course->title;

      $verifyExamsOnCourse = $this->Verify_Model->checkIfThereIsAnExamInThecourse($course->id);

      if ($verifyExamsOnCourse == true) {
        // Get all exams
        $exams = $this->Course_Model->getExams($course->id);
        if ($exams == null) {
          $exams = array();
          $obj = (object) [
            'title' => 'na',
            'approval' => 'na',
            'id' => 0
          ];
          array_push($exams, $obj);
        }
        foreach ($exams as $exam) {
          $examTitle = $exam->title;
          // Get all students from this group
          $students = $this->Group_Model->getStudentsInsideGroup($groupId);
          foreach ($students as $student) {
            $studentName = $student->name;

            // Get exam score
            $examInformation = $this->User_Model->getScoreOnExam($student->id, $exam->id);
            if ($examInformation[0]->status == null) {
              $examInformation[0]->status = 'No iniciado';
            }
            $obj = array('course' => $courseTitle, 'student' => $studentName, 'examTitle' => $exam->title, 'examApproval' => $exam->approval, 'studentScore' => $examInformation[0]->score, 'status' => $examInformation[0]->status, 'studentRetest' => $examInformation[0]->retest);
            array_push($ar, $obj);
          }
        }
      }
    }
    return $ar;
  }
}
