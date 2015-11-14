<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EvaluationCriteria
 *
 * @author Malith
 */

            
class SimpleQuizEvaluationCriteria extends EvaluationCriteria{
    /*
     * Each option has a corresponding value. 0 for incorrect, 1 for correct.
     * Marking is done by iterating questions and the answers given by the user. 
     */
    
    function __construct() {
        parent::__construct();
        $this->load->model('EvaluationCriteria');
        $this->load->model('Question');
    }


    public function evaluate($usersAnswers,$questionsList){
        $score=0;
        for($i=0;$i<count($usersAnswers);$i++){
            $answer = $questionsList[$i]->getAnswer($usersAnswers[$i]);
            if($answer == "1"){
                $score++;   
            } 
        }
        return ($score/count($usersAnswers))*100;
    }
    
    public function getVerdict($verdictsArray,$score) {
        foreach($verdictsArray as $verdict){
        if($verdict[0]<=$score && $verdict[1]>$score ||$verdict[1]==$score){
                $newVerdict = array();
                $newVerdict[0] = $verdict[2];
                $newVerdict[1] = $verdict[3];
                return $newVerdict;
            }
        }
    }
  
}
