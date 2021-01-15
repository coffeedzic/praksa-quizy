<?php
    // restore calculator

    require("inc_2.php");

    if(!$_SESSION['fullName']) {
        header('Location: ../login.php');
        exit();
    }
    if(isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
        if(!$quiz->validateInput($id)) {
            $oneQuiz = $quiz->getQuiz($id);
            $oneQuiz = mysqli_fetch_array($oneQuiz);
            if($oneQuiz['user_id'] == $_SESSION['id']) {
                $archived = '0';
                $quiz->archiveQuiz($id, $archived);
                header('Location: ../archived.php');
                exit();
            }
        } else {
            header('Location: ../index.php');
        }
    } else {
        header('Location: ../index.php');
    }
?>