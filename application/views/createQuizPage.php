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
        <h3> Create Quiz</h3>
        <h4> Basic Details </h4>
        <hr>
        <div ng-app="Quiz" ng-controller="CreateQuiz">
        <table>
            <input type="hidden" ng-init="quiz.username='<?php echo $user->getUsername()?>'"ng-bind="quiz.username" ng-model="quiz.username">
            <tr>
                <td>
                    Title
                </td>
                <td>
                    <input type="text" ng-bind="quiz.title" ng-model="quiz.title">
                </td>
            </tr>
            <tr>
                <td>
                    Type
                </td>
                <td>
                    <select ng-model="quiz.type" ng-model="quiz.type">
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
                    <textarea  type="text" ng-bind="quiz.description" ng-model="quiz.description" cols="50" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    Category
                </td>
                <td>
                    <input type="text" ng-bind="quiz.category" ng-model="quiz.category">
                </td>
            </tr>
            <tr>
                <td>
                    Cover Image
                </td>
                <td>
                    <input type="file" id="filePicker" ng-bind="quiz.image" ng-model="quiz.image" accept="image/*">
                </td>
            </tr>
            <tr>
                <td>
                    <button class="btn btn-primary" ng-click="submitQuiz()">Submit</button>
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
            <tr>
                <td>
                    <button class="btn btn-primary" ng-click="addOutcomes()">Add outcomes</button>
                </td>
                <td>
                </td>
            </tr>

        </table>
        </div>
        <hr>
    </body>
    
</html>


