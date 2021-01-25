<?php
    // - validating and sanitizing user input, adding step and questions to matching tables 
    // ## functions ##
    // * validateCalculator - takes one argument and returns an error message if the argument is empty or contains any special character
    // * validateNumber - takes one argument and returns an error message if the argument isnt't a number
    // * validateFileUpload - validating uploaded file. Takes one argument(key of the global $_FILES array), returns an error message if: 
    // -file extension isnt' jpeg, jpg, or png
    // -error message from $_FILES array isn't 0 or 4
    // -file size is greater than 2MB
    // * createStep - takes three arguments: connection, question and calculator id, creates new row in step table
?>
<?php 
    
    foreach($_POST as $k => $v) {
        if(strpos($k,'question') || strpos($k, 'name')) {
            $errorMessage = $quiz->validateInput($v);
            if($errorMessage) {
                break;
            } else {
                continue;
            }
        }
    }

    $numofanswers = 0;
    $j = 1;
    while(isset($_POST[$j . 'check'])) {
        $numofanswers = $numofanswers + 1;
        $j++;
    }

    if($numofanswers == 0) {
        $errorMessage =  "Question must have at least one correct answer.";
    }
    
    if(!$errorMessage) {

        //Adding a question sing on the end of the question
        $question = $database->escape_string(($_POST['question']));
        $question = $question[strlen($question) - 1] == '?' ? $question : $question . '?';
        $exp = $database->escape_string(($_POST['exp']));
        
        
        //inserting data into step table
        if($error = $quiz->createStep($question, $exp, $_SESSION['quiz_id'])) {
            echo $error;
        }
        $i = 1;
        //performing while loop to insert data into options table
        while(isset($_POST[$i . 'name'])) {
            $name = $database->escape_string(($_POST[$i . 'name']));
            if(isset($_POST[$i .'check'])) {
            $correctAnswer = $database->escape_string(($_POST[$i .'check']));
            } else {
                $correctAnswer = 0;
            }
            
            $row = $quiz->selectStep($question, $_SESSION['quiz_id']);
            $row = mysqli_fetch_array($row);
            //inserting data to options table
            $quiz->createOptions($name, $correctAnswer, $row['id']);
            $i++;
        }    
        $successMessage = 'Question successfully added to quiz';
    }
    

?>