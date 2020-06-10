<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pages extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->library("pagination");
    }


	public function index(){
        $this->load->view('index.html');	    
    }

    public function users(){
        if(activeSession()){
            $this->load->view('users.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function user(){
        if(activeSession()){
            $this->load->view('user.html');
        }else{
            $this->load->view('404session.html');
        }
       
    }

    public function site(){
        if(activeSession()){
            $this->load->view('site.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function courses(){
       if(activeSession()){
            $this->load->view('courses.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function newcourse(){
        if(activeSession()){
            $this->load->view('newcourse.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function viewcourse(){
        if(activeSession()){
            $this->load->view('viewcourse.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function dashboard(){
        if(activeSession()){
            $this->load->view('dashboard.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function categories(){
        if(activeSession()){
            $this->load->view('categories.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function certificates(){
        if(activeSession()){
            $this->load->view('certificates.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function corrections(){
        if(activeSession()){
            $this->load->view('corrections.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function editcourse(){
        if(activeSession()){
            $this->load->view('editcourse.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function group(){
        if(activeSession()){
            $this->load->view('group.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function groups(){
        if(activeSession()){
            $this->load->view('groups.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function helpcenter(){
        if(activeSession()){
            $this->load->view('helpcenter.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function integrations(){
        if(activeSession()){
            $this->load->view('integrations.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function newprogram(){
        if(activeSession()){
            $this->load->view('newprogram.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function plans(){
        if(activeSession()){
            $this->load->view('plans.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function product(){
        $this->load->view('product.html');
    }

    public function profile(){
        if(activeSession()){
            $this->load->view('profile.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function programs(){
        if(activeSession()){
            $this->load->view('programs.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function records(){
        if(activeSession()){
            $this->load->view('records.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function settings(){
        if(activeSession()){
            $this->load->view('settings.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function calendar(){
        if(activeSession()){
            $this->load->view('calendar.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function products(){
        $this->load->view('products.html');
    }

    public function leads(){
        if(activeSession()){
            $this->load->view('leads.html');
        }else{
            $this->load->view('404session.html');
        }
    }
    
    public function viewprogram(){
        if(activeSession()){
            $this->load->view('viewprogram.html');
        }else{
            $this->load->view('404session.html');
        }
    }

    public function success(){
        $this->load->view('purchasesuccess.html');
    }

    public function notfound(){
        $this->load->view('404.html');
    }
}
