<?php
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
 header("Access-Control-Allow-Headers: *");
/**
 * This is a sample implementation of a RESTful API. The database contains a
 * `users` table with four columns (`user_id`, `username`, `password` and
 * `email`).
 */
class Users extends CI_Controller {
   
    public function __construct(){
        parent::__construct();
        $this->load->helper('error_code');
        $this->load->helper('database');
        $this->load->helper('request');
        $this->load->helper('rest_api');
        $this->users = array(
        "table" => "`myuser`",
        "create_fields" => ["`name`", "`password`", "`email`", "`group_id`" , "`mode`",  "`avatar`"],
        "create_types" => "ssssss",
        "read_fields" => "`id`, `name`, `email`, `group_id`, `last_login`, `description`, `facebook`, `twitter`, `linkedin`, `mode`",
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
        
            /* Getting secret from db */ 
            $dbKeys = getApi();
            foreach($dbKeys as $key){
                $db_secret_key = $key["eadtools_secret_key"];
            }

            /* Verify if exist an id */ 
            if(isset($_GET['id'])){
                $param = $_GET['id'];
            };

            /*  Verify if exist a secret and if the secret is the same */ 
            if(!isset($headers["Secret"]) OR $headers["Secret"] != $db_secret_key){
                echo json_encode(array(
                    "code" => BAD_DATA,
                    "message" => "Invalid Secret key"
                ));
                http_response_code(BAD_DATA);
                return;
            }else{
                /* Verify if a GET method is using */ 
                if($this->input->method(true) != 'GET'){
                    echo json_encode(array(
                        "code" => BAD_HTTP_METHOD,
                        "message" => "Use the HTTP GET method in this endpoint."
                    ));
                    http_response_code(BAD_HTTP_METHOD);
                    return;
                }else{
                    if($param == ''){
                        $data = readResourceRoot( $this->users["table"], $this->users["read_fields"]);
                        if($data == null){
                            echo json_encode(array(
                                "code" => NOT_FOUND,
                                "message" => "No users found"
                            ));
                            http_response_code(NOT_FOUND);
                            return;
                        }
                        else{
                            $users = getUsers($param = '');

                            foreach($users as $ind => $usr){
                                $userId = $usr["id"];
                               /* Current position in users array */ 
                                $thisArray = $users[$ind];
        
                                /* Iterate over getEnrolledCourses object */ 
                               
                                if($obj = getEnrolledCourses($userId)){
                                    foreach ($obj as $course){
                                        $id = $course["id"];
                                        $title = $course["title"];
                                        $price_current = $course["price_current"];
                                        $enroll_date = $course["enroll_date"];
                                        $finish_date = $course["finish_date"]; 
        
                                        /*  Create new array with all courses enrolled information */ 
                                        $newObjEnrolled[] = array(
                                            'id' => $id,
                                            'title' => $title,
                                            'price_current' => $price_current,
                                            'enroll_date' => $enroll_date,
                                            'finish_date' => $finish_date
                                        );      
                                    }
                                    
                                    /*  Create a new array called enrolled_courses with courses array */ 
                                    $enrolledCourseObj = array(
                                        'enrolled_courses' => $newObjEnrolled
                                    );
                                } else{
                                    /*  Create a empty object */ 
                                    $enrolledCourseObj = array(
                                        'enrolled_courses' => null
                                    );
                                }
                                
                                /*  Iterate over getPurchasedCourses object */ 
                                
                                if($obj = getPurchasedCourses($userId)){
                                    foreach($obj as $course){
                                        $id = $course["id"];
                                        $title = $course["title"];
                                        $price_paid = $course["price_paid"];
                                        $price_current = $course["price_current"];
                                        $purchase_date = $course["purchase_date"];
                                        $status = $course["status"];
                                        $enroll_date = $course["enroll_date"];
                                        $finish_date = $course["finish_date"];
                                    
                                        /*  Create new array with all courses information */ 
                                        
                                        $newObj[] = array(
                                            'id' => $id,
                                            'title' => $title,
                                            'price_paid' => $price_paid,
                                            'price_current' => $price_current,
                                            'purchase_date' => $purchase_date,
                                            'status' => $status,
                                            'enroll_date' => $enroll_date,
                                            'finish_date' => $finish_date
                                        );                
                                    }
                                
                                    /*  Create a new array called purchased_courses with courses array */ 
                                   
                                    $courseObj = array(
                                        'purchased_courses' => $newObj
                                    );
                                }else{
                                    /*  Create a null obj */ 
                                    $courseObj = array(
                                        'purchased_courses' => null
                                    );
                                }
                                /*  New array that is a merge of current users array and a courses array's  */ 
                                $c = array_merge($thisArray, $enrolledCourseObj, $courseObj);
                                $users[$ind] = $c;
                            }
                            $newObj = array(
                                'apiVersion' => '0.1.0',
                                'users' => utf8ize($users)
                            );
                            echo json_encode(utf8ize($users));

                        }
                    }
                    else{
                        $data = readResourceElement(
                            $this->users["table"], $this->users["read_fields"], $this->users["read_key"],
                            $param
                        );
                        if($data == false){ 
                            echo json_encode(array(
                                "code" => BAD_DATA,
                                "message" => "No user with this id."
                            ));
                            http_response_code(BAD_DATA);
                            return false;
                        }
                        else{
                            $users = getUsers($param);
                            foreach($users as $ind => $usr){
                                $userId = $usr["id"];
                               /* Current position in users array */ 
                                $thisArray = $users[$ind];
        
                                /* Iterate over getEnrolledCourses object */ 
                               
                                if($obj = getEnrolledCourses($userId)){
                                    foreach ($obj as $course){
                                        $id = $course["id"];
                                        $title = $course["title"];
                                        $price_current = $course["price_current"];
                                        $enroll_date = $course["enroll_date"];
                                        $finish_date = $course["finish_date"]; 
        
                                        /*  Create new array with all courses enrolled information */ 
                                        $newObjEnrolled[] = array(
                                            'id' => $id,
                                            'title' => $title,
                                            'price_current' => $price_current,
                                            'enroll_date' => $enroll_date,
                                            'finish_date' => $finish_date
                                        );      
                                    }
                                    
                                    /*  Create a new array called enrolled_courses with courses array */ 
                                    $enrolledCourseObj = array(
                                        'enrolled_courses' => $newObjEnrolled
                                    );
                                } else{
                                    /*  Create a empty object */ 
                                    $enrolledCourseObj = array(
                                        'enrolled_courses' => null
                                    );
                                }
                                
                                /*  Iterate over getPurchasedCourses object */ 
                                
                                if($obj = getPurchasedCourses($userId)){
                                    foreach($obj as $course){
                                        $id = $course["id"];
                                        $title = $course["title"];
                                        $price_paid = $course["price_paid"];
                                        $price_current = $course["price_current"];
                                        $purchase_date = $course["purchase_date"];
                                        $status = $course["status"];
                                        $enroll_date = $course["enroll_date"];
                                        $finish_date = $course["finish_date"];
                                    
                                        /*  Create new array with all courses information */ 
                                        
                                        $newObj[] = array(
                                            'id' => $id,
                                            'title' => $title,
                                            'price_paid' => $price_paid,
                                            'price_current' => $price_current,
                                            'purchase_date' => $purchase_date,
                                            'status' => $status,
                                            'enroll_date' => $enroll_date,
                                            'finish_date' => $finish_date
                                        );                
                                    }
                                
                                    /*  Create a new array called purchased_courses with courses array */ 
                                   
                                    $courseObj = array(
                                        'purchased_courses' => $newObj
                                    );
                                }else{
                                    /*  Create a null obj */ 
                                    $courseObj = array(
                                        'purchased_courses' => null
                                    );
                                }
                                /*  New array that is a merge of current users array and a courses array's  */ 
                                $c = array_merge($thisArray, $enrolledCourseObj, $courseObj);
                                $users[$ind] = $c;
                            }
                            $newObj = array(
                                'apiVersion' => '0.1.0',
                                'users' => utf8ize($users)
                            );
                            echo json_encode(utf8ize($users[0]));
                        }
                    }
                }
            }
        }
    }


