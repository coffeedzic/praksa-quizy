<?php  
    // delete option user selected
    // ## functions ##
    // selectOne - takes three arguments: connection, id, query, returns row from database table depending on query
    // delete - takes three arguments: connection, id, query, deletes row from database table

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
                //finding the options row to remove the images from images folder
                $quiz->deleteOption($id);
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