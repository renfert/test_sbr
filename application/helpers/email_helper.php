<?php 


function sendEmail($params){
    $ci =& get_instance(); 
    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'mail.sabiorealm.com',
        'smtp_port' => '587',
        'smtp_user' => 'noreply@sabiorealm.com',
        'smtp_pass' => '5S=P0BT*SwA=C<F&!5J]?}jN@',
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