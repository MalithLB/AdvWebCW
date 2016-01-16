<?php 
    
    class HomeController extends CI_Controller {
        
        function __construct() {
            parent::__construct();
            $this->load->model("quiz");
            $this->load->helper("url");
        }
        
        public function index()
	{          
            
            redirect('/QuizController/populateQuiz');
	}
        
    }

?>