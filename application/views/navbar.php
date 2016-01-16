<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
    $this->load->library('session');
    $this->load->model('user');
    $userId = $this->session->userdata('userId');
    ?>
<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://localhost/advWebCw1/index.php">QuizzableQuizzes.com</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('navigationController/createQuiz');?>">Create Quiz</a>
                    </li>
                    <li>
                        <a href="#">About Us</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('navigationController/loginSignup');?>">
                        <?php  
                            
                            if(!$userId) echo "Login/Register";
                            else echo "Dashboard";
                        ?>
                        </a>
                    </li>
                    <li>
                        <?php $this->load->helper('url'); ?>
                        <form action="<?php echo site_url('quizController/searchQuiz'); ?>" method="POST"> <a href="#"><input type="search" name="searchString" id="search"> <button style="height:28px"type="submit" class="glyphicon glyphicon-search"></button ></form>
                    </a>
                    </li>
                    <?php
                    
                    if($userId!=null){      
                        $user = new User();
                        $user->fetchUser(array('email'=>$userId));
                        echo "<li><a href=".site_url('navigationController/logout')."><img style='height:30px;width:30px' src='".$user->getProfilePicture()."'>Logout</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>