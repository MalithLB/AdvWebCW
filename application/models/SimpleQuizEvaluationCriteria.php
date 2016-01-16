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
     * Each option has a corresponding value. WRONG for incorrect, CORRECT for correct.
     * Marking is done by iterating questions and the answers given by the user. 
     */
    
    function __construct() {
        parent::__construct();
        $this->load->model('EvaluationCriteria');
        $this->load->model('Question');
        $this->load->database();
    }


    public function evaluate($usersAnswers,$questionsList){
        $score=0;
        for($i=0;$i<count($usersAnswers);$i++){
            $answer = $questionsList[$i]->getAnswer($usersAnswers[$i]);
            if($answer == "CORRECT"){
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
    public function getCorrectAnswers($questionsList){
        $answers = array();
        for($i=0;$i<count($questionsList);$i++){
            $choicesMatrix = $questionsList[$i]->getChoicesMatrix();
            for($j=0;$j<$questionsList[$i]->getNumberOfChoices();$j++){
                $answer = $questionsList[$i]->getAnswer($choicesMatrix[$j][0]);
                if($answer == "CORRECT"){
                    $answers[$i] = $choicesMatrix[$j][0];
                }
            }
        }
        return $answers;
    }
    
    public function getAverage(){
        $this->db->select('average, times_taken');
        $query = $this->db->get('quiz');
        $data = array();
        foreach($query->result() as $row){
            $data['average']=$row->average;
            $data['times_taken']=$row->times_taken;
        }
        return $data;
    }
    public function updateAverage($score,$quizId){
        $data = $this->getAverage();
        $this->db->where('quiz_id',$quizId);
        $data['average'] = ($data['average']*$data['times_taken']+$score)/($data['times_taken']+1);
        $data['times_taken'] = $data['times_taken']+1;
        $this->db->update('quiz',$data);
    }
}
