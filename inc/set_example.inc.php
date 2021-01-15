<?php 
    // selecting calculator to render on examples page
    
    require("inc_2.php");

    if(!isset($_SESSION['id'])) {
        header('Location: ../login.php');
        exit();
    }

    if(isset($_GET['id'])) {

        $id = htmlspecialchars($_GET['id']);
        $oneQuiz = $quiz->getQuiz($id);
        $oneQuiz = mysqli_fetch_array($oneQuiz);
        if($oneQuiz['user_id'] != $_SESSION['id']) {
            header('Location: ./quizzes.php');
            exit();
        }
        $update = '1';
        $quiz->setExample($id, $update);
        header('Location: ../quizzes.php');
        exit();
    } else {
        header('Location: ../index.php');
        exit();
    }