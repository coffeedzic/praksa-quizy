<?php
require ("inc/inc.php");
?>

<!DOCTYPE html>
<?php require_once('theme/head.php'); ?>
<body>
<?php if(isset($_SESSION['fullName'])) {
        require_once('theme/admin/admin_nav.php');
        require_once('theme/admin/admin_sidebar.php');
} else {
    require_once('theme/nav.php'); 
}
?>
<div class="hero">
    <div class="hero__text">
        <h1>Take or create a Quiz!</h1>
        <p>
            Take quizzes that our users have created or sign up and create your own quiz
        </p>
        <a href="examples.php" class="intro__button">Find a Quiz</a>
        <?php if(!isset($_SESSION['fullName'])) { ?>
            <a href="register.php" class="intro__button">Sign up</a>
        <?php } ?>
    </div>
    <div class="hero__image">
        <img src="images/finance.svg" alt="Personal finance">
    </div>
</div>
<script src="<?php base(); ?>js/sidebar.js"></script>
</body>
</html>