<?php


function sendEmail($params){
    $ci =& get_instance();
    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'email-smtp.us-east-1.amazonaws.com',
        'smtp_user' => 'AKIA5AQZS5JMANAL7M46',
        'smtp_pass' => 'BDhVlJi08Sigf23SvDejcgY5eVfaVinyxRB14MfdNXsS',
        'smtp_port' => '465',
        'smtp_crypto' => 'ssl',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n",
        'wordwrap' => TRUE,
    );


    /*  Get settings */
    $ci->load->model('Settings_Model');
    $settings = $ci->Settings_Model->getSettingsInformation();
    $companyName = $settings->name;
    $lang = $settings->lang;

    /* Get a language file */
    $url = base_url('/application/language/'.$lang.'/lang.json');
    $str = file_get_contents($url);
    $json = json_decode($str, true); // decode the JSON into an associative array


    /* Get all parameters */
    $subject = $params["subject"];
    $data['title'] = $companyName;
    foreach($params as $key=>$value){
        $data[$key] = $value;
    }

    $dataToEmail = array("data" => $data);
    $ci->load->library('email', $config);
    $mesg = $ci->load->view('email/'.$params["template-email"].'', $dataToEmail, true);
    $ci->email->from('noreply@sabiorealm.com', $companyName);
    $ci->email->to($params["email"]);
    $ci->email->subject($json[$subject]);
    $ci->email->message($mesg);
    $ci->email->send();
}

?>