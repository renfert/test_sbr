<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verify_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("Widgets_Model");
  }

  public function userIsInCourse($userId, $courseId)
  {
    $this->db->select("myuser_id");
    $this->db->distinct();
    $this->db->from("relationship");
    $this->db->where("myuser_id", $userId);
    $this->db->where("mycourse_id", $courseId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function checkIfThereIsAnExamInThecourse($courseId)
  {
    $this->db->select("T1.title");
    $this->db->distinct();
    $this->db->from("relationship T0");
    $this->db->join("mylesson T1", "T0.mylesson_id = T1.id");
    $this->db->where("T1.type_mylesson_id", 8);
    $this->db->where("T0.mycourse_id", $courseId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function stepsStatus()
  {
    $this->db->select("*");
    $this->db->from("first_steps");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    }
  }

  public function verifyIfCourseHasAlreadyBeenEvaluated($courseId)
  {
    $this->db->select("*");
    $this->db->from("reviews");
    $this->db->where("mycourse_id", $courseId);
    $this->db->where("myuser_id", getUserId());
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function checkPreferenceValidity($preferenceId)
  {
    $this->db->select("*");
    $this->db->from("integrations");
    $query = $this->db->get();
    $result = $query->result();
    $preferenceIdInDataBase = $result[0]->preference_id;

    if (md5($preferenceId) == $preferenceIdInDataBase) {
      return true;
    } else {
      return false;
    }
  }

  public function checkStorageAvailability()
  {
    $usedStorage = $this->Widgets_Model->getStorage();
    $plan = $this->getPlan();



    /*------------
        Basic plan
        ------------*/
    if ($plan == "basic") {
      $availableStorage = 32;
    }

    /*------------
        Pro plan
        ------------*/
    if ($plan == "pro") {
      $availableStorage = 64;
    }


    /*------------
        Growt plan
        ------------*/
    if ($plan == "growt") {
      $availableStorage = 128;
    }

    /*------------
        Bussiness plan
        ------------*/
    if ($plan == "bussiness") {
      $availableStorage = 512;
    }


    if ($usedStorage >= $availableStorage) {
      return false;
    } else {
      return true;
    }
  }

  public function correctAnswerExist($questionId)
  {
    $this->db->select("T0.id");
    $this->db->distinct();
    $this->db->from("answer T0");
    $this->db->join("relationship T1", "T1.answer_id = T0.id");
    $this->db->where("T1.question_id", $questionId);
    $this->db->where("T0.id !=", 1);
    $this->db->where("T0.correct IS NOT NULL", NULL, FALSE);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  private function getPlan()
  {
    $this->db->select("*");
    $this->db->from("mycompany");
    $query = $this->db->get();
    $plan = $query->result()[0]->plan;
    return $plan;
  }

  public function courseReleased($courseId)
  {
    $currentDate = getCurrentDate("Y-m-d");
    $this->db->select("DATEDIFF(T0.release_date, '$currentDate') as releaseDays");
    $this->db->from("mycourse T0");
    $this->db->where("id", $courseId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $releaseDays = $query->result()[0]->releaseDays;
      return $releaseDays;
    }
  }

  public function courseExpiration($courseId)
  {
    $currentDate = getCurrentDate("Y-m-d");
    $this->db->select("DATEDIFF(T0.expiration_date, '$currentDate') as expirationDays,");
    $this->db->from("mycourse T0");
    $this->db->where("id", $courseId);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $expirationDays = $query->result()[0]->expirationDays;
      return $expirationDays;
    }
  }

  public function getSubDomainName()
  {
    $this->db->select("*");
    $this->db->from("mycompany");
    $query = $this->db->get();
    $result = $query->result();
    return $result[0]->subdomain;
  }

  public function verifyUserCreate($role)
  {
    $plan = $this->getPlan();

    /* Total students and instructors */
    $this->db->select("(SELECT COUNT(*) FROM myuser WHERE myrole_id = 2 ) as instructors, (SELECT COUNT(*) FROM myuser WHERE myrole_id = 3 ) as students");
    $query = $this->db->get();
    $totalInstructors = $query->result()[0]->instructors;
    $totalStudents = $query->result()[0]->students;

    /* Basic plan */
    if ($plan == "basic") {
      if ($role == "Instructor") {
        if ($totalInstructors >= 1) {
          return false;
        }
      }

      if ($role == "Student") {
        if ($totalStudents >= 50) {
          return false;
        }
      }
    }


    /* Pro plan */
    if ($plan == "basic") {
      if ($role == "Instructor") {
        if ($totalInstructors >= 3) {
          return false;
        }
      }

      if ($role == "Student") {
        if ($totalStudents >= 100) {
          return false;
        }
      }
    }

    /* Growt plan */
    if ($plan == "growt") {

      if ($role == "Instructor") {
        if ($totalInstructors >= 5) {
          return false;
        }
      }

      if ($role == "Student") {
        if ($totalStudents >= 300) {
          return false;
        }
      }
    }

    /* Bussiness plan */
    if ($plan == "bussiness") {

      if ($role == "Instructor") {
        if ($totalInstructors >= 100) {
          return false;
        }
      }

      if ($role == "Student") {
        if ($totalStudents >= 5000) {
          return false;
        }
      }
    }

    /* Trial plan */
    if ($plan == "trial") {

      if ($role == "Instructor") {
        if ($totalInstructors >= 1) {
          return false;
        }
      }

      if ($role == "Student") {
        if ($totalStudents >= 50) {
          return false;
        }
      }
    }

    return true;
  }

  public function verifyValidityOfJwt($jwtReceived)
  {

    $secret = $this->getJwtSecret();
    $payloadReceived = $this->getJwtPayload($jwtReceived);
    $jwt = $this->createJwt($secret, $payloadReceived);
    $userEmail = json_decode(base64_decode($payloadReceived))->email;

    if ($jwtReceived == $jwt) {
      $this->doAuthentication($userEmail);
      return true;
    } else {
      return false;
    }
  }

  private function getJwtSecret()
  {
    $this->db->select("*");
    $this->db->from("jwt");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $secret = $query->result()[0]->signature;
      return $secret;
    }
  }

  private function doAuthentication($userEmail)
  {
    $this->db->select("*");
    $this->db->from("myuser");
    $this->db->where("email", $userEmail);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $userId = $row->id;
        $userName = $row->name;
        $userEmail = $row->email;
        $userRole = $row->myrole_id;
      }
      $this->startSession($userName, $userId, $userEmail, $userRole);

      $info = array(
        "last_login" => getCurrentDate("Y-m-d H:i"),
        "status" => "on",
      );
      $this->db->where('id', $userId);
      $this->db->update("myuser", $info);
      $this->Activity_Model->save("login", 1, 1, null, 1, null, null, null, null);


      return true;
    } else {
      return false;
    }
  }

  private function startSession($userName, $userId, $userEmail, $userRole)
  {
    $sessionData = array(
      'username' => $userName,
      'id' => $userId,
      'email' => $userEmail,
      'role' => $userRole,
    );
    $this->session->set_userdata($sessionData);
    return $this->session->userdata;
  }

  private function getJwtPayload($jwtReceived)
  {
    $arr = explode('.', $jwtReceived);
    $payload =  $arr[1];
    return $payload;
  }

  private function createJwt($secret, $base64UrlPayload)
  {

    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

    // Encode Header to Base64Url String
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));


    // Create Signature Hash
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);

    // Encode Signature to Base64Url String
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));


    // Create JWT
    $token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

    return $token;
  }
}
