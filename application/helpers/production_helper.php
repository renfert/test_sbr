<?php
function production()
{
  if ($_SERVER['HTTP_HOST'] == 'localhost') {
    return false;
  } else {
    return true;
  }
}

function getUserId()
{
  $CI = &get_instance();
  if (production() == false) {
    return 1;
  } else {
    return $CI->session->userdata("id");
  }
}

function activeSession()
{
  $CI = &get_instance();
  if (production() == false) {
    return true;
  } else {
    $sess_id = $CI->session->userdata('id');
    if ($sess_id) {
      return true;
    } else {
      return false;
    }
  }
}
