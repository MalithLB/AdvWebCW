<html>
    <head>
        <?php
        $this->load->helper('url');
        $this->load->model('quiz');
        $siteUrl = str_replace("index.php","",site_url());
        include('styles.php');
        include('navbar.php');
        ?>
        <style type="text/css">
            th, td {
                padding: 10px;
            }
        </style>
        <script src="<?php echo $siteUrl; ?>assets/js/app/user.js"></script>
        <script src="<?php echo $siteUrl; ?>assets/js/app/quiz.js"></script>
    </head>
    <body style="padding-left: 5%;padding-right: 5%">
        <h3> Edit quiz</h3>
        <h4> Add question </h4>
        <hr>
        
        <div style="padding:10px" ng-app="Quiz" ng-controller="AddQuestion">
            
            <input type="hidden" ng-init="data.quiz_id ='<?php echo $quizId?>'" ng-bind="data.quiz_id" ng-model="data.quiz_id">
            <input type="hidden" ng-init="data.type ='<?php echo $type?>'" ng-bind="data.quiz_id" ng-model="data.quiz_id">
            
            <div>
                <span style="background-color:{{messageColor}}">{{statusMessage}}</span><br><br>
            </div>
            <label>Question: </label><input style="width:500px;" type="text" ng-bind="data.question" ng-model="data.question"><br>
            <label>Image: </label><input class="filePicker" type="file" ng-model-instant onchange="angular.element(this).scope().imageUpload(event)" multiple> <br>
            <img style="max-width:240px;max-height:240px"ng-if="imageAttached" src="{{data.image}}">       
            <br> <br>
            <div  style="padding:10px"ng-repeat="choice in choices">
                <label>Answer: </label> <input style="width:300px;" type="text" ng-model="choice.answerValue">
                <label>Answer key: </label><select ng-model="choice.answerKey" ng-options="o as o for o in outcomes"></select> 
                <button style="background-color: red" class="btn btn-primary" ng-click="removeRow(choice.index)">Remove</button>
                
            </div>
            <button class="btn btn-primary" ng-click="addRow()">Add answer</button> <br><br>
            <button class="btn btn-primary" ng-click="saveQuestion()">Save question</button>
            <button class="btn btn-primary" ng-click="addQuestion()">Add new question</button>
            <button style="background-color: red" class="btn btn-primary" ng-click="reviewQuiz()">Review quiz</button>
            
        </div>
        <hr>
    </body>
    
</html>


