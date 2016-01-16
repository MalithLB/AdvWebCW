<?php

    class Rest extends CI_Controller {

        function __construct() {
            parent::__construct();
            $this->load->model('user');
            $this->load->model('quiz');
            $this->load->model('question');
            $this->load->library('session');
        }

        public function _remap() {
            $request_method = $this->input->server('REQUEST_METHOD');
            switch (strtolower($request_method)) {
                case 'get':
                    $this->get();
                    break;

                case 'post':
                    $this->post();
                    break;

                case 'put':
                    $this->put();
                    break;

                case 'delete':
                    $this->delete();
                    break;

                default :
                    show_error('Unsupported method', '404');
                    break;
            }
        }

        public function get() {
            $args = $this->uri->uri_to_assoc(2);
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            switch ($args['resource']) {
                case 'user':

                    $data = $this->fetchUser($data);
                    echo json_encode(['data' => $data, 'status' => $data->status]);
                    break;
                case 'quiz':
                    
                    if(array_key_exists('action',$args) && $args['action']=='getquizzes'){
                        
                        $user = new User();
                        $user->fetchUser(array('email'=>$this->session->userdata('userId')));
                        
                        $quizzes = $user->getQuizzesByUser(array('author'=>$user->getUsername()));
                        $quizIds = array();
                        $quizTitles = array();
                        $quizCovers = array();
                        foreach($quizzes as $quiz){
                            array_push($quizIds,$quiz->getId());
                            array_push($quizTitles,$quiz->getTitle());
                            array_push($quizCovers,$quiz->getCoverImage());        
                        }
                        
                        echo json_encode(array('status'=>'success','quizIds'=>$quizIds,'quizTitles'=>$quizTitles,'quizCovers'=>$quizCovers));
                    }     
                    if(array_key_exists('action',$args) && $args['action']=='getsessiondata'){
                        
                        echo json_encode(['status'=>'success','quiz_id'=>$this->session->userdata('quizId')]);
                    }
                    if(array_key_exists('action',$args) && $args['action']=='getquestions'){
                        $quiz = new Quiz();
                        $quiz->getFullQuiz($this->session->userdata('quizId'));
                        $questions = array();
                        foreach($quiz->getQuestionsList() as $question){
                            $questionObj = array("question_id"=>$question->getQuestionNumber(),
                                                "question"=>$question->getQuestion(),
                                                "choices"=>  json_encode($question->getChoicesMatrix()),
                                                "image"=>$question->getImage());
                            array_push($questions, $questionObj);
                        }
                        echo json_encode(['status'=>'success','questions'=>$questions]);
                    }
                    break;
                default :
                    show_error('Unsupported resource', '404');
                    break;
                                 
            } 
        }

        public function post() {
            $args = $this->uri->uri_to_assoc(2);         
            $json = file_get_contents('php://input');            
            $data = json_decode($json);

            if(!empty($data)){
                switch ($args['resource']) {
                    case 'user':
                        
                        if($args['action']=='login'){
                            $user = new User();          
                            $user = $this->fetchUser($data);
                            if($user==null){
                                echo $this->removeSlashes(json_encode(['status'=>'faliure','user' => $user, 'message'=>'User does not exist']));
                            }
                            else if(($user->getPassword())==md5($data->password)){
                                $this->session->set_userdata('userId',$user->getEmail());
                                $user = $this->getUserData($user);
                                echo $this->removeSlashes(json_encode(['status'=>'success','message'=>'Login successful']));
                            }
                            else{
                                echo $this->removeSlashes(json_encode(['status'=>'faliure','user' => $user, 'message'=>'username password does not match']));
                           
                            }
                        }
                        else if($args['action']=='create'){
                            echo json_encode($this->createUser($data));
                        }
                        break;
                        
                    case 'quiz':
         
                        if(array_key_exists('action',$args)&&$args['action']=='create'){
                            echo $this->createQuiz($data);   
                        }
                        if(array_key_exists('add',$args) && $args['add']=='outcomes'){
                            $quiz = new Quiz();
                            $data = array('quizId'=>$data->quiz_id,'verdicts'=>$data->finalOutput);
                            $result = $quiz->insertVerdict($data);
                            
                            if(!$result['error']) echo json_encode(['status'=>'success','message'=>'Outcomes inserted.']);
                            else echo json_encode(['status'=>'failure','message'=>'Error occured.']);
                        }
                        if(array_key_exists('action',$args) && $args['action']=='getquestionid'){
                            
                            $quiz = new Quiz();
                            $id = $quiz->getLastId(array('quiz_id'=>$data->quiz_id));
                            echo json_encode(array('status'=>'success','lastId'=>$id));

                        }
                        if(array_key_exists('action',$args) && $args['action']=='getoutcomekeys'){
       
                            $quiz = new Quiz();
                            $keys = $quiz->getOutcomeKeys(array('quiz_id'=>$data->quiz_id));
                            echo json_encode(array('status'=>'success','keys'=>$keys));
                        }
   
                        if(array_key_exists('action',$args) && $args['action']=='getoutcomes'){

                            $quiz = new Quiz();                            
                            $outcomes = $quiz->fetchVerdicts(array('quiz_id'=>$data->quiz_id));
                            echo json_encode(array('status'=>'success','outcomes'=>$outcomes));
                        }
                        break;
                    
                    case 'question':
                        if(array_key_exists('action',$args) && $args['action']=='insert'){
                            $data = array('quiz_id'=>$data->quiz_id,
                                            'question_id'=>$data->question_id,
                                            'question'=>$data->question,
                                            'choices'=>$data->choices,
                                            'image'=>$data->image);
                                  
                            $quiz = new Quiz();
                            $result = $quiz->insertQuestion($data);
                                          
                            if(!$result['error']) echo json_encode(array('status'=>'success'));
                            else echo json_encode(array('status'=>'failure','error'=>$result['error'],'message'=>$result['message']));
                        }
                        break;

                    default :
                        show_error('Unsupported resource', '404');
                        break;
                }
            } else {
                show_error('Unsupported method', '404');
            }
        }

        public function put() {
            $args = $this->uri->uri_to_assoc(2);
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            if(!empty($data)){
                switch ($args['resource']) {
                    case 'user': 
                        $status = $this->updateUser($data);
                        echo json_encode(['status' => $status,]);
                        break;
                    case 'quiz':
                        echo $this->updateQuiz($data);
                        
                    default :
                        show_error('Unsupported resource', '404');
                        break;
                }
            } else {
                show_error('Unsupported method', '404');
            }
        }

        public function delete() {

            $args = $this->uri->uri_to_assoc(2);                    
            switch ($args['resource']) {
                case 'user':

                    $status = $this->deleteUser($data);
                    echo json_encode(['status' => $status]);
                    break;

                case 'quiz':

                    if(array_key_exists('action',$args) && array_key_exists('quiz_id',$args) && $args['action']=='delete'){
                        $this->deleteQuiz(array("quiz_id"=>$args['quiz_id']));
                    }
                    break;
                case 'question':
                    
                    if(array_key_exists('action',$args) && array_key_exists('quiz_id',$args) && array_key_exists('question_id',$args) && $args['action']=='delete'){
                        
                        $result = $this->deleteQuestion(array("quiz_id"=>$args['quiz_id'],"question_id"=>$args['question_id']));
                        echo json_encode($result);
                        
                    }
                    break;
                default :
                    show_error('Unsupported resource', '404');
                    break;
            }
            
        }
        
        public function createUser($data){
            $necessaryData = $this->getUserDataFromRaw($data);
            $user = new User();
            if($user->ifExists(array('email'=>$necessaryData['email']))) return array('message'=>'User Exists.','status'=>'failure');
            else if($user->ifExists(array('username'=>$necessaryData['username']))) return array('message'=>'Username already taken.','status'=>'failure');
            else if($user->createUser($necessaryData)==1) {
                $this->session->set_userdata('userId',$user->getEmail());
                return array('message'=>'success','status'=>'success');
            }
            else return "400";
        }
        public function deleteUser($data){
            $user = new User();   
            $data = array('email'=>$data->email);
            print_r($data);
            if($user->deleteUser($data)==1) return "success";
            else return "success";
        }
        public function deleteQuiz($data){
            $quiz = new Quiz();
            $quiz->deleteQuiz($data);
        }
        public function deleteQuestion($data){
            $question = new Question();
            $result = $question->deleteQuestion($data);
            $quiz = new Quiz();
            return array("status"=>"success","message"=>"Question deleted.");
            
        }
        
        public function updateUser($data){
            $user = new User();
            $data = $this->getUserDataFromRaw($data);
            $user->updateUser($data);
        }
        public function fetchUser($data){
            $user = new User();
            $data = array('email'=>$data->email);
            $user = $user->fetchUser($data);
            return $user;
        }
        public function getUserData($user){
            $data = array(
                'email'=>$user->getEmail(),
                'username'=>$user->getUsername(),
                'password'=>$user->getPassword(),
                'date_of_birth'=>$user->getDateOfBirth(),
                'profile_picture'=>$user->getProfilePicture());
            return $data;
        }
        
        public function createQuiz($data){
            $data = array('author'=>$data->username,
                          'quiz_title'=>$data->title,
                          'description'=>$data->description,
                          'image'=>$data->image,
                          'date'=>$data->date,
                          'type'=>$data->type,
                          'category'=>$data->category
                    );
            $quiz = new Quiz();
            $data = $quiz->createQuiz($data);
            if($data['result']>0){
                $this->session->set_userdata('quizId',$data['quizId']);
                return json_encode(array('status'=>'success','message'=>'Quiz basic details added.','quizId'=>$data['quizId']));
            }
            
        }
        public function updateQuiz($data){
            $quiz= new Quiz();
            $result = $quiz->updateQuiz($data);
            return array("status"=>"success","message"=>"Basic details of this quiz updated.");
        }


        public function getUserDataFromRaw($data){
            return array('username'=>$data->username,
                'password' => md5($data->password),
                'email' => $data->email,
                'date_of_birth' => $data->date_of_birth,
                'profile_picture' => $data->profile_picture);
        }
        
        function removeSlashes($value){
            $value = str_replace("\/", "/",$value);
            $value = str_replace("\'", "'",$value);
            $value = str_replace('\"', '"',$value);
            $value = str_replace('\n"', '',$value);
            return $value;
        }


    }
