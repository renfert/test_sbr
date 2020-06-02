<?php
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
 header("Access-Control-Allow-Headers: *");

class Courses extends CI_Controller {
   
    public function __construct(){
        parent::__construct();
        $this->load->helper('error_code');
        $this->load->helper('database');
        $this->load->helper('jwt');
        $this->load->helper('request');
        $this->load->helper('authe');
        $this->load->helper('rest_api');
        $this->courses = array(
        "table" => "`mycourse`",
        "create_types" => "sss",
        "read_fields" => "`id`, `title`, `description`, `price`, `creation_date`, `creation_user`, `release_date`, `expiration_date`, `spotlight`, `validity`",
        "read_key" => "`id`",
        );
    }
    
  
    public function list($param=''){
        /* Verify if a preflight request is send */ 
        if($this->input->method(true) != 'OPTIONS'){

            /* Receiving headers */ 
            $headers = getallheaders();
            
             /* Utf8 encode */ 
            function utf8ize($d) {
                if (is_array($d)) {
                    foreach ($d as $k => $v) {
                        $d[$k] = utf8ize($v);
                    }
                } else if (is_string ($d)) {
                    return utf8_encode($d);
                }
                return $d;
            }

            /* Get the secret from db */
            $dbKeys = getApi();
            foreach($dbKeys as $key){
                $db_secret_key = $key["eadtools_secret_key"];
            }

            /* Verify if id is send */
            if(isset($_GET['id'])){
                $param = $_GET['id'];
            };

            /*  Verify if exist a secret and if the secret is the same */
            if(!isset($headers["Secret"]) OR $headers["Secret"] != $db_secret_key){
                echo json_encode(array(
                    "code" => BAD_DATA,
                    "message" => "Invalid Secret or api key"
                ));
                http_response_code(BAD_DATA);
                return;
            }else{
                /* Verify if a GET method is using */ 
                if($this->input->method(true) != 'GET'){
                    echo json_encode(array(
                        "code" => BAD_HTTP_METHOD,
                        "message" => "Use the HTTP GET method to use this endpoint."
                    ));
                    http_response_code(BAD_HTTP_METHOD);
                    return;
                }else{
                    if($param == ''){
                        $data = readResourceRoot( $this->courses["table"], $this->courses["read_fields"]);
                        if($data == null){
                            echo json_encode(array(
                                "code" => NOT_FOUND,
                                "message" => "No courses found"
                            ));
                            http_response_code(NOT_FOUND);
                        }
                        else{
                            $queryReturn = utf8ize(readResourceRoot($this->courses["table"], $this->courses["read_fields"]));
                            
                            $newObj = array(
                                'apiVersion' => '1.0',
                                'courses' => $queryReturn
                            );
                            echo json_encode($queryReturn);
                        }
                    }
                    else{
                        $data = readResourceElement(
                            $this->courses["table"], $this->courses["read_fields"], $this->courses["read_key"],
                            $param
                        );
                        if($data == false){ 
                            echo json_encode(array(
                                "code" => BAD_DATA,
                                "message" => "No course with this id."
                            ));
                            http_response_code(BAD_DATA);
                        }
                        else{
                            $queryReturn = utf8ize($data);
                            
                            $newObj = array(
                                'apiVersion' => '1.0',
                                'courses' => $queryReturn
                            );
                            echo json_encode($queryReturn[0]);
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
