<?php

 class NavigationController extends CI_Controller {
        
        function __construct() {
            parent::__construct();
            $this->load->helper("url");
            $this->load->library('session');
            $this->load->model('user');
        }
        
        public function index()
	{          
            
	}
        public function logout(){
            $this->session->sess_destroy();
            redirect('/QuizController/populateQuiz');
        }
        public function loginSignup(){
            if($this->session->userdata('userId')!=null){
                redirect ('NavigationController/dashboard');
            }
            else
                $this->load->view('loginSignupPage');
        }
        public function dashboard(){  
            if($this->session->userdata('userId')!=null){
                $this->load->view('userDashboardPage');
            }
            else 
                redirect ('NavigationController/loginSignup');
        }
        
        public function createQuiz(){
            if($this->session->userdata('userId')!=null)
                redirect('/QuizController/createQuiz');
            else 
                redirect ('NavigationController/loginSignup');
        }
        
    }
