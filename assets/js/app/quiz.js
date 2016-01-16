/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var app = angular.module('Quiz',[]);

app.controller('CreateQuiz', ['$scope','$http','$window', function($scope,$http,$window) {  
    $scope.quiz ={
        'username': '',
        'title': '',
        'type': '',
        'description': '',
        'category': '',
        'date': new Date().toJSON().slice(0,10),
        'image':'',
        'stateMessage':'',
        'messageColor':'white',
        'quizId':'',
    }
    
    $scope.postQuiz = function (){
        console.log(JSON.stringify($scope.quiz));
        $http.post('http://localhost/advwebcw1/index.php/rest/resource/quiz/action/create',$scope.quiz).then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    $scope.quiz.stateMessage = response.data.message;
                    $scope.quiz.messageColor = "#39FF14";
                    $scope.quiz.quizId = response.data.quizId;
                }
                else if(response.data.status=='failure'){
                    $scope.quiz.stateMessage = response.data.message;
                    $scope.quiz.messageColor = "red";
                }
                
            }
        },function errorCallback(response) {
            $scope.quiz.stateMessage = "Error occured.";
            $scope.quiz.messageColor = "red";
        });
    }
    
    $scope.submitQuiz = function (){
        $scope.stateMessage = '';
        $scope.messageColor = 'white';
        var proceed = true;
        if(!validateFields()){
            proceed = false;
            $scope.quiz.stateMessage = 'All fields are mandatory!';
            $scope.quiz.messageColor = 'red';
        }
        if(proceed){
            var file = document.getElementById('filePicker').files[0];
            reader = new FileReader();

            reader.onloadend = function(e) {
                $scope.quiz.image = e.target.result;
                $scope.$apply();
                console.log($scope.quiz.image);
                $scope.postQuiz();
            }
            reader.readAsDataURL(file);
        } 
        
        function validateFields(){
            if($scope.quiz.title=='') return false;
            if($scope.quiz.username=='') return false;
            if($scope.quiz.description=='') return false;
            if($scope.quiz.category=='') return false;
            if($scope.quiz.type=='') return false;
            if(document.getElementById('filePicker').value=="") return false;
            return true; 
        }
    }
    
    $scope.addOutcomes = function(){
        $window.location.href='http://localhost/advwebcw1/index.php/quizController/addOutcomes';
    }
                       
}]);

