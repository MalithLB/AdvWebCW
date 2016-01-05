<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Answers -QuizzableQuizzes.com</title>

 
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
        $this->load->model("Quiz");
    ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header" style="font-size:20px">Statistics of <?php echo $quiz->getTitle()?> quiz</h3>
                <p>
                    Your score: <?php echo $quiz->getScore()?> </br>
                    Average of all previous attempts: <?php echo $quizStats['average']?></br>
                    This quiz has been taken <?php echo $quizStats['times_taken']?> times.</br>
                </p>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <small><h3 class="page-header" style="font-size:20px">Answers of <?php echo $quiz->getTitle()?> quiz</h3></small>
            </div>
        </div>
 

        <?php
            $questionsCount=0;    
            foreach($quiz->getQuestionsList() as $question){
                if($question->getImage()!="NONE"){
                    echo "<image style='max-width:300px;max-heigh:150px;'src='".$question->getImage()."'> <br>";
                }
                echo "<p style='font-size:14px;font-weight:bold;'>";
                echo $question->getQuestionNumber().' . '.$question->getQuestion()."<br>";
                echo "</p>";
                $choiceIndex=0;
                foreach($question->getChoicesMatrix() as $choice){
                  
                    if(($choice[0]==$correctAnswers[$questionsCount])&&($quiz->getAnswersList()[$questionsCount]==$choice[0])) echo 
                        "<span style='background-color:#7FFF00'><input  disabled='true' type='radio' id='".$question->getQuestionNumber().$choiceIndex."' onClick='validate()' name='".$question->getQuestionNumber()."' value='".$choice[0]."' checked>".$choice[0]."</span><br>";         
                    
                    
                    else if($choice[0]==$correctAnswers[$questionsCount]) echo 
                        "<span style='background-color:#EE3B3B'><input disabled='true' type='radio' id='".$question->getQuestionNumber().$choiceIndex."' onClick='validate()' name='".$question->getQuestionNumber()."' value='".$choice[0]."'>".$choice[0]."</span><br>";         
                    
                    else if($quiz->getAnswersList()[$questionsCount]==$choice[0]) echo 
                        "<input  disabled='true' type='radio' id='".$question->getQuestionNumber().$choiceIndex."' onClick='validate()' name='".$question->getQuestionNumber()."' value='".$choice[0]."' checked>".$choice[0]."<br>";         
                    
                    else echo 
                        "<input disabled='true'  type='radio' id='".$question->getQuestionNumber().$choiceIndex."' onClick='validate()' name='".$question->getQuestionNumber()."' value='".$choice[0]."'>".$choice[0]."<br>";         
                    $choiceIndex++;
                }
                echo "<br>";
                $questionsCount++;
            }
        ?>
        <a href="<?php echo site_url(); ?>" class="btn btn-default">Home</a>
    </div>
</body>

</html>
