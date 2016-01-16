<?php

class User extends CI_Model{
    
    private $username;
    private $password;
    private $email;
    private $dateOfBirth;
    private $profilePicture;
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("Quiz");
    }
    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getDateOfBirth(){
        return $this->dateOfBirth;
    }
    public function getProfilePicture(){
        return $this->profilePicture;
    }
            
    public function setUsername($username){
        $this->username=$username;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function setEmail($email){
        $this->email = $email;
    }        
    public function setDateOfBirth($dob){
        $this->dateOfBirth = $dob;
    }        
    public function setProfilePicture($profilePic){
        $this->profilePicture = $profilePic;
    }
    public function fetchUser($data){
        $query = $this->db->get_where('user',$data);
        foreach ($query->result() as $row)
        {
            $this->setUsername($row->username);
            $this->setEmail($row->email);
            $this->setDateOfBirth($row->date_of_birth);
            $this->setPassword($row->password);
            $this->setProfilePicture($this->removeSlashes($row->profile_picture));
            return $this;
        }
        
    }
    public function getQuizzesByUser($data){
        $query = $this->db->get_where('quiz',$data);
        $quizzes = array();
        $count = 0;
        foreach ($query->result() as $row)
        {
           $quiz = new Quiz();
           $quiz->setBasicValues($row->quiz_id, $row->quiz_title, $row->type, $row->author,$this->removeSlashes($row->image),$row->category,$row->description,$row->date);
           $quizzes[$count] = $quiz;
           $count++;
        }
        
        return $quizzes;
    }
    public function ifExists($data){
        $query = $this->db->get_where('user',$data);
        return ($query->num_rows>0);
    }
    public function createUser($data){
        $result = $this->db->insert('user',$data);
        $this->setEmail($data['email']);
        return $result;
    }
    public function deleteUser($data){
        $this->db->where($data);
        return $this->db->delete('user');
    }
    public function updateUser($data){
        $this->db->where('email',$data->email);
        $this->db->update('user',$data);
    }
    function removeSlashes($value){
            $value = str_replace("\/", "/",$value);
            $value = str_replace("\'", "'",$value);
            $value = str_replace('\"', '"',$value);
            $value = str_replace('"',"",$value);
            return $value;
        }
    

}
