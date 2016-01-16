<html>
    <head>
        <?php
        $this->load->helper('url');
        $this->load->model('user');
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
        <h3> Review Quiz</h3>
        <h4> Basic Details </h4>
        <hr>
        <div ng-app="Quiz" ng-controller="ReviewQuiz">
            <table>
            <input type="hidden" ng-init="quiz.username='<?php echo $user->getUsername()?>' "ng-bind="quiz.username" ng-model="quiz.username">
            <input type="hidden" ng-init="quiz.quizId='<?php echo $quiz->getId()?>'" ng-bind="quiz.quizId" ng-model="quiz.quizId">
            <input type="hidden" ng-init="quiz.date='<?php echo $quiz->getDate()?>'" ng-bind="quiz.date" ng-model="quiz.date">
            <tr>
                <td>
                    Title
                </td>
                <td>
                    <input ng-init="quiz.title='<?php echo $quiz->getTitle()?>'" type="text" ng-bind="quiz.title" ng-model="quiz.title">
                </td>
            </tr>
            <tr>
                <td>
                    Type
                </td>
                <td>
                    <select ng-init="quiz.type='<?php echo $quiz->getType()?>'" ng-model="quiz.type" ng-model="quiz.type" disabled="true">
                        <option value="SIMPLE">Simple</option>
                        <option value="MULTI">Multiple outcome</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Description
                </td>
                <td>
                    <textarea ng-init="quiz.description='<?php echo $quiz->getDescription()?>'" type="text" ng-bind="quiz.description" ng-model="quiz.description" cols="50" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    Category
                </td>
                <td>
                    <input ng-init="quiz.category='<?php echo $quiz->getCategory()?>'" type="text" ng-bind="quiz.category" ng-model="quiz.category">
                </td>
            </tr>
            <tr>
                <td>
                    Cover Image
                </td>
                <td>
                    <img src="{{quiz.image}}">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input ng-init="quiz.image='<?php echo $quiz->getCoverImage()?>'" type="file" id="filePicker" ng-bind="quiz.image" ng-model="quiz.image" ng-click="imageChanged=true" accept="image/*">
                </td>
            </tr>
            <tr>
                <td>
                    <button class="btn btn-primary" ng-click="submitQuiz()">Save changes</button>
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    <div style="background-color: {{quiz.messageColor}}">{{quiz.stateMessage}}</div>
                </td>
                <td>
                </td>
            </tr>
        </table>
            <hr>
            <h4> Outcomes</h4> <br>
            <div ng-repeat="outcome in outcomes">
                
                <label style="font-weight:400">Outcome key: <span style="font-weight:600">{{outcome.outcome}} </span></label> <br>
                <label style="font-weight:400">Outcome text:<span style="font-weight:600"> {{outcome.outcomeText}} </span></label> <br>
                <label style="font-weight:400" ng-if="quiz.type=='SIMPLE'">Lower bound: <span style="font-weight:600">{{outcome.outcomeLowerBounds}}</span></label> <br>
                <label style="font-weight:400" ng-if="quiz.type=='SIMPLE'">Upper bound: <span style="font-weight:600">{{outcome.outcomeUpperBounds}}</span></label> <br>
                <br><br>
            </div>
            
        <button class="btn btn-primary" ng-click="addOutcomes()">Edit outcomes</button> 
        <button class="btn btn-primary" ng-click="editQuestions()">Edit questions</button>
        <button class="btn btn-primary" ng-click="addQuestion()">Add question</button>
        </div>
        <hr>
    </body>
    
</html>