app.controller('ReviewQuiz', ['$scope','$http','$window', function($scope,$http,$window) {  

    $scope.quiz ={
        'username': '',
        'title': '',
        'type': '',
        'description': '',
        'category': '',
        'date': '',
        'image':'',
        'stateMessage':'',
        'messageColor':'white',
        'quizId':'',
        
    }
    $scope.imageChanged = false;
    var Outcome = function(outcome,outcomeText,outcomeLowerBounds,outcomeUpperBounds,outcomeImage){
        this.outcome = outcome;
        this.outcomeText = outcomeText;
        this.outcomeLowerBounds = outcomeLowerBounds;
        this.outcomeUpperBounds = outcomeUpperBounds;
        this.outcomeImage = outcomeImage;
    }
    $scope.outcomes =[];
    
    $scope.postQuiz = function (){

        $http.put('http://localhost/advwebcw1/index.php/rest/resource/quiz',$scope.quiz).then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    $scope.quiz.stateMessage = response.data.message;
                    $scope.quiz.messageColor = "#39FF14";
                    $scope.quiz.quizId = response.data.quizId;
                }
                else if(response.data.status=='failure'){
                    displayError(response.data.message);
                }
                
            }
        },function errorCallback(response) {
            displayError('');
        });
    }
    
    $scope.submitQuiz = function (){
        $scope.stateMessage = '';
        $scope.messageColor = 'white';
        var proceed = true;
        if(!validateFields()){
            proceed = false;
            displayError("All fields are mandatory");
        }
        if(proceed){
            if($scope.imageChanged){
                var file = document.getElementById('filePicker').files[0];
                reader = new FileReader();

                reader.onloadend = function(e) {
                    $scope.quiz.image = e.target.result;
                    $scope.$apply();
                    console.log($scope.quiz.image);
                    $scope.postQuiz();
                }
                reader.readAsDataURL(file);
            }else $scope.postQuiz();
        } 
        
        function validateFields(){
            if($scope.quiz.title=='') return false;
            if($scope.quiz.username=='') return false;
            if($scope.quiz.description=='') return false;
            if($scope.quiz.category=='') return false;
            if($scope.quiz.type=='') return false;
            if($scope.imageChanged){
                if(document.getElementById('filePicker').value=="") return false;
            }
            return true; 
        }
    }
    
    
    $scope.addOutcomes = function(){
        $window.location.href='http://localhost/advwebcw1/index.php/quizController/addOutcomes';
    }

    $scope.editQuestions = function(){
        $window.location.href='http://localhost/advwebcw1/index.php/quizController/editQuestions';
    }
    $scope.addQuestion = function(){
        $window.location.href='http://localhost/advwebcw1/index.php/quizController/addQuestion';
    }
    
    $http.get('http://localhost/advwebcw1/index.php/rest/resource/quiz/action/getsessiondata').then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    $scope.quiz.quizId = response.data.quiz_id
                    setOutcomes();
                }
                else if(response.data.status=='failure'){
                    displayError(response.data.message);
                }
                
            }
        },function errorCallback(response) {
            displayError('');
        });
        
       
    function setOutcomes(){
        $http.post('http://localhost/advwebcw1/index.php/rest/resource/quiz/action/getoutcomes',{quiz_id : $scope.quiz.quizId}).then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    var data = JSON.parse(response.data.outcomes);
                    var length = Object.keys(data).length;
                    if($scope.quiz.type=="SIMPLE"){
                        for(var i=0; i<length;i++){
                            $scope.outcomes.push(new Outcome(data[i][2],data[i][2],data[i][0],data[i][1],data[i][3]));
                        }
                    }else{
                        for(var i=0; i<length;i++){
                            $scope.outcomes.push(new Outcome(data[i][0],data[i][1],'','',data[i][2]));
                        }
                    }
                }
                else if(response.data.status=='failure'){
                    displayError(response.data.message);
                }
            }
        },function errorCallback(response) {
           displayError('');
        });
        
    }
    function displayError(message){
        if(message!=''){
            $scope.quiz.stateMessage = "Error occured.";
            $scope.quiz.messageColor = "red";
        }
    } 
}]);


