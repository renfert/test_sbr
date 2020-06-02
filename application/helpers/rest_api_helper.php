<?php

function __construct(){
  $ci->load->library("database");
  $ci->load->library("email");
}

/**
 * Restful API helper, implementing generic CRUD methods.
 * The helper relies heavily upon the Database and Error Code helpers
 * provided with it.
 * ---------------------------------------------------------------------
 */

/**
 * Creates a new collection, using a query to the database.
 * @return a JSON object with an error message
 */
function createResourceRoot(){
  $ci =& get_instance(); $ci->load->helper('error_code');
  return array(
    "code" => PROHIBITED,
    "message"=>"Creating a new resource collection is prohibited."
  );
}

/**
 * Creates a new entry in a collection, using a query to the database.
 * @param $table - The database table to query.
 * @param $input_fields - An array of names for the fields to be filled.
 * @param $input_types - A string that contains one or more characters
 *  which specify the types for the corresponding fields.
 * @param $input_values - An array of values for the fields to be filled.
 * @return the id of the newly-created collection member
 */
function createResourceElement($table, $input_fields, $input_types, $input_values){
  // Load the appropriate helpers
  $ci =& get_instance(); $ci->load->helper('database'); $ci->load->helper('error_code');
  $input_fields_count = count($input_fields);
  $input_values_count = count($input_fields);

  if ($input_fields_count != $input_values_count)
    return array(
      "code" => BAD_DATA,
      "message"=>"The number of values provided does not match the number of fields."
    );

  $input_fields_squashed = implode(",", $input_fields);
  $input_fields_questionmarks = implode(",",array_fill(0,$input_values_count,"?"));

  return database_query(
    "INSERT INTO ".$table." (".$input_fields_squashed.") VALUES (".$input_fields_questionmarks.")",
    $input_types, $input_values,
    "INSERT"
  );
}

/**
 * Lists the members of a collection, using a query to the database.
 * @param $table - The database table to query.
 * @param $fields - The table's fields to be retrieved.
 * @return a collection of elements
 */
function readResourceRoot($table, $fields){
  // Load the appropriate helpers
  $ci =& get_instance(); $ci->load->helper('database');
  return database_no_args_query(
    "SELECT ".$fields." FROM ".$table
  );
}

/**
 * Retrieves a specific member of a collection, using a query to the database.
 * @param  $table - The database table to query.
 * @param $fields - The table's fields to be retrieved.
 * @param $element_key - The table's field that will be used for the specific
 *  resource's indentification.
 * @param $key_value - The value to be used for the specific resource's
 *  identification.
 * @return a list of members or false
 */
function readResourceElement($table, $fields, $element_key, $key_value){
  // Load the appropriate helpers
  $ci =& get_instance(); $ci->load->helper('database');
  return database_query(
    "SELECT ".$fields." FROM ".$table." WHERE ".$element_key."=?",
    "s", [$key_value]
  );
}

/**
 * Updates a resource collection, using a query to the database.
 * @return a JSON object with an error message
 */
function updateResourceRoot(){
  // Load the appropriate helpers
  $ci =& get_instance(); $ci->load->helper('error_code');
  return array(
    "code" => PROHIBITED,
    "message"=>"Updating a resource collection is prohibited."
  );
}

/**
 * Updates a specific member of a collection, using a query to the database.
 * @param  $table - The database table to query.
 * @param $input_fields - An array of names for the fields to be updated.
 * @param $input_types - A string that contains one or more characters
 *  which specify the types for the corresponding fields.
 * @param $input_values - An array of values for the fields to be updated.
 * @param $element_key - The table's field that will be used for the specific
 *  resource's indentification.
 * @param $key_value - The value to be used for the specific resource's
 *  identification.
 * @return the number of affected rows
 */
function updateResourceElement($table, $input_fields, $input_types, $input_values, $element_key, $key_value){
  // Load the appropriate helpers
  $ci =& get_instance(); $ci->load->helper('database'); $ci->load->helper('error_code');
  $input_fields_count = count($input_fields);
  $input_values_count = count($input_fields);

  if ($input_fields_count != $input_values_count)
  return array(
    "code" => BAD_DATA,
    "message"=>"The number of values provided does not match the number of fields."
  );

  $input_fields_squashed = implode("=?, ", $input_fields)."=?";
  $input_values[] = $key_value;

  return database_query(
    "UPDATE ".$table." SET ".$input_fields_squashed."  WHERE ".$element_key."=?",
    $input_types."s", $input_values,
    "UPDATE"
  );
}