    public function send($param=''){
        /* Verify if a preflight request is send */ 
        if($this->input->method(true) != 'OPTIONS'){
            /* Receiving headers */ 
            $headers = getallheaders();
            
            /* Getting secret from db */ 
            $dbKeys = getApi();
            foreach($dbKeys as $key){
                $db_secret_key = $key["eadtools_secret_key"];
            }
            /*  Verify if exist a secret and if the secret is the same */ 
            if(!isset($headers["Secret"]) OR $headers["Secret"] != $db_secret_key){
                echo json_encode(array(
                    "code" => BAD_DATA,
                    "message" => "Invalid Secret or api key"
                ));
                http_response_code(BAD_DATA);
                return;
            }else{

                 /* Verify if a POST method is using */ 
                if($this->input->method(true) != 'POST'){
                    echo json_encode(array(
                        "code" => BAD_HTTP_METHOD,
                        "message" => "Use the HTTP POST method in this endpoint."
                    ));
                    http_response_code(BAD_HTTP_METHOD);
                    return;
                }else{

                    /* Receive post data information */

                    $control = 0; 

                    if($entityBody = file_get_contents('php://input')){
                        if($obj = json_decode($entityBody)){
                            if(property_exists($obj, 'domain') AND property_exists($obj, 'name') AND property_exists($obj, 'password') AND property_exists($obj, 'email') AND property_exists($obj, 'group_id') AND $obj->group_id != 1){
                                $domain = $obj->domain;
                                $name = $obj->name;
                                $password = $obj->password;
                                $email = $obj->email;
                                $groupId = $obj->group_id;
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
                                        case 'domain':
                                            $domain = $param[1];
                                            $cont++;
                                            break;
                                        case 'name':
                                            $name = $param[1];
                                            $cont++;
                                            break;
                                        case 'password':
                                            $password = $param[1];
                                            $cont++;
                                            break;
                                        case 'group_id':
                                            $groupId = $param[1];
                                            $cont++;
                                            break;
                                        case 'email':
                                            $email = $param[1];
                                            $cont++;
                                            break;
                                    }    
                                }
                            }

                            if($cont != 5){
                                $control++;
                            }
                        }
                    }else{
                        if(isset($_POST['domain']) AND isset($_POST['name']) AND isset($_POST['password']) AND isset($_POST['email']) AND isset($_POST['group_id']) AND $_POST['group_id'] != 1){
                            $domain = $_POST["domain"];
                            $name = $_POST["name"];
                            $password = $_POST["password"];
                            $email = $_POST["email"];
                            $groupId = $_POST["group_id"];
                        }else{
                            $control++;
                        }
                    }

                    if($control != 0){
                        echo json_encode(array(
                            "code" => BAD_DATA,
                            "message" => "name, email, group_id, domain and password are required fields."
                        ));
                        http_response_code(BAD_DATA);
                        return;
                    }else{
                        $params = array(
                            'email' => $email,
                            'password' => $password,
                            'name' => $name,
                            'domain' => $domain
                        );
                        sendUserEmail($params);
                        echo json_encode(createResourceElement(
                            $this->users["table"], $this->users["create_fields"], $this->users["create_types"],
                            [$name,md5($password),$email,$groupId, "enable", "default.png"]
                        ));
                        http_response_code(CREATED); 
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
