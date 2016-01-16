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
        <h4> Review questions </h4>
        <hr>
        
        <div style="padding:10px" ng-app="Quiz" ng-controller="EditQuestions">
            
           
            <div>
                <span style="background-color:{{messageColor}}">{{statusMessage}}</span><br><br>
            </div>
            <div ng-repeat="question in questions">
                <img style="max-width:240px;max-height:240px" ng-if="question.image!='NONE'" src="{{question.image}}"> 
                <h4>{{question.question}}</h4>
                      
                <br>
                <div    style="padding:10px"ng-repeat="choice in question.choices">
                    <input type="radio" ng-model="choice" ng-value="choice" disabled="true">{{choice}}
                </div>
                
                <button class="btn btn-primary" style="background-color: red" ng-click="deleteQuestion(question.question_id)" >Delete question</button>
                <br><br>
            </div>
            <button class="btn btn-primary" ng-click="addQuestion()">Add question</button>
            <button style="background-color: red" class="btn btn-primary" ng-click="reviewQuiz()">Review quiz</button>
            
        </div>
        <hr>
    </body>
    
</html>


