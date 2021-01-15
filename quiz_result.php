<?php

require ("inc/inc.php");

if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["phone"])) {
    header('Location: index.php');
} else {

if(isset($_POST["submit"])) {
    $fullName = $database->escape_string($_POST["name"]);
    $email = $database->escape_string($_POST["email"]);
    $phone = $database->escape_string($_POST["phone"]);
    $result = $quiz->validateFolk($email);
    if($result->num_rows > 0) {
        $folk = $quiz->validateFolk($email);
        $folk = mysqli_fetch_array($folk);
        $_SESSION["folk_id"] = $folk["id"];
        $_SESSION["attempt"] = $folk["attempts"] + 1;
        $quiz->createAttempt($folk["id"], $_SESSION["attempt"]);        
    } else {        
        $_SESSION["folk_id"] = $quiz->createFolk($fullName, $email, $phone);
        $_SESSION["attempt"] = 0;
    }
    
} else {
    header('Location: index.php');
    exit();
}

foreach ($_POST as $k => $v) {
    if(strpos($k, 'answer')) {
        $stepId = explode('-', $v)[0];
        $quiz_id = $quiz->getStepById($stepId);
        $quiz_id = mysqli_fetch_array($quiz_id);
        $_SESSION["current_quiz"] = $quiz_id["quiz_id"];
    }
}

}

?>

<!DOCTYPE html>
<html lang="en">
<?php
    require_once('theme/head.php');
    $oneQuiz = $quiz->getQuiz($_SESSION["current_quiz"]);
    $oneQuiz = mysqli_fetch_array($oneQuiz);
?>

<body style="background-color: #<?php echo $oneQuiz['backgroundColor']; ?>; color: #<?php echo $oneQuiz['color']; ?> ">
    <?php require_once('theme/nav.php'); ?>
    <main>
        <div class="intro">
            <h1 class="intro__heading"><?php echo $oneQuiz['quizHeading']; ?></h1>
            <p class="intro__paragraph"><?php echo $oneQuiz['afterText']; ?></p>
        </div>

        <?php

        $i = 0;
        $ca = 0;

        foreach($_POST as $k => $v) {

            if(strpos($k, 'answer')) {
                $id = $database->escape_string((explode('-', $v)[2]));
                $stepId = explode('-', $v)[0];
        
                $step = $quiz->getStepById($stepId);
                $options = $quiz->getOptions($stepId);
                $step = mysqli_fetch_array($step);
        
        
                $id = strval($id);
                $id = substr($id, 0, -1);

                echo "<div class='answer-wrapper'>";
                echo "<h2>" . $step['stepName'] . "</h2>";
                echo "<div class='answers'>";
        
                while ($row = mysqli_fetch_array($options)) {

                                 
                    
                    if($id == $row["id"] && $row["optionValue"] == "on") {
                        echo "<button class='ans right'>" . $row["optionName"] . "</button>";
                        $ca = $ca + 1;
                        $answer = 1;
                        
                    } else if($id == $row["id"] && $row["optionValue"] != "on") {
                        echo "<button class='ans wrong'>" . $row["optionName"] . "</button>";
                        $answer = 0;
                    } else {
                        echo "<button class='ans'>" . $row["optionName"] . "</button>";
                    }

                    if($id == $row["id"]) {
                        $quiz->answers($answer, $_SESSION["folk_id"], $row["id"], $_SESSION["attempt"]);
                    }
        
                }

                echo "<p>EXPLANATION: " . $step['stepDescription'] . "</p>";

                $i++;               

                echo "</div></div>";
        
            }

        }
        
        $percentage = ($ca/$i) * 100;

        
        echo "<center><p>Congratulations, you completed the Quiz. Your score is: $percentage%</p></center>";
        