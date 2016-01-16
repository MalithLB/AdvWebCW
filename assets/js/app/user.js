/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var app = angular.module("User",[]);
app.controller('LoginController', ['$scope','$http','$window', function($scope,$http,$window) {  
    $scope.user = {
        email: '',
        password: '',
        stateMessage: '',
        messageColor: 'white',
    };
    $scope.login = function(){
        $scope.user.stateMessage = '';
        $scope.user.messageColor = 'white';
        $scope.user.email = $scope.user.email.toLowerCase();
        console.log(JSON.stringify($scope.user));
        return $http.post('http://localhost/advwebcw1/index.php/rest/resource/user/action/login',$scope.user).then(function successCallback(response) {
            if(response.data.status=='success'){
                $window.location.href='http://localhost/advwebcw1/index.php/navigationController/dashboard';
            }
            else{
                $scope.user.stateMessage = response.data.message;
                $scope.user.messageColor = 'red';
            }
            
        }, function errorCallback(response) {
            $scope.user.stateMessage = "System Error";
            $scope.user.messageColor = 'red';
        });
       
    }
        
}]);
app.controller('RegisterController', ['$scope','$http','$window', function($scope,$http,$window) {  
    $scope.user = {
        email: '',
        password1: '',
        password2:'',
        password:'',
        username:'',
        profile_picture:'',
        dobDay:'DD',
        dobMonth:'MM',
        dobYear:'YYYY',
        date_of_birth:'',
        stateMessage:'',
        messageColor:'white',
    };
    
    $scope.transfer = function(){
        $http.post('http://localhost/advwebcw1/index.php/rest/resource/user/action/create',$scope.user).then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    $window.location.href='http://localhost/advwebcw1/index.php/navigationController/dashboard';
                }
                else if(response.data.status=='failure'){
                    $scope.user.stateMessage = response.data.message;
                    $scope.user.messageColor = "red";
                }
                
            }
        },function errorCallback(response) {
            $scope.user.stateMessage = "Error occured.";
            $scope.user.messageColor = "red";
        });
        
    }
    
    $scope.submit = function(){
        $scope.user.stateMessage="";
        $scope.user.messageColor="white";
        $scope.user.email = $scope.user.email.toLowerCase();
        var proceed = true;
        
        if(!validateFields()){
            $scope.user.stateMessage = "All fields must be filled!";
            $scope.user.messageColor = "red";
            proceed = false;
        }
        
        if(validateDate($scope.user.dobDay,$scope.user.dobMonth,$scope.user.dobYear)){
            $scope.user.date_of_birth= $scope.user.dobYear+"-"+$scope.user.dobMonth+"-"+$scope.user.dobDay;
        }else {
            proceed = false;
            $scope.user.stateMessage = "Date is invalid!";
            $scope.user.messageColor = "red";
        }
            
        if($scope.user.password1!=$scope.user.password2){
            proceed = false;
            $scope.user.stateMessage = "Passwords don't match!";
            $scope.user.messageColor = "red";
            
        }else $scope.user.password = $scope.user.password1;
        if(proceed){
            var file = document.getElementById('filePicker').files[0];
            reader = new FileReader();

            reader.onloadend = function(e) {
                $scope.user.profile_picture = JSON.stringify(e.target.result);
                $scope.$apply();
                console.log($scope.user.profile_picture);
                $scope.transfer();
            }
            reader.readAsDataURL(file);
        } 
        
        
        function validateFields(){
            if($scope.user.email=='') return false;
            if($scope.user.username=='') return false;
            if($scope.user.password1=='') return false;
            if($scope.user.password2=='') return false;
            if($scope.user.dobDay=='') return false;
            if($scope.user.dobMonth=='') return false;
            if($scope.user.dobYear=='') return false;
            if(document.getElementById('filePicker').value=="") return false;
            return true;
        }
        
        function validateDate(day,month,year){
            return true;
        }
    }
    
}]);

app.controller('ModifyQuizzes', ['$scope','$http','$window', function($scope,$http,$window) {
    var Quiz = function(title,quiz_id,coverImage){
        this.title = title;
        this.quiz_id = quiz_id;
        this.coverImage = coverImage;
    }
    $scope.quizzes =[];
    
    loadData();
    
    function loadData(){
        $http.get('http://localhost/advwebcw1/index.php/rest/resource/quiz/action/getquizzes').then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    
                    for(var i=0; i < response.data.quizTitles.length;i++){
                        $scope.quizzes.push(new Quiz( response.data.quizTitles[i],response.data.quizIds[i],response.data.quizCovers[i]));
                    }
                }
                else if(response.data.status=='failure'){
                  
                }       
            }
        },function errorCallback(response) {
            
        });
    }
    
    $scope.deleteQuiz = function(quiz_id){
        $http.delete('http://localhost/advwebcw1/index.php/rest/resource/quiz/action/delete/quiz_id/'+quiz_id).then(function(response){
            alert("quiz deleted. Refresh page.");
        }
        ,function(response){
            alert("Error deleting quiz.");
        });
    }
    $scope.data ={
        quiz_id:'',
    }
    $scope.editQuiz = function(quiz_id){       
        $scope.data.quiz_id = quiz_id;
        $http.post('http://localhost/advwebcw1/index.php/QuizController/addQuizIdToSession',$scope.data);
    
        $window.location.href='http://localhost/advwebcw1/index.php/QuizController/reviewQuiz';
    }
}]);



