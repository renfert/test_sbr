<?php
   function create_cookie(){
    $ci =& get_instance(); $ci->load->helper('database');
    if($ci->input->get("token") AND !isset($_COOKIE[""])){
        setcookie("eadtools_session", "435faefd26bd82ef4d5c095606cd5f8949d00f1d", time() + 7200, "/"); 
    }
}
