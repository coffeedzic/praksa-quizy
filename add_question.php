<?php 
 
    // including the create_question to save user input to matching table in database, and we include the question_form 

    require("inc/inc.php");
    if(!isset($_SESSION['fullName'])) {
        header('Location: login.php');
        exit();
    }
    $errorMessage = '';
    $successMessage = '';
    $quizId = '';
    //getting the calculator ID so we can return to the same calculator
    if(isset($_GET['id'])) {
        $quizId = htmlspecialchars($_GET['id']);
        $_SESSION['quiz_id'] = $quizId;
    }

    // return to calculator
    if(isset($_POST['finish'])) {
        $base = str_replace('index.php', '',$_SERVER['PHP_SELF']);
        unset($_SESSION['quiz_id']);
        header('Location: edit.php?id=' . $quizId);
        exit();
    }

    // including file where the questions and options are handled
    if(isset($_POST['submit'])) {
        require_once('inc/create_question.inc.php');
     }
?>
<!DOCTYPE html>
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
        <div id="message">
        <?php if($successMessage) { ?>
            <span class="success__message"><?php echo $successMessage ?? ''; ?></span>
        <?php } elseif ($errorMessage) { ?> 
            <span class="error__message"><?php echo $errorMessage ?? ''; ?></span>
        <?php } else {} ?>
        </div>
        <button name="submit">save</button>
        <button name="finish">done</a>
    </form>
</main>
<script src="<?php base(); ?>js/script2.js"></script>
<script src="<?php base(); ?>js/sidebar.js"></script>
</body>
</html>