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
        <h4> Edit outcomes </h4>
        <hr>
        <div ng-app="Quiz" ng-controller="AddOutcomes">
            
            <input type="hidden" ng-init="outcomes.quiz_id ='<?php echo $quiz->getId()?>'" ng-bind="outcomes.quiz_id" ng-model="outcomes.quiz_id">
            <input type="hidden" ng-init="outcomes.type='<?php echo $quiz->getType()?>'" ng-bind="outcomes.type" ng-model="outcomes.type">
            
                
            <div style="padding: 10px; width:100%"  ng-repeat="singleOutcome in outcomes.outcomesArray">
                
                <label>{{singleOutcome.index+1}}. </label><br>
                
                <label>Outcome: </label><input type="text" ng-model="singleOutcome.outcomeName">   
                <label>Outcome Text: </label><input type="text" ng-model="singleOutcome.outcomeText"> <br>
                
                <label>Image: </label><input class="filePicker" type="file" ng-model-instant onchange="angular.element(this).scope().imageUpload(event)" multiple> <br>
                
                <label ng-if="outcomes.type=='SIMPLE'">Lower bound: </label><input ng-if="outcomes.type=='SIMPLE'" type="text" ng-model="singleOutcome.outcomeLowerBound">
                <label ng-if="outcomes.type=='SIMPLE'">Upper bound: </label><input ng-if="outcomes.type=='SIMPLE'" type="text" ng-model="singleOutcome.outcomeUpperBound">
                <br>
                
                <button style="background-color: red" class="btn btn-primary" ng-click="removeRow(singleOutcome.index)">Remove</button>
                <hr>

            </div>

            <button style="background-color: greenyellow" class="btn btn-primary" ng-click="addRow()">Add</button>
            <button class="btn btn-primary" ng-click="submit()">Submit</button>
            <button ng-disabled="disableReview" class="btn btn-primary" ng-click="reviewQuiz()">Review quiz</button>
            
        </div>
        <hr>
    </body>
    
</html>


