<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title><?php echo $quiz->getTitle()."-QuizzableQuizzes.com";?></title>

    <!-- Bootstrap Core CSS -->
    <?php 
        include('navbar.php'); 
        include('styles.php');
    ?>
    
    <script type="text/javascript">
        var jsonObj =JSON.parse('<?php echo $quiz->getQuestionsAsJSON();?>');
        var numberOfQuestions = <?php echo count($quiz->getQuestionsList());?>;
        var numberOfChoicesMatrix =[];
        
        for(var i=1;i<=numberOfQuestions;i++){
            numberOfChoicesMatrix[i]=jsonObj[i][2];
        }

        function enableButton(){
            document.getElementById("submitButton").disabled=false;
        }
        var answersList=[]
        function validate(){
            var checkCount=0;
            for(var i=1;i<=numberOfQuestions;i++){
                for(var j=0;j<numberOfChoicesMatrix[i];j++){
                    var obj = document.getElementById(i+""+j);
                    if(obj.checked==true){
                        var index = i-1;
                        var answer ='"'+i+'":"'+obj.value+'"';
                        answersList[index]=answer;
                        checkCount++;
                    }
                }
            }
           
            if(checkCount==numberOfQuestions){
                document.getElementById("submitButton").style.backgroundColor = "green";
                document.getElementById("submitButton").disabled=false;
                document.getElementById("status").className = "glyphicon glyphicon-ok";
                document.getElementById("status").title = "Finish when you're ready";
                document.getElementById("submitButton").title = "Finish when you're ready";
                document.getElementById("answersJSON").value=answersList;
      
                //alert(answersList);
            }else{
                document.getElementById("submitButton").style.backgroundColor = "red";
                document.getElementById("submitButton").disabled=true;
                document.getElementById("status").className = "glyphicon glyphicon-exclamation-sign";
                document.getElementById("submitButton").title ="You must answer all the questions";
                document.getElementById("status").title ="You must answer all the questions";
            }
        }
       
    </script>
</head>

<body>

    <?php
        include("navbar.php");
        $this->load->model("Quiz");
        $this->load->model("Question");
        $quiz->getQuestionsAsJSON();
    ?>
    <!-- Page Content -->
    <div class="container">
        <h4  class="page-header"> <?php echo $quiz->getTitle();?> Quiz <small> by <?php echo $quiz->getAuthor();?>. created on <?php echo $quiz->getDate();?></small></h4>
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12" >  
                <form name="quiz" action="evaluateQuiz" method="POST">
                <input type="hidden" id ="answersJSON" name="answersJSON" value='{"1":"Rural area","2":"10-50km","3":"Highways","4":"Never","5":"Somewhat","6":"I just want to go from A to B","7":"Im a bit adventurous","8":"I want speed and control but I dont want to lean forward like a gp rider"}'>
                <input type="hidden" name="selectedQuiz" value="<?php echo $quiz->getId();?>";>
                <div class="col-md-5" style="left-margin:40%">
                <?php
                    foreach($quiz->getQuestionsList() as $question){
                        if($question->getImage()!="NONE"){
                            echo "<image style='max-width:300px;max-heigh:150px;'src='".$question->getImage()."'> <br>";
                        }
                        echo "<p style='font-size:14px;font-weight:bold;'>";
                        echo $question->getQuestionNumber().' . '.$question->getQuestion()."<br>";
                        echo "</p>";
                        $choiceIndex=0;
                        foreach($question->getChoicesMatrix() as $choice){
                            echo "<input type='radio' id='".$question->getQuestionNumber().$choiceIndex."' onClick='validate()' name='".$question->getQuestionNumber()."' value='".$choice[0]."'>".$choice[0]."<br>";         
                            $choiceIndex++;
                        }
                        echo "<br>";
                    }
                ?>
                <input style='background-color:red;' class="btn btn-primary" id='submitButton' type='submit' value='Finish' disabled="true"> <span id="status" class="" ></span>
                  
                </div>
                
                
                </form>

            </div>
        </div>
        <hr>
       

        </footer>

    </div>

</body>

</html>
