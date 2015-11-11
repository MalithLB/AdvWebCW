<?php 
    
    class HomeController extends CI_Controller {
        
        function __construct() {
            parent::__construct();
            $this->load->model("quiz");
        }
        
        public function index()
	{          
            $data=array();
            $quiz = new Quiz();
            $data['quizzes'] = $quiz->populateQuizList();
            $this->load->view('homePage',$data);
	}
        
    }

?>