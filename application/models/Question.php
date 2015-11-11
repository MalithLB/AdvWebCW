<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Question
 *
 * @author Malith
 */
class Question extends CI_Model {
    private $questionNumber;
    private $question;
    private $choicesMatrix = array();
    private $image;
    
    public function setQuestionNumber($number){
        $this->questionNumber = $number;
    }
    public function getQuestionNumber(){
        return $this->questionNumber;
    }
    public function setQuestion($questionString){
        $this->question=$questionString;
        return $this;
    }
    
    public function getQuestion(){
        return $this->question;
    }
    public function setChoicesMatrix($optionsBlock){
        $string = $optionsBlock;
        $result = json_decode($string,true);
        $i=0;
        foreach($result as $option){
            $this->choicesMatrix[$i] = $option;
            $i++;
        }
    } 
    public function getNumberOfChoices(){
        return count($this->choicesMatrix);
    }
    public function getChoicesMatrix(){
        return $this->choicesMatrix;
    }
    public function setImage($image){
        $this->image= $image;
    }
    public function getImage(){
        return $this->image;
    }
    public function getAnswer($selectedChoice){
        
        for($i=0;$i<count($this->choicesMatrix);$i++){
            if($this->choicesMatrix[$i][0]==$selectedChoice)
                return $this->choicesMatrix[$i][1];
        }
        return "Invalid choice!";
    }
    public function prepareQuestion($questionNumber,$question,$choicesBlock,$image){
        $this->setQuestionNumber($questionNumber);
        $this->setQuestion($question);
        $this->setImage($image);
        $this->setChoicesMatrix($choicesBlock);
    }
}
