<?php
    // the file includes create_question for storing provided data and question_form for providing the data 

    require ("inc/inc.php");

    if(!isset($_SESSION['fullName'])) {
        header('Location: login.php');
        exit();
    }
    if(!isset($_SESSION['quiz_id'])) {
        header('Location: create_quiz.php');
        exit();
    }
    $errorMessage = '';
    $successMessage = '';
    if(isset($_POST['finish'])) {
        unset($_SESSION['quiz_id']);
        header('Location: quizzes.php');
        exit();
    }
    if(isset($_POST['submit'])) {
       require_once('inc/create_question.inc.php');
    }

    //

    
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('theme/head.php'); ?>
<body>
    <?php require_once('theme/admin/admin_nav.php'); ?>
    <?php require_once('theme/admin/admin_sidebar.php'); ?>
    <main>
    <div class="main__heading">
        <h1>Add questions</h1>
    </div>
    <form action="" method="POST" enctype="multipart/form-data" class="form">
        <?php require_once('theme/question_form.php'); ?>
        <div class="message">
            <?php if($successMessage) { ?>
                <span class="success__message"><?php echo $successMessage ?? ''; ?></span>
            <?php } elseif ($errorMessage) { ?> 
                <span class="error__message"><?php echo $errorMessage ?? ''; ?></span>
            <?php } else {} ?>
        </div>
        <button name="submit">Save</button>
        <button name="finish">Done</a></button>
    </form>
</main>
<script src="js/script2.js"></script>
<script src="js/error_message.js"></script>
<script src="js/sidebar.js"></script>
</body>
</html>