<?php 


function sendEmail($params){
    $ci =& get_instance();
    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'mail.eadtools.com',
        'smtp_port' => '587',
        'smtp_user' => 'support@eadtools.com',
        'smtp_pass' => '7it7eyO3*',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'wordwrap' => TRUE
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
    $ci->email->from('support@eadtools.com', $companyName);
    $ci->email->to($params["email"]);
    $ci->email->subject($json[$subject]);
    $ci->email->message($mesg);
    $ci->email->send();
}

?>