/**
 * Deletes a resource collection, using a query to the database.
 * @return a JSON object with an error message
 */
function deleteResourceRoot(){
  // Load the appropriate helpers
  $ci =& get_instance(); $ci->load->helper('error_code');
  return array(
    "code" => PROHIBITED,
    "message"=>"Deleting a resource collection is prohibited."
  );
}

/**
 * Deletes a specific member of a collection, using a query to the database.
 * @param  $table - The database table to query.
 * @param $element_key - The table's field that will be used for the specific
 *  resource's indentification.
 * @param $key_value - The value to be used for the specific resource's
 *  identification.
 * @return the number of affected rows
 */
function deleteResourceElement($table, $element_key, $key_value){
  // Load the appropriate helpers
  $ci =& get_instance(); $ci->load->helper('database');
  return database_query(
    "DELETE FROM ".$table." WHERE ".$element_key."=?",
    "s", [$key_value],
    "DELETE"
  );
}

/**
 * Get the eadtools secret and api key's
 * 
 */
function getApi(){
    $ci =& get_instance(); $ci->load->helper('database');
    $query = "SELECT eadtools_secret_key FROM apps";
    $result = database_no_args_query($query);
    return $result;
}

/**
 * Get a array with all courses
 * 
 */
function getCourses($param){
  $ci =& get_instance(); $ci->load->helper('database');
  if($param == ''){
    $query = "SELECT * FROM mycourses";
  }else{
    $query = "SELECT * FROM mycourse WHERE id = $param";
  }
  $result = database_no_args_query($query);
  return $result;
}


/**
 * Get a array with all users
 * 
 */
function getUsers($param){
  $ci =& get_instance(); $ci->load->helper('database');
  if($param == ''){
    $query = "SELECT id,name,email,group_id,last_login,description,facebook,twitter,linkedin,mode FROM myuser";
  }else{
    $query = "SELECT * FROM myuser WHERE id = $param";
  }
  $result = database_no_args_query($query);
  return $result;
}

/**
 * Get a array with all courses of specific user
 * 
 */
function getPurchasedCourses($id){
  $ci =& get_instance(); $ci->load->helper('database');
  $query = "SELECT  T1.id as id, T1.title as title, T2.value as price_paid, T1.price as price_current, T2.transaction_date as purchase_date, T2.transaction_status as status, T0.enroll_date as enroll_date, T0.finish_date as finish_date  FROM user_has_course T0
  INNER JOIN mycourse T1 ON T0.course_id = T1.id 
  INNER JOIN payments T2 ON T0.user_id = T2.user_id
  WHERE T0.user_id = $id AND T1.id = T2.course_id";
  $result = database_no_args_query($query);
  return $result;
}

function getEnrolledCourses($id){
  $ci =& get_instance(); $ci->load->helper('database');
  $query = "SELECT  T1.id as id, T1.title as title, T1.price as price_current ,T0.enroll_date as enroll_date, T0.finish_date as finish_date  FROM user_has_course T0
  INNER JOIN mycourse T1 ON T0.course_id = T1.id 
  WHERE T0.user_id = $id";
  $result = database_no_args_query($query);
  return $result;
}

function sendUserEmail($params){
  $ci =& get_instance();
  $name = $params["name"];
  $email = $params["email"];
  $password = $params["password"];
  $domain = $params["domain"];
  
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

  $ci->load->library('email', $config);
  // User information
  
  $dados['email'] = $email;
  $dados['name'] = $name;
  $dados['password'] = $password;
  $dados['domain'] = $domain;
  $mesg = $ci->load->view('email/register_api',$dados,true);
  $ci->email->from('support@eadtools.com');
  $ci->email->to($email);
  $ci->email->subject('¡Su cuenta fue creada con éxito!');
  $ci->email->message($mesg);
  $ci->email->send();
}
?>