app.controller('AddOutcomes', ['$scope','$http','$window', function($scope,$http,$window) {  
    function Outcome(outcomeName,outcomeText,outcomeImage,outcomeUpperBound,outcomeLowerBound,index){
        this.outcomeName = outcomeName;
        this.outcomeText = outcomeText;
        this.outcomeImage=outcomeImage;
        this.outcomeUpperBound=outcomeUpperBound;
        this.outcomeLowerBound=outcomeLowerBound;
        this.index = index;
    }
    $scope.files = [];
    $scope.disableReview = true;
    $scope.outcomes ={
        quiz_id:'',
        type:'',
        initialOutcomes:'',
        outcomesArray:[],
        numberOfOutcomes:0,
        finalOutput:'',
    }
    function setFinalOutput(){
        var final ='{"';
        
        if($scope.outcomes.type=="SIMPLE"){
            for(var i=0;i<$scope.outcomes.numberOfOutcomes;i++){
                final+=i+'":["';
                final+=$scope.outcomes.outcomesArray[i].outcomeLowerBound+'","';
                final+=$scope.outcomes.outcomesArray[i].outcomeUpperBound+'","';
                final+=$scope.outcomes.outcomesArray[i].outcomeText+'","';
                final+=$scope.outcomes.outcomesArray[i].outcomeImage+'"],"';
            }    
            
        }else if($scope.outcomes.type=="MULTI"){
            for(var i=0;i<$scope.outcomes.numberOfOutcomes;i++){
                final+=i+'":["';
                final+=$scope.outcomes.outcomesArray[i].outcomeName+'","';
                final+=$scope.outcomes.outcomesArray[i].outcomeText+'","';
                final+=$scope.outcomes.outcomesArray[i].outcomeImage+'"],"';
            }
        }
        final = final.substr(0,final.length-2);
        final+='}'
        $scope.outcomes.finalOutput = final;
    }
    function setImages(){
        for(var i=0;i<$scope.files.length;i++){
            $scope.outcomes.outcomesArray[i].outcomeImage=$scope.files[i];
        }
    }
    $scope.submit = function(){
        setImages();
        setFinalOutput();
        $http.post('http://localhost/advwebcw1/index.php/rest/resource/quiz/add/outcomes',$scope.outcomes).then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    $scope.disableReview = false;
                    alert(response.data.message);
                }
                else if(response.data.status=='failure'){
                    alert(response.data.message);
                }
                
            }
        },function errorCallback(response) {
            alert("app crashed");
        });
    }
    
    $scope.addRow = function(){
        var current = new Outcome('','','','','',$scope.outcomes.numberOfOutcomes);
        var array = $scope.outcomes.outcomesArray;
        array.push(current);
        $scope.outcomes.outcomesArray = array;
        $scope.outcomes.numberOfOutcomes++;
    }
    $scope.removeRow = function(index){
        var array = $scope.outcomes.outcomesArray;
        array.splice(index,1);
        $scope.outcomes.outcomesArray = array;
        $scope.outcomes.numberOfOutcomes--;
        resetIndexes();
    }
    function resetIndexes(){
        for(var i=0;i<$scope.outcomes.numberOfOutcomes;i++){
            var tempOutcomeObject = $scope.outcomes.outcomesArray[i];
            tempOutcomeObject.index = i;
            $scope.outcomes.outcomesArray[i]=tempOutcomeObject;
        }
    }
    $scope.reviewQuiz = function(){
        $window.location.href='http://localhost/advwebcw1/index.php/quizController/reviewQuiz';
    }
    $scope.imageUpload = function(event){
         var files = event.target.files; //FileList object

         for (var i = 0; i < files.length; i++) {
             var file = files[i];
                 var reader = new FileReader();
                 reader.onload = $scope.imageIsLoaded; 
                 reader.readAsDataURL(file);
         }
    }

    $scope.imageIsLoaded = function(e){
        $scope.$apply(function() {
            $scope.files.push(e.target.result);
        });
    }

}]);

