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
        $this->load->view('users.html');
    }

    public function user(){
        $this->load->view('user.html');
    }

    public function site(){
        $this->load->view('site.html');
    }

    public function courses(){
        $this->load->view('courses.html');
    }

    public function newcourse(){
        $this->load->view('newcourse.html');
    }

    public function viewcourse(){
        $this->load->view('viewcourse.html');
    }

    public function dashboard(){
        $this->load->view('dashboard.html');
    }

    public function categories(){
        $this->load->view('categories.html');
    }

    public function certificates(){
        $this->load->view('certificates.html');
    }

    public function corrections(){
        $this->load->view('corrections.html');
    }

    public function editcourse(){
        $this->load->view('editcourse.html');
    }

    public function group(){
        $this->load->view('group.html');
    }

    public function groups(){
        $this->load->view('groups.html');
    }

    public function helpcenter(){
        $this->load->view('helpcenter.html');
    }

    public function integrations(){
        $this->load->view('integrations.html');
    }

    public function newprogram(){
        $this->load->view('newprogram.html');
    }

    public function plans(){
        $this->load->view('plans.html');
    }

    public function product(){
        $this->load->view('product.html');
    }

    public function profile(){
        $this->load->view('profile.html');
    }

    public function programs(){
        $this->load->view('programs.html');
    }

    public function records(){
        $this->load->view('records.html');
    }

    public function settings(){
        $this->load->view('settings.html');
    }

    public function calendar(){
        $this->load->view('calendar.html');
    }

    public function products(){
        $this->load->view('products.html');
    }

    public function leads(){
        $this->load->view('leads.html');
    }
}
