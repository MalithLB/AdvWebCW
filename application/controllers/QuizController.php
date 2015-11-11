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
        $this->load->model("Quiz");
    }
    public function initializeQuiz(){
        if(isset($_POST['selectedQuiz'])){
            $quiz = new Quiz();
            $quiz->getFullQuiz($_POST['selectedQuiz']);
            $date['message'] = "data";
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
}
