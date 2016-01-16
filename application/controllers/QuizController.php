
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuizController
 *
 * @author Malith
 */
class QuizController extends CI_Controller{
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model("Quiz");
        $this->load->library('session');
        $this->load->model("User");
    }
    public function populateQuiz(){
        $data=array();
        $quiz = new Quiz();
        $data['quizzes'] = $quiz->populateQuizList();
        $this->load->view('homePage',$data);
    }
    public function initializeQuiz(){
        if(isset($_POST['selectedQuiz'])){
            $quiz = new Quiz();
            $quiz->getFullQuiz($_POST['selectedQuiz']);
            $date['message'] = "data";           
            $this->load->helper('url');
            $this->load->view("quizPage",array('quiz'=>$quiz,'status'=>'okay'));
        }
    }
    public function evaluateQuiz(){
        
        $quiz = new Quiz();
        $quiz->getFullQuiz($_POST['selectedQuiz']);
        $answersString ="{".$_POST['answersJSON']."}";
        $quiz->setAnswersList($answersString);
        $quiz->evaluate();
        $verdict = $quiz->getVerdict();
        $this->load->view("displayResultsPage",array('quiz'=>$quiz,'verdict'=>$verdict));
    }
    public function searchQuiz(){
        $data=array();
        if(isset($_POST['searchString'])&&$_POST['searchString']!=""){
            $quiz = new Quiz();
            $data['quizzes'] = $quiz->searchQuizzes($_POST['searchString'],"SEARCH");
            $this->load->view('displayQuizzesPage',$data);
        }else{
            $data['quizzes'] = array();
            $this->load->view('displayQuizzesPage',$data);
        }
        
    }
    public function searchQuizByCategory(){
        $data=array();
        if(isset($_POST['category'])&&_POST['category']!=""){
            $quiz = new Quiz();
            $data['quizzes'] = $quiz->searchQuizzes($_POST['category'],"CATEGORY");
            $this->load->view('displayQuizzesPage',$data);
        }
        else{
            $data['quizzes'] = array();
            $this->load->view('displayQuizzesPage',$data);
        }
    }
    
    public function viewAnswers(){
       
        $quiz = new Quiz();
        $quiz->getFullQuiz($this->session->userdata('quizId'));
        
        $answersList = json_decode($this->session->userdata('answersList'));
        $answersString = "{";
        for($i=1;$i<=count($answersList);$i++){
            $answersString = $answersString.'"'.$i."\":\"".$answersList[$i-1];
            if($i!=count($answersList)) $answersString = $answersString."\",";
        }
        $answersString = $answersString."\"}";
        $quiz->setAnswersList($answersString);
        $quiz->evaluate();
        $data = array();
        $data['quiz'] = $quiz;
        $correctAnswers = $quiz->getEvaluationCriteria()->getCorrectAnswers($quiz->getQuestionsList());
        $data['correctAnswers'] = $correctAnswers;
        
        $data['quizStats'] = $quiz->getEvaluationCriteria()->getAverage();
        $quiz->getEvaluationCriteria()->updateAverage($quiz->getScore(),$quiz->getId());
        $this->load->view('viewAnswersPage',$data);
    }
    
    public function createQuiz(){
        if($this->session->userdata('userId')!=null){
            $user = new User();
            $data = array('user'=>$user);
            $this->load->view('createQuizPage',$data);
        }else 
            $this->load->view('homePage');
    } 
    
    public function addOutcomes(){
        
        if($this->session->userdata('userId')!=null && $this->session->userdata('quizId')){
                
            $quiz = new Quiz();
            $quiz->fetchBasicQuiz(array('quiz_id'=>$this->session->userdata('quizId')));
            $verdict = $quiz->fetchVerdicts(array('quiz_id'=>$quiz->getId()));
            $data = array('quiz'=>$quiz,'userId'=>$this->session->userdata('userId'),'verdict'=>$verdict);
            $this->load->view('addOutcome',$data);
        }
    }
    
    public function addQuestion(){
        if($this->session->userdata('userId')!=null && $this->session->userdata('quizId')){
            $quiz = new Quiz();
            
            $data = array('quiz_Id'=>$this->session->userdata('quizId'));
            $quiz->fetchBasicQuiz($data);
            $data = array('quizId'=>$this->session->userdata('quizId'),'type'=>$quiz->getType());
            $this->load->view('addQuestionPage',$data);
        }
    }
    
    public function editQuestions(){
        if($this->session->userdata('userId')!=null && $this->session->userdata('quizId')){
            $this->load->view('editQuestionsPage');
        }
    }
    public function reviewQuiz(){

        if($this->session->userdata('userId')!=null && $this->session->userdata('quizId')){
            $quiz = new Quiz();
            $quiz->fetchBasicQuiz(array('quiz_id'=>$this->session->userdata('quizId')));
            $data = $data = array('quiz'=>$quiz,'userId'=>$this->session->userdata('userId'));
            $this->load->view('reviewQuizPage',$data);
        }
    }
    public function addQuizIdToSession(){
        $json = json_decode(file_get_contents('php://input'));
    
        if($json->quiz_id!=null){
            $this->session->set_userdata('quizId',$json->quiz_id);
        }
    }
    
}
