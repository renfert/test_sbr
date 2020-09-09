<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model("Verify_Model");
    $this->load->model("Payment_Model");
    $this->load->model('Course_Model');
  }

  /*
  =============================================
  Mercado pago payment process
  ==============================================
  */
  public function process()
  {
    if (count($_POST) > 1) {
      $preferenceId = $this->input->post("preference_id");
      $courseId = $this->input->post("external_reference");
      $paymentId = $this->input->post("payment_id");
      $paymentStatus = $this->input->post("payment_status");
      $preferenceValidity = $this->Verify_Model->checkPreferenceValidity($preferenceId);

      if ($preferenceValidity == true) {

        if ($paymentStatus == "approved") {
          $this->Payment_Model->savePurchaseRequisition($courseId, $paymentId, $paymentStatus);
          $this->Course_Model->enrollUserIntoCourse($courseId, getUserId());
          if (production()) {
            header('Location: ' . base_url() . 'purchase/success/' . $courseId . '');
          } else {
            header('Location: http://localhost:8080/purchase/success/' . $courseId . '');
          }
        }

        if ($paymentStatus == "in_process" or $paymentStatus == "pending") {
          $this->Payment_Model->savePurchaseRequisition($courseId, $paymentId, $paymentStatus);
          if (production()) {
            header('Location: ' . base_url() . 'purchase/pending/' . $courseId . '');
          } else {
            header('Location: http://localhost:8080/purchase/pending/' . $courseId . '');
          }
        }
      } else {
        // Redirect to 404 page
      }
    } else {
      // Redirect to 404 page
    }
  }

  /*
  =============================================
    Paypal payment process
  ==============================================
  */
  public function processPaypal()
  {
    $transactionId = $this->input->post("transactionId");
    $transactionStatus = $this->input->post("transactionStatus");
    $courseId = $this->input->post("courseId");
    $preferenceValidity = $this->Verify_Model->checkPreferenceValidity($transactionId);


    if ($preferenceValidity == true) {
      if ($transactionStatus == "COMPLETED") {
        $this->Payment_Model->savePurchaseRequisition($courseId, $transactionId, $transactionStatus);
        $this->Course_Model->enrollUserIntoCourse($courseId, getUserId());
        echo json_encode(true);
      }
    }
  }


  /*
    =============================================
       Verify paymentss
    ==============================================
    */
  public function verify_payments()
  {
    $this->load->model("payments");
    $this->load->model("tolist");
    $apps = $this->tolist->apps();
    $this->load->model('toedit');
    $this->toedit->payment_open($apps);
  }
}
