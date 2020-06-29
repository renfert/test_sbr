<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pages extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->library("pagination");
    }

    private function verifyRole(){
        $this->db->select("*");
        $this->db->from("myuser");
        $this->db->where("id", getUserId());
        $query = $this->db->get();
        $result = $query->result()[0]->myrole_id;
        return $result;
    }

    /* Allow all */
	public function index(){
        $this->load->view('index.html');	    
    }

     /* Allow  adm */
    public function users(){
        if(activeSession()){

            if($this->verifyRole() != 1){
                $this->load->view('404.html');
            }else{
                $this->load->view('users.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow instructor and adm */
    public function user(){
        if(activeSession()){

            if($this->verifyRole() == 3){
                $this->load->view('404.html');
            }else{
                $this->load->view('user.html');
            }

        }else{
            $this->load->view('404session.html');
        }
       
    }

     /* Allow adm */
    public function site(){
        if(activeSession()){

            if($this->verifyRole() != 1){
                $this->load->view('404.html');
            }else{
                $this->load->view('site.html');
            }

        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow all */
    public function courses(){
       if(activeSession()){
            $this->load->view('courses.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow adm and instructor */
    public function newcourse(){
        if(activeSession()){

            if($this->verifyRole() == 3){
                $this->load->view('404.html');
            }else{
                $this->load->view('newcourse.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow all !!! SECURITY ISSUE - ACCESS COURSE FROM SESSION STORAGE */
    public function viewcourse(){
        if(activeSession()){
            $this->load->view('viewcourse.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow all */
    public function dashboard(){
        if(activeSession()){
            $this->load->view('dashboard.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow instructor and adm */
    public function categories(){
        if(activeSession()){

            if($this->verifyRole() == 3){
                $this->load->view('404.html');
            }else{
                $this->load->view('categories.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

     /* Allow adm and student */
    public function certificates(){
        if(activeSession()){

            if($this->verifyRole() == 2){
                $this->load->view('404.html');
            }else{
                $this->load->view('certificates.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow adm and instructors */
    public function corrections(){
        if(activeSession()){

            if($this->verifyRole() == 3){
                $this->load->view('404.html');
            }else{
                $this->load->view('corrections.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow adm and instructor */
    public function editcourse(){
        if(activeSession()){

            if($this->verifyRole() == 3){
                $this->load->view('404.html');
            }else{
                $this->load->view('editcourse.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow adm */
    public function group(){
        if(activeSession()){

            if($this->verifyRole() != 1){
                $this->load->view('404.html');
            }else{
                $this->load->view('group.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow adm */
    public function groups(){
        if(activeSession()){

            if($this->verifyRole() != 1 ){
                $this->load->view('404.html');
            }else{
                $this->load->view('groups.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow all */
    public function helpcenter(){
        if(activeSession()){
            $this->load->view('helpcenter.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow adm */
    public function integrations(){
        if(activeSession()){

            if($this->verifyRole() != 1){
                $this->load->view('404.html');
            }else{
                $this->load->view('integrations.html');
            }

        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow adm and instructor */
    public function newprogram(){
        if(activeSession()){
            if($this->verifyRole() == 3){
                $this->load->view('404.html');
            }else{
                $this->load->view('newprogram.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow adm */
    public function plans(){
        if(activeSession()){

            if($this->verifyRole() != 1){
                $this->load->view('404.html');
            }else{
                $this->load->view('plans.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow all */
    public function product(){
        $this->load->view('product.html');
    }

    /* Allow all */
    public function profile(){  
        if(activeSession()){
            $this->load->view('profile.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow all */
    public function programs(){
        if(activeSession()){
            $this->load->view('programs.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow adm and students */
    public function records(){
        if(activeSession()){

            if($this->verifyRole() == 2){
                $this->load->view('404.html');
            }else{
                $this->load->view('records.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow adm */
    public function settings(){
        if(activeSession()){

            if($this->verifyRole() != 1){
                $this->load->view('404.html');
            }else{
                $this->load->view('settings.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow all */
    public function calendar(){
        if(activeSession()){
            $this->load->view('calendar.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow all */
    public function products(){
        $this->load->view('products.html');
    }

    /* Allow adm */
    public function leads(){
        if(activeSession()){

            if($this->verifyRole() != 1){
                $this->load->view('404.html');
            }else{
                $this->load->view('leads.html');
            }
        }else{
            $this->load->view('404session.html');
        }
    }
    
    /* Allow all */
    public function viewprogram(){
        if(activeSession()){
            $this->load->view('viewprogram.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    /* Allow all */
    public function success(){
        $this->load->view('purchasesuccess.html');
    }

    /* Allow all */
    public function notfound(){
        $this->load->view('404.html');
    }
}
