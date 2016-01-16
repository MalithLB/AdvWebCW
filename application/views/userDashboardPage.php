
<?php
$this->load->helper('url');
$this->load->model('quiz');
$this->load->library('session');
$siteUrl = str_replace("index.php","",site_url());
include('styles.php');
include('navbar.php');   
?>
<html>
    <style type="text/css">
        th, td {
            padding: 10px;
        }
    </style>
    <head>
        <script src="<?php echo $siteUrl; ?>assets/js/app/user.js">
           
        </script>
    </head>
    
    <body style="padding-left: 5%;padding-right: 5%" ng-app="User">
        <h3> Manage your quizzes </h3>
        <hr>

        <div  ng-controller="ModifyQuizzes">
            <div  ng-repeat="quiz in quizzes" >
  
                <image style="width:240px;hight:100px"src="{{quiz.coverImage}}">
                
                <span style="font-size:18px;font-weight: 600;">{{quiz.title}}</span> <br>
                <span style="padding-left:20%">
                <button class="btn btn-primary" class ng-click="editQuiz(quiz.quiz_id)">Modify</button>
                <button style="background-color:red" class="btn btn-primary" ng-click="deleteQuiz(quiz.quiz_id)">Delete</button>
                </span>
                <hr>
            </div>
        </div>
    </body>

</html>