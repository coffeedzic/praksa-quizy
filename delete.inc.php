<?php 
    //  archive calculator
    // ## functions ##
    // * select - takes three arguments: connection, id, query. Returns every matching row from table provided by query
    // * unlink - removes image file from images folder

    require("inc/inc.php");
    if(!$_SESSION['fullName']) {
        header('Location: login.php');
        exit();
    }
    if(isset($_GET['id'])) {
        
        $id = htmlspecialchars($_GET['id']);
        if(!$quiz->validateInput($id)) {
            $oneQuiz = $quiz->getQuiz($id);
            $oneQuiz = mysqli_fetch_array($oneQuiz);
            if($oneQuiz['user_id'] == $_SESSION['id']) {
                $archived = '1';
                $quiz->archiveQuiz($id, $archived);
                header('Location: quizzes.php');
                exit();
            }
        } else {
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }