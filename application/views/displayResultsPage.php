<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php $this->load->model("Quiz"); ?>
        <title><?php echo $quiz->getTitle(); ?>-QuizzableQuizzes.com</title>
        <script type="text/javascript">
            function submitForm(formId) {
                document.getElementById(formId).submit();
            }
        </script>
    </head>

    <body>

        <?php
            include("styles.php");
            include("navbar.php");
            
            $this->load->helper('url');
            $this->load->library('session');
        ?>
        <!-- Page Content -->
        <div class="container">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header"><?php echo $quiz->getTitle(); ?><small>-Result</small></h4>
                </div>
            </div>


            <form action="initializeQuiz" method="POST"> 
                <div class="col-md-3 col-sm-6 hero-feature" style="width:700px;border:0px;float: left;">
                    <input type="hidden" name="selectedQuiz" value="<?php echo $quiz->getId() ?>">
                    <div class="thumbnail" style="border:0px">
                        <image style="max-width: 500px;max-height:500px" src="<?php echo $verdict[1]; ?>">
                        <div class="caption">
                            <h4><?php echo $verdict[0]; ?></h4>
                            <?php
                            if ($quiz->getType() == "SIMPLE") 
                                echo "<h5>You've got  echo " . $quiz->getScore() . "% of the answers right.</small></h5>";  
   
                            ?>
                            <br>
                            <h5><small><p>Try again or go back to home</p><small></h5>
                            <p>
                                <input class="btn btn-primary" id='submitButton' type='submit' value='Try Again'> 
            </form>
                                <form action="viewAnswers" method="POST">
                                    <?php
                                        if ($quiz->getType() == "SIMPLE") {
                                            $this->session->set_userdata('quizId', $quiz->getId());
                                            $this->session->set_userdata('answersList',  json_encode($quiz->getAnswersList()));
                                            echo '<input class="btn btn-primary" id="submitButton" type="submit" value="View Answers">';
                                        }
                                    ?>
                                </form>                                
                                <a href="<?php echo site_url(); ?>" class="btn btn-default">Home</a>
                            </p>
                            </div>
                        </div>
                    </div>
                </form>
            </footer>
        </div>
    </body>
</html>
