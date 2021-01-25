<?php 
    //  getting calculator id and rendering calculator content, including steps and options 
  
    require ("inc/inc.php");

    if(isset($_GET['id'])) {

        $id = $database->escape_string($_GET['id']);
        $errorMessage = '';
        if(!$quiz->validateInput($id)) {
            // select calculator with matching id
            $oneQuiz = $quiz->getQuiz($id);
            if(!$oneQuiz) {
                header('Location: index.php');
                exit();
            }
        }
    } else {
        header('Location: quizzes.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php 
    require_once('theme/head.php');
    $oneQuiz = mysqli_fetch_array($oneQuiz);
    if($oneQuiz['archived'] == '0') {    
?>

<body style="background-color: #<?php echo $oneQuiz['backgroundColor']; ?>; color: #<?php echo $oneQuiz['color']; ?> ">
    <?php require_once('theme/nav.php'); ?>
    <main>        
        <div class="intro">
            <?php if(isset($_SESSION["errorMessage"])) { ?>
                <h2 class="red"><?php echo "ERROR: " . $_SESSION["errorMessage"] ?? ''; ?></h2>
            <?php } ?> 
            <h1 class="intro__heading"><?php echo $oneQuiz['quizHeading']; ?></h1>
            <p class="intro__paragraph"><?php echo $oneQuiz['quizText']; ?></p>
            <button class="intro__button"><?php echo $oneQuiz['quizButton']; ?></button>
        </div>
        
            <?php
                $stepResult = $quiz->getStep($oneQuiz["id"]);
                if($stepResult->num_rows > 0) { ?>
                <form action="quiz_result.php" method="POST">
                <?php while($stepRow = mysqli_fetch_array($stepResult)) { ?>

                    <div class="input-wrapper step-<?php echo $stepRow['id']; ?>">
                        <h2><?php echo $stepRow['stepName']; ?></h2>
                        <div class="input-wrapper__options">
                            <?php  
                                $optionResult = $quiz->getOptions($stepRow["id"]);
                                while($optionRow = mysqli_fetch_array($optionResult)) { ?>

                                <div>
                                    <input type="radio" name="<?php echo $stepRow['id'] . '-answer'; ?>" id="<?php echo $optionRow['optionName']  . '-' . $stepRow['id']; ?> " value="<?php echo $stepRow['id'] . '-answer-' . $optionRow['id']; ?> ">
                                    <label for="<?php echo $optionRow['optionName'] . '-' . $stepRow['id']; ?> " class="option__label d-flex fd-c ai-c jc-c">
                                        <span class="option-span-text"><?php echo $optionRow['optionName'] ?></span>
                                    </label>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="input-wrapper form login">
                    <div>
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Your name">
                    </div>                    
                    <div>
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Your E-mail">
                    </div>
                    <div>                    
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" placeholder="+38761234567" pattern="+[0-9]{12}">
                    </div>                   
                    <button name="submit" class="intro__button"><?php echo $oneQuiz['quizSubmit']; ?></button>
                    <p><?php echo $oneQuiz['quizNotice']; ?></p>                  
                </div>
                </form>
                
            <?php } else { ?>
                <div class="input-wrapper">
                    <p>No default quizzes or no questions added to current quiz...</p>
                </div>
            <?php } ?>
            
            
    </main>
    <script src="<?php base(); ?>js/script.js"></script>
    <script src="<?php base(); ?>js/check_iframe.js"></script>
    <script src="js/error_message.js"></script>
</body>
<?php } else { ?>
<body>
<?php require_once('theme/nav.php'); ?>
    <main>
        <div class="intro form">
            <h1 class="intro__heading mb-s">Quiz no longer in use...</h1>
            <a href="examples.php" class="intro__button">Check out another quiz</a>
        </div>
    </main>
</body>
<?php } ?>
</html>