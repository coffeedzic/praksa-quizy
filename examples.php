<?php
    //  rendering user calculators 
    
    require("inc/inc.php")
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('theme/head.php'); ?>
<body>
    <?php require_once('theme/nav.php'); ?>
    <main>
    <div class="main__heading">
        <h1>Examples</h1>
    </div>
    <?php 
        $default = '1';
        $archived = '0';
        $oneQuiz = $quiz->getExamples($default, $archived);
        if($oneQuiz->num_rows > 0) { ?>
            <div class="calculator__wrapper">
            <?php while($row = mysqli_fetch_array($oneQuiz)) { ?>
                <div class="calculator">
                    <h3><?php echo $row['quizName']; ?></h3>
                    <p class="intro__paragraph mb-m"><?php echo $row['quizText']; ?></p>
                    <a class="intro__button bottom" href="quiz.php?id=<?php echo $row['id']; ?>">Check it out</a>
                </div>
        <?php } ?>
            </div>
        <?php } else { ?>
            <p>No default quizzes selected by admin...</p>
        <?php } ?>
        
    </div>
    </main>
</body>
</html>