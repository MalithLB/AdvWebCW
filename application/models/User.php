<?php

class User extends CI_Model{
    
    private $username;
    private $password;
    private $email;
    private $dateOfBirth;
    private $profilePicture;
    
    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getEmail(){
        return $this->email;
    }
    public function get(){
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
}
