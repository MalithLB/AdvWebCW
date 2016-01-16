<?php
$this->load->helper('url');
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
        <script src="<?php echo $siteUrl; ?>assets/js/app/user.js"></script>
    </head>
    <body style="padding-left:5%;padding-right: 5%">
        <div ng-app="User">
            
        <h3> Login or sign up </h3>
        <hr>
        <div ng-controller="RegisterController">
            
        </div>
        <table >
            <tr>
                <td>     
                    <span >
                        <table style="text-align: right"  ng-controller="LoginController">
                            <tr>
                                <td>
                                    Email
                                </td>
                                <td>
                                    <input type="email" ng-bind="user.email" ng-model="user.email">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Password
                                </td>
                                <td>
                                    <input type="password" ng-bind="user.password" ng-model="user.password">
                                </td>    
                           </tr>
                           <tr>
                               <td></td>
                               <td style="float:left">
                                    <button class="btn btn-primary" ng-click="login()">login</button>
                               </td>
                           </tr>
                           <tr>
                               <td>
                                   <div style="background-color:{{user.messageColor}}">{{user.stateMessage}}</div>
                               </td>
                           </tr>
                        </table>
                        
                    </span>
                    
                </td>
                
                <td>     
                    <div  style="border-left:1px solid">
                        <table style="text-align: left" ng-controller="RegisterController">
                            <tr>
                                <td>
                                    Username
                                </td>
                                <td>
                                    <input type="text" ng-bind="user.username" ng-model="user.username">
                                </td>       <td>&nbsp;</td><td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    Email
                                </td>
                                <td>
                                    <input type="email" ng-bind="user.email" ng-model="user.email">
                                </td>       <td>&nbsp;</td><td>&nbsp;</td>
                           </tr>
                           <tr>
                                <td>
                                    Password
                                </td>
                                <td>
                                    <input type="password" ng-bind="user.password1" ng-model="user.password1">
                                </td>       <td>&nbsp;</td><td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    Retype password
                                </td>
                                <td>
                                    <input type="password" ng-bind="user.password2" ng-model="user.password2">
                                </td>       <td>&nbsp;</td><td>&nbsp;</td>    
                           </tr>
                           <tr>
                                <td>
                                    Date of Birth
                                </td>
                                <td>
                                    <input type="text" ng-init="user.dobDay='DD'" ng-bind="user.dobDay" ng-model="user.dobDay" value="DD" size="2" maxlength="2">
                                    <input type="text" ng-init="user.dobMonth='MM'" ng-bind="user.dobMonth" ng-model="user.dobMonth" value="MM" size="2" maxlength="2">
                                    <input type="text" ng-init="user.dobYear='YYYY'"ng-bind="user.dobYear" ng-model="user.dobYear" value="YYYY" size="4" maxlength="4">
                                </td>    
                           </tr>
                           <tr>
                                <td>
                                    Profile picture
                                </td>
                                <td>
                                    <input id="filePicker" type="file" ng-bind="user.profile_picture" ng-model="user.profile_picture" accept="image/*">
                                    
                                </td>    
                           </tr>
                           <tr>
                               <td></td>
                               <td style="float:left">
                                    <button class="btn btn-primary" ng-click="submit()">Submit</button>
                               </td>
                           </tr>
                           <tr>
                               <td>
                                    <div style="background-color:{{user.messageColor}}">{{user.stateMessage}}</div>
                               </td> <td>&nbsp;</td><td>&nbsp;</td>  
                           </tr>
                        </table>
                    </div>
                </td>
                
            </tr>
            
        </table>
        <hr>
        </div>
    </body>
</html>
