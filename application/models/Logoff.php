<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logoff extends CI_Model {

    function __construct(){
        parent::__construct();  
        $this->load->helper('url');
    }

    
    /* 
    =============================================
    Logoff and session end
    ============================================== 
    */
	public function logoff($start_time){

        $userId = $this->session->userdata('id');
         
        $data = array(
            'status' => 'off'
        );

        $this->db->where('id', $userId);
        $this->db->update('myuser', $data);
        
        if($this->session->userdata('group') == 'administrator'){
            $grp = 1;
        }
        if($this->session->userdata('group') == 'instructor'){
            $grp = 2;
        }
        if($this->session->userdata('group') == 'student'){
            $grp = 3;
        }
        $entrada = $start_time;
        $saida = date('h:i:s');
        $data = date('Y-m-d');
        $month = date("M");
        $hora1 = explode(":",$entrada);
        $hora2 = explode(":",$saida);
        if(is_numeric($hora1[0]) && is_numeric($hora1[1]) && is_numeric($hora1[2]) && is_numeric($hora2[0]) && is_numeric($hora2[1]) && is_numeric($hora2[2])){
            $acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
            $acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
            $resultado = $acumulador2 - $acumulador1;
            $hora_ponto = floor($resultado / 3600);
            $resultado = $resultado - ($hora_ponto * 3600);
            $min_ponto = floor($resultado / 60);
            $resultado = $resultado - ($min_ponto * 60);
            $secs_ponto = $resultado;   
            //Grava na variável resultado final/
    
    
            $tempo = (($hora_ponto * 60) + $min_ponto);
            $sessMin = ceil($tempo);
            if($sessMin < 0 ){
                $sessMin = 30;
            }
        }else{
            $sessMin = 30;
        }

        $data = array(
            'date' => $data,
            'duration' => $sessMin,
            'month' => $month,
        );
        $this->db->insert("my_session",$data);
        $sessionId = $this->db->insert_id();

        $data = array(
            'myuser_id' => $userId,
            'myuser_group_id' => $grp,
            'session_id' => $sessionId
        );
        $this->db->insert("myuser_has_session", $data);

        $this->session->sess_destroy();
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['avatar']);
        unset($_SESSION['group']);
        unset($_SESSION['company']);
        echo "<script>window.location.href='".site_url('pages/index')."'</script>";
	}
}
?>