app.controller('AddQuestion', ['$scope','$http','$window', function($scope,$http,$window) {  
    
    var Answer = function(answerValue,answerKey,index){
        this.answerKey = answerKey;
        this.answerValue = answerValue;
        this.index = index;
    }
    
    $scope.data = {
        quiz_id:'',
        question_id:0,
        type:'',
        question:'',
        choices:'',
        image:'NONE'
    }
    $scope.choices = []
    $scope.outcomes = [];
    $scope.choicesCount = 0;
    $scope.statusMessage ='';
    $scope.messageColor ='white';
    $scope.imageAttached =false;
    
    $scope.addRow = function(){
        loadOutcomes();
        $scope.choices.push(new Answer('','',$scope.choicesCount));
        $scope.choicesCount++;
    }
    
    $scope.removeRow = function(index){
        var array = $scope.choices;
        array.splice(index,1);
        $scope.choices = array;
        $scope.choicesCount--;
        resetIndexes();
    }
    function resetIndexes(){
        for(var i=0;i<$scope.choicesCount;i++){
            var tempChoiceObject = $scope.choices[i];
            tempChoiceObject.index = i;
            $scope.choices[i]=tempChoiceObject;
        }
    }
    
    function loadOutcomes(){
        if($scope.data.type!="SIMPLE")
            $http.post('http://localhost/advwebcw1/index.php/rest/resource/quiz/action/getoutcomekeys',{quiz_id:$scope.data.quiz_id}).then(function successCallback(response) {
                    if(response.data.status!=null){
                        if(response.data.status=='success'){
                            $scope.outcomes = response.data.keys;
                        }   
                    }
                },function errorCallback(response) {
                    alert("app crashed");
            });
        else $scope.outcomes = ["CORRECT","WRONG"];
    }
    
    $scope.saveQuestion = function(){
        //being compliant with legcy code
        var str = "{";
        for(var i=0; i < $scope.choicesCount;i++){
            str+= '"'+i+'":["'+$scope.choices[i].answerValue+'","'+$scope.choices[i].answerKey+'"]';
            if(i != $scope.choicesCount-1) str+=',';
        }
        str+="}";
        $scope.data.choices = str;
        $http.post('http://localhost/advwebcw1/index.php/rest/resource/question/action/insert',$scope.data).then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    $scope.statusMessage ='Question added to database';
                    $scope.messageColor ='#39FF14';
                }   
                else{
                    $scope.statusMessage ='Error!';
                    $scope.messageColor ='red';
                    console.log(JSON.stringify(response.data));
                }
            }else{
                $scope.statusMessage ='Application error!';
                $scope.messageColor ='red';
                console.log(JSON.stringify(response.data));
            }
        },function errorCallback(response) {
            $scope.statusMessage ='Application error!';
            $scope.messageColor ='red';
            console.log(JSON.stringify(response.data));
    })
    }
    //get the id for this question
    $http.post('http://localhost/advwebcw1/index.php/rest/resource/quiz/action/getquestionid',$scope.data).then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    $scope.data.question_id = parseInt(response.data.lastId)+1;
                }   
            }
        },function errorCallback(response) {
            alert("app crashed");
    });

    $scope.imageUpload = function(event){
        var files = event.target.files; //FileList object

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
                var reader = new FileReader();
                reader.onload = $scope.imageIsLoaded; 
                reader.readAsDataURL(file);
        }
    }

    $scope.imageIsLoaded = function(e){
        $scope.$apply(function() {
            $scope.imageAttached = true;
            $scope.data.image = e.target.result;
        });
    }
    
    $scope.addQuestion = function(){
        $window.location.href='http://localhost/advwebcw1/index.php/quizController/addQuestion';
    }
    $scope.reviewQuiz = function(){
        $window.location.href='http://localhost/advwebcw1/index.php/quizController/reviewQuiz';
    }
    
 }]);
 
 app.controller('EditQuestions', ['$scope','$http','$window', function($scope,$http,$window) {  
    var Question = function(question,choices,image,question_id){
        this.question = question;
        this.choices = choices;
        this.image = image;
        this.question_id = question_id;
    }
    
    $scope.questions = [];
    $scope.quiz_id;
    $scope.statusMessage = '';
    $scope.messageColor = 'white';
    
    $http.get('http://localhost/advwebcw1/index.php/rest/resource/quiz/action/getsessiondata').then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    $scope.quiz_id = response.data.quiz_id;
                    $scope.loadQuestions();
                }   
                else displayError("Something went wrong. Try again later");
            }
        },function errorCallback(response) {
            displayError("app crashed");
    });
    
    $scope.loadQuestions = function(){
        $http.get('http://localhost/advwebcw1/index.php/rest/resource/quiz/action/getquestions').then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    var questions = response.data.questions;
                    
                    for(var i =0; i<questions.length; i++){
                        var question = questions[i];
                        var choices = JSON.parse(question.choices);
                        var choiceValues =[];
                        for(var j=0; j< choices.length;j++){
                            choiceValues.push(choices[j][0]);
                        }
                        $scope.questions.push(new Question(question.question,choiceValues,question.image,question.question_id));
                    }                  
                }   
                else displayError("Something went wrong. Try again later");
            }
        },function errorCallback(response) {
            displayError("app crashed");
    });
    }
    $scope.deleteQuestion = function(question_id){
        $http.delete('http://localhost/advwebcw1/index.php/rest/resource/question/action/delete/quiz_id/'+$scope.quiz_id+'/question_id/'+question_id).then(function successCallback(response) {
            if(response.data.status!=null){
                if(response.data.status=='success'){
                    $scope.statusMessage = response.data.message;
                    $scope.messageColor = 'green';
                }   
                else displayError("Something went wrong. Try again later");
            }
            else displayError('');
        },function errorCallback(response) {
            displayError("app crashed");
    });
    }
    
    $scope.reviewQuiz = function(){
        $window.location.href='http://localhost/advwebcw1/index.php/quizController/reviewQuiz';
    }
    
    $scope.addQuestion = function(){
        $window.location.href='http://localhost/advwebcw1/index.php/quizController/addQuestion';
    }
    
    function displayError(message){
        if(message=='') message = 'Error.';
        $scope.statusMessage = message;
        $scope.messageColor = 'red';
    }
}]);
