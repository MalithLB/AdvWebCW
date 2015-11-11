<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MultiAxisEvaluationCriteria
 *
 * @author Malith
 * 
 * This is for evaluating multiple outcome quizzes like buzzfeed's 'which GOT charachter are you?'.
 * Each possible outcome can be identified as an axis i.e.: Daenerys Targaryen, Hordor, Joeffry Baratheon etc.
 * The most relavent outcome is the axis with the highest value.
 */

class MultiAxisEvaluationCriteria extends EvaluationCriteria{
    
    private $outcomesMatrix = array(); //{'outcome',number of instances}
    
    function __construct() {
        parent::__construct();
        $this->load->model("Question");
    }


    public function evaluate($usersAnswers,$questionsList){
        $this->identifyOutcomes($questionsList);
        
        for($i=0;$i<count($usersAnswers);$i++){
            $key = $questionsList[$i]->getAnswer($usersAnswers[$i]);
            $this->outcomesMatrix[$key]++;
            
        }
        return $this->findTheHighestAxis();
    } 
    public function getVerdict($verdictsArray,$score) {

        foreach($verdictsArray as $verdict){
            if($verdict[0]==$score){
                $newVerdict = array();
                $newVerdict[0] = $verdict[1];
                $newVerdict[1] = $verdict[2];
                return $newVerdict;
            }
        }
    }
    private function identifyOutcomes($questionsList){
         for($i=0;$i<count($questionsList);$i++){
             $choicesMatrix = $questionsList[$i]->getChoicesMatrix();
             for($j=0;$j<count($choicesMatrix);$j++){
                if(!array_key_exists($choicesMatrix[$j][1],$this->outcomesMatrix)){
                    $this->outcomesMatrix[$choicesMatrix[$j][1]]=0;
                } 
             }
         }
    }
   
    private function findTheHighestAxis(){
        $highestKey;
        $highestValue=0;
        foreach($this->outcomesMatrix as $key => $value){
            if($value>$highestValue){
                $highestValue = $value;
                $highestKey = $key;
            }
        }
        return $highestKey;
    }
}
