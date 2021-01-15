<?php 
//     delete step and options selected from user from database
//     ## functions ##
//     * select - takes three arguments: connection, id, query. Returns every matching row from table provided by query

    require("inc_2.php");

    if(!$_SESSION['fullName']) {
        header('Location: ../login.php');
        exit();
    }
    if(isset($_GET['id']) && isset($_GET['quiz_id'])) {
        $id = htmlspecialchars($_GET['id']);
        $quizId = htmlspecialchars($_GET['quiz_id']);
        if(!$quiz->validateInput($id) && !$quiz->validateInput($quizId)) {

            // verifying that the step belongs to the current user
            $oneQuiz = $quiz->getQuiz($quizId);
            $oneQuiz = mysqli_fetch_array($oneQuiz);
            if($oneQuiz['user_id'] == $_SESSION['id']) {

                //deleting the step and options
                
                $step = $quiz->getStep($id);
                if($step->num_rows > 0) {
                    while($row = mysqli_fetch_array($step)) {
                        $quiz->deleteStepOptions($row['id']);
                    }
                }
                $quiz->deleteStep($id);
                header('Location: ../edit.php?id=' . $quizId);
                exit();
            }
        } else {
            header('Location: ../index.php');
        }
    } else {
        header('Location: ../index.php');
    }

?>