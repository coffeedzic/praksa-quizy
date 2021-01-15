<?php
    // rendering archived calculators

    require("inc/inc.php");

    if(!isset($_SESSION['fullName'])) {
        session_unset();
        header('Location: login.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('theme/head.php'); ?>
<body>
    <?php require_once('theme/admin/admin_nav.php'); ?>
    <?php require_once('theme/admin/admin_sidebar.php'); ?>
    <main>
    <div class="main__heading">
        <h1>Dashboard</h1>
    </div>
    <?php
        $archived = "1";
        $oneQuiz = $quiz->getQuizzes($_SESSION["id"], $archived);
        if($oneQuiz->num_rows > 0) { ?>
            <div class="calculator__wrapper">
            <?php while($row = mysqli_fetch_array($oneQuiz)) { ?>
                <div class="calculator">
                    <h3 class="calculator__heading">
                        <a href="<?php echo 'quiz.php?id=' .  $row['id']; ?>">
                            <?php echo $row['quizName']; ?>
                        </a>
                        <span class="calculator__span">Click on quiz name to preview</span>
                    </h3>
                    <span class="calculator__date">Created: <?php $time = strtotime($row['date']); echo date('d-m-Y H:i', $time) ; ?></span>
                    <a href="inc/restore.inc.php?id=<?php echo $row['id']; ?>" class="calculator__btn edit m-width">Restore</a>
                </div>
        <?php } ?>
            </div>
        <?php } else { ?>
            <p>You don't have any quizzes in archive...</p>
        <?php } ?>
        
    </div>
    </main>
    <script src="js/sidebar.js"></script>
</body>
</html>