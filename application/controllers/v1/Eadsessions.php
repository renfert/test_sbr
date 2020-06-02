<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: *");

class Eadsessions extends CI_Controller {
   
    public function __construct(){
        parent::__construct();
        $this->load->helper('error_code');
        $this->load->helper('database');
        $this->load->helper('rest_api');
    }

    
    public function new(){
        /* Verify if a preflight request is send */ 
        if($this->input->method(true) != 'OPTIONS'){
            $headers = getallheaders();
            
            /* Get the secret from db */
            $dbKeys = getApi();
            foreach($dbKeys as $key){
                $db_secret_key = $key["eadtools_secret_key"];
            } 
            
            /* Check the secret key */
            if(!isset($headers["Secret"]) OR $headers["Secret"] != $db_secret_key){
                echo json_encode(array(
                    "code" => BAD_DATA,
                    "message" => "Invalid Secret key"
                ));
                http_response_code(BAD_DATA);
                return;
            }else{

                /* Check the method */
                if($this->input->method(true) != 'POST'){
                    echo json_encode(array(
                        "code" => BAD_HTTP_METHOD,
                        "message" => "Use the HTTP POST method to use this endpoint."
                    ));
                    http_response_code(BAD_HTTP_METHOD);
                    return;
                }
                else{
                    /* Receive post data information */

                    $control = 0; 

                    if($entityBody = file_get_contents('php://input')){
                        if($obj = json_decode($entityBody)){
                            if(property_exists($obj, 'email') AND property_exists($obj, 'password')){
                                $email = $obj->email;
                                $password = $obj->password;
                            }else{
                                $control++;
                            }
                        }else{
                            $query  = urldecode($entityBody);
                            $cont = 0;
                            foreach (explode('&', $query) as $chunk) {
                                $param = explode("=", $chunk);
                                if ($chunk) {
                                    $el = $param[0];
                                    switch ($el) {
                                        case 'email':
                                            $email = $param[1];
                                            $cont++;
                                            break;
                                        case 'password':
                                            $password = $param[1];
                                            $cont++;
                                            break;
                                    }    
                                }
                            }

                            if($cont != 2){
                                $control++;
                            }
                        }
                    }else{
                        if(isset($_POST['email']) AND isset($_POST['password'])){
                            $email = $_POST["email"];
                            $password = $_POST["password"];
                        }else{
                            $control++;
                        }
                    }

                    if($control != 0){
                        echo json_encode(array(
                            "code" => BAD_DATA,
                            "message" => "email and password are required fields."
                        ));
                        http_response_code(BAD_DATA);
                        return;
                    }else{
                        // Company information
                        $query = $this->db->query("SELECT * FROM mycompany");
                        $result = $query->result();
                        $companyName = $result[0]->name;
                        $companyPlan = $result[0]->plan;


                        $this->db->where("email", $email);
                        $this->db->where("password", md5($password));
                        $result = $this->db->get("myuser");

                        if($result->num_rows() > 0){
                            foreach($result->result() as $row){
                                $id = $row->id;
                                $email = $row->email;
                                $group = $row->group_id;
                                if($group == 1){
                                    $groupName = "administrator";
                                }
                                if($group == 2){
                                    $groupName = "instructor";
                                }
                                if($group == 3){
                                    $groupName = "student";
                                }
                                $username = $row->name;
                                $avatar = $row->avatar;
                                

                                $newdata = array(
                                    'username' => $username,
                                    'id' => $id,
                                    'email' => $email,
                                    'avatar' => $avatar,
                                    'group' => $groupName,
                                    'company'=> $companyName,
                                    'plan' => $companyPlan
                                );
                            
                                $this->session->set_userdata($newdata);
                                $token =  session_id();

                                $newAr = array(
                                    'id' => $id,
                                    'email' => $email,
                                    'username' => $username,
                                    'token' => $token
                                );
                                echo json_encode($newAr);
                                http_response_code(SUCCESS); 
                            }
                        }else{
                            echo json_encode(array(
                                "code" => BAD_CREDENTIALS,
                                "message" => "incorrect email or password"
                            ));
                            http_response_code(BAD_CREDENTIALS);
                        }
                        
                    }
                }
            }
        }
    }


    /**
    * Index method for completeness. Returns a JSON response with an
    * error message.
    */
    public function index(){
        header('Content-Type: application/json');
        echo json_encode(array(
            "code" => BAD_DATA,
            "message"=>"No resource specified."
        ));
    }
}
?>
