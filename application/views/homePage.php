<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Home-QuizzableQuizzes.com</title>

 
    <script type="text/javascript">
        function submitForm(formId){
            document.getElementById(formId).submit();
        }
    </script>
</head>

<body>

    <?php
        include("styles.php");
        include("navbar.php");
    ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Quizzable Quizzes</h3>
                <h3> <small>Top Quizzes</small></h3>
            </div>
        </div>
 

        <?php
            $this->load->model("Quiz");
            for($i=0;$i<count($quizzes);$i++){
            echo   '<form id="form'.$quizzes[$i]->getId().'" action="index.php/QuizController/initializeQuiz" method="POST">'
                    .'<input type="hidden" name="selectedQuiz" value="'.$quizzes[$i]->getId().'">'
                    .'<div class="row" style="margin-right: 40%;height:10%;">'
                        .' <div class="col-md-7" style="width:35%">'
                            .'<a href="#">'
                                .'<img class="img-responsive" src="'.$quizzes[$i]->getCoverImage().'" alt="" style="vertical-align:middle;" onclick="submitForm(\'form'.$quizzes[$i]->getId().'\')">'
                            .'</a>'
                        .'</div>'
                        .'<div class="col-md-5"style="width:45%;">'
                            .'<h4>'.$quizzes[$i]->getTitle().'</h4>'
                            .'<h5>'.$quizzes[$i]->getDescription().'</h5><br>'
                            .'<h7><small>by '.$quizzes[$i]->getAuthor().', category :'.$quizzes[$i]->getCategory().'    '.$quizzes[$i]->getDate().'</h7></small><br>'
                            .'<a class="btn btn-primary" href="#" onclick="submitForm(\'form'.$quizzes[$i]->getId().'\')">Goto Quiz <span class="glyphicon glyphicon-chevron-right"></span></a>'
                        .'</div>'
                    .'</div></form> <hr>';
            }
        ?>

       

        </footer>

    </div>

</body>

</html>
