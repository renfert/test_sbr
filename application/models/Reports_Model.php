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

    if ($courses != null) {
      foreach ($courses as $course) {
        $courseTitle = $course->title;
        $groupName = $course->group;

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
              $studentEmail = $student->email;

              // Get exam score
              $examInformation = $this->User_Model->getScoreOnExam($student->id, $exam->id);

              if ($examInformation[0]->retest == 0) {
                $examInformation[0]->status = 'No iniciado';
              } elseif ($examInformation[0]->retest != 0 && $examInformation[0]->status != 'finished') {
                $examInformation[0]->status = 'En progreso';
              } else {
                $examInformation[0]->status = 'Finalizado';
              }

              $obj = array('group' => $groupName, 'course' => $courseTitle, 'examTitle' => $exam->title, 'examApproval' => $exam->approval,   'student' => $studentEmail,   'studentScore' => $examInformation[0]->score, 'status' => $examInformation[0]->status, 'studentRetest' => $examInformation[0]->retest);
              array_push($ar, $obj);
            }
          }
        }
      }
      return $ar;
    }
  }
}
