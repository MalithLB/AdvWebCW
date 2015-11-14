<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Quiz
 *
 * @author Malith
 */



class Quiz extends CI_Model {
    
    //put your code here
    private $id;
    private $title;
    private $author;
    private $questionsList = array();//question objects array
    private $answersList = array();//users answers with question indexes
    private $evaluationCriteria; //simple, multi axis
    private $type; //simple multi answer
    private $category;
    private $score; 
    private $coverImage; 
    private $verdictsArray;//{"verdict1":[text,image],..} or for simple quiz {0:[lowerMargin,upperMargin,text,image]}
    private $description;
    private $date;
    
    function __construct() {
        parent::__construct();
        $this->load->model("Question");
        $this->load->model("EvaluationCriteria");
        $this->load->model("SimpleQuizEvaluationCriteria");
        $this->load->model("MultiAxisEvaluationCriteria");
        //$this->load->helper("Quiz");
        $this->load->database();
    }
    
    public function evaluate(){
        $this->score = $this->evaluationCriteria->evaluate($this->answersList,$this->questionsList);
    }
    public function getVerdict(){
        return $this->evaluationCriteria->getVerdict($this->verdictsArray,$this->score);      
    }
    public function setBasicValues($id,$title,$type,$author,$image,$category,$description,$date){
        $this->setId($id);
        $this->setTitle($title);
        $this->setAuthor($author);
        $this->setType($type);
        $this->setCoverImage($image);
        $this->setCategory($category);
        $this->setDescription($description);
        $this->setDate($date);
    }
    public function getFullQuiz($id){
        $queryString = "Select * from Quiz WHERE quiz_id=".$id; 
        $query = $this->db->query($queryString);
        $quiz = new Quiz();
        foreach ($query->result() as $row)
        {
            $this->setBasicValues($row->quiz_id, $row->quiz_title, $row->type, $row->author,$row->image,$row->category,$row->description,$row->date);
            $verdictsBlock = json_decode($row->verdict,true);
            $i=0;
            foreach($verdictsBlock as $verdict){
                $this->verdictsArray[$i]=$verdict;
                $i++;
            }    
        }
        if($this->type=="SIMPLE"){
            $this->evaluationCriteria = new SimpleQuizEvaluationCriteria();
        }
        else{
            $this->evaluationCriteria = new MultiAxisEvaluationCriteria();
        }
        $this->prepareQuestionsList($this->id);
        
    }
    public function searchQuizzes($queryParam,$type){
       
        $queryString = "Select * from Quiz"; 
        if($type=="CATEGORY"){
            $queryString = "SELECT * FROM Quiz WHERE category LIKE '%".$queryParam."%'";  
           
        }
        if($type=="SEARCH"){
            $queryString = "SELECT * FROM Quiz WHERE category LIKE '%".$queryParam."%' OR quiz_title LIKE '%".$queryParam."%'";
        }
        $query = $this->db->query($queryString);
        $quizes = array();
        $i=0;
        foreach ($query->result() as $row)
        {
            $newQuiz = new Quiz();
            $newQuiz->setBasicValues($row->quiz_id, $row->quiz_title, $row->type, $row->author,$row->image,$row->category,$row->description,$this->date);
            $quizes[$i] = $newQuiz;
            $i++;
        }
        return $quizes;
            
    }
    private function prepareQuestionsList($id){
        $queryString = "Select * from Questions WHERE quiz_id=".$id; 
        $query = $this->db->query($queryString);
        $i=0;
        foreach($query->result() as $row){
            $question = new Question();
            $question->prepareQuestion($row->question_id, $row->question, $row->choices, $row->image);
            $this->questionsList[$i] = $question;
            $i++;
        }
    }
    
    public function populateQuizList(){
        $queryString = "Select * from Quiz"; 
        $query = $this->db->query($queryString);
        $quizes = array();
        $i=0;
        foreach ($query->result() as $row)
        {
            $newQuiz = new Quiz();
            $newQuiz->setBasicValues($row->quiz_id, $row->quiz_title, $row->type, $row->author,$row->image,$row->category,$row->description,$this->date);
            $quizes[$i] = $newQuiz;
            $i++;
        }
        return $quizes;
    }
    
    public function sortList($list){
        for($i=0;$i<count($list);$i++){
           
            for($j=0;$j<count($list)-1;$j++){
                
                if($list[$j]->getQuestionNumber()>$list[$j+1]->getQuestionNumber()){
                    $tempObject = $list[$j+1];
                    $list[$j+1] = $list[$j];
                    $list[$j] = $tempObject;
                }
            }
        }
        return $list;
    }
    
    public function sortAnswers($list){       
        $list = json_decode($list);  
        
        $sortedList = array();
        for($i=1;$i<=count($this->questionsList);$i++){
            $sortedList[$i-1]=$list->{$i};
        }
        return $sortedList;
    }
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function setTitle($title){
        $this->title=$title;
    }
    public function getAuthor(){
        return $this->author;
    }
    public function setAuthor($author){
        $this->author = $author;
    }
    public function getType(){
        return $this->type;
    }
    public function setType($type){
        $this->type = $type;  
    }
    public function setCoverImage($image){
        $this->coverImage=$image;
    }
    public function getCoverImage(){
        return $this->coverImage;
    }
    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description = $description;
    }
    public function setCategory($category){
        $this->category = $category;
    }
    public function getCategory(){
        return $this->category;
    }
    public function getQuestionsList(){
        return $this->questionsList;
    }
    public function getQuestion($id){
        foreach($this->questionsList as $question){
           if($question->getQuestionNumber()==$id){
               return $question;
           }
        }
    }
    public function setAnswersList($answersList){
        $this->answersList=$this->sortAnswers($answersList);
    }
    public function getAnswersList(){
        return $this->answersList;
    }
    
    public function setDate($date){
        $this->date=$date;
    }
    public function getDate(){
        return $this->date;
    }
    public function getScore(){
        return $this->score;
    }
    public function getQuestionsAsJSON(){
        $jsonString = "{";
        $j=0;
        foreach($this->questionsList as $question){
            $jsonString=$jsonString.'"'.$question->getQuestionNumber().'":';
            $jsonString=$jsonString.'["'.$question->getQuestion().'","'.preg_replace('/\s+/', '', $question->getImage()).'","'.
                    $question->getNumberOfChoices().'",["';
            $choices = $question->getChoicesMatrix();
            for($i=0;$i<$question->getNumberOfChoices();$i++){
                $jsonString=$jsonString.$choices[$i][0];
                if($i!=$question->getNumberOfChoices()-1)   
                    $jsonString=$jsonString.'","';
            }
            $j++;
            if($j<count($this->questionsList)) $jsonString=$jsonString.'"]],';
            else $jsonString=$jsonString.'"]]}';
            
        }
        return $jsonString;
    }
}
