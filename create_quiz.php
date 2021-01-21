<?php

    require ("inc/inc.php");
    // create Quiz

    if(!isset($_SESSION['fullName'])) {
        session_unset();
        header('Location: login.php');
        exit();
    }
    $errorMessage = '';
    
    if(isset($_POST['submit'])) {

        foreach($_POST as $key => $value) {
            if(empty($_POST[$key]) && $key !== 'submit') {
                $errorMessage = 'Fields can\'t be empty';
            }
        }

        $quizName = htmlspecialchars($_POST['quizName']);
        $afterText = htmlspecialchars($_POST['afterText']);
        $quizText = htmlspecialchars($_POST['quizText']);
        $quizHeading = htmlspecialchars($_POST['quizHeading']);
        $quizButton = htmlspecialchars($_POST['quizButton']);
        $quizSubmit = htmlspecialchars($_POST['quizSubmit']);
        $quizNotice = htmlspecialchars($_POST['quizNotice']);
        $backgroundColor = substr($_POST['backgroundColor'], 1);
        $backgroundColor = htmlspecialchars($backgroundColor);
        $color = substr($_POST['color'], 1);
        $color = htmlspecialchars($color);

        if(!$errorMessage) {
            if( $id = $quiz->createQuiz($quizName, $afterText, $quizHeading, $quizText, $quizButton, $quizSubmit, $quizNotice, $backgroundColor, $color, $_SESSION['id'])) {
                $_SESSION['quiz_id'] = $id;
                header('Location: questions.php');
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('theme/head.php'); ?>
<body>
    <?php require_once('theme/admin/admin_nav.php'); ?>
    <?php require_once('theme/admin/admin_sidebar.php'); ?>
    <main>
        <form action="" method="POST" enctype="multipart/form-data" class="form login">
        <div class="main__heading">
            <h1>Create a Quiz</h1>
        </div>
        <div>
            <label for="quizName">Quiz Name</label><br>
            <input type="text" name="quizName" id="quiz-name" value="<?php echo $_POST['quizName'] ?? ''; ?>">
        </div>
        <div>
            <label for="afterText">Say something to user when he complete the Quiz</label>
            <textarea name="afterText" id="afterText" cols="30" rows="5" placeholder="What text to display when user finish the quiz..." value="<?php echo $_POST['quizText'] ?? ''; ?>"></textarea>
        </div>
        <div>
            <label for="quiz-heading">Calculator Heading</label>
            <input type="text" name="quizHeading" id="quiz-heading" value="<?php echo $_POST['quizHeading'] ?? ''; ?>">
        </div>
        <div>
            <label for="quiz-text">Quiz Text</label>
            <textarea name="quizText" id="quiz-text" cols="30" rows="5" placeholder="Quiz description..." value="<?php echo $_POST['quizText'] ?? ''; ?>"></textarea>
        </div>
        <div>
            <label for="quiz-button">Quiz Button Text</label>
            <input type="text" name="quizButton" id="quiz-button" value="<?php echo $_POST['quizButton'] ?? ''; ?>">
        </div>
        <div>
            <label for="quiz-submit">Quiz Submit Text</label>
            <input type="text" name="quizSubmit" id="quiz-submit" value="<?php echo $_POST['quizSubmit'] ?? ''; ?>">
        </div>
        <div>
            <label for="quiz-notice">Quiz Notice Text</label>
            <textarea name="quizNotice" id="quiz-notice" cols="30" rows="5" placeholder="Message to user before he go to results" value="<?php echo $_POST['quizNotice'] ?? ''; ?>"></textarea>
        </div>
        <div>
            <label for="background-color">Choose background color</label>
            <input type="color" name="backgroundColor" id="background-color" value="#f4f6f9">
        </div>
        <div>
            <label for="color">Choose text color</label>
            <input type="color" name="color" id="color" value="#212529">
        </div>
        <button type="submit" name="submit">Submit</button>
        <div class="message">
            <?php if($errorMessage) { ?>
                <span class="error__message"><?php echo $errorMessage ?? ''; ?></span>
            <?php } ?>
        </div>
    </form>
</main>
<script src="js/sidebar.js"></script>
<script src="js/error_message.js"></script>
</body>
</html>

