<?php
    // getting the id of the calculator to render the steps and options

    require("inc/inc.php");

    if(!isset($_SESSION['fullName'])) {
        header('Location: login.php');
        exit();
    }
    if(isset($_GET['id'])){
        $id = $database->escape_string(($_GET['id']));
        $oneQuiz = $quiz->getQuiz($_GET["id"]);
        $oneQuiz = mysqli_fetch_array($oneQuiz);

        if($oneQuiz['user_id'] !== $_SESSION['id'] || $oneQuiz['archived'] === '1') {
            header('Location: quizzes.php');
            exit();
        }
        $_SESSION['quiz_id'] = $oneQuiz['id'];
    } else {
        header('Location: quizzes.php');
    }
?>

<!DOCTYPE html>
<?php require_once('theme/head.php'); ?>
<body>
    <?php require_once('theme/admin/admin_nav.php'); ?>
    <?php require_once('theme/admin/admin_sidebar.php'); ?>
    <main>
    <div class="main__heading"><h1><?php echo $oneQuiz['quizName']; ?></h1></div>
    <?php
    $stepResult = $quiz->getStep($oneQuiz['id']);
    if($stepResult) { 
    ?>
    <form action="edit.inc.php" enctype="multipart/form-data" method="POST">
        <div class="form calculator-form">
            <p class="error-message"></p>
            <div class="d-flex jc-sb gap-m">
                <div>
                    <div class="mb-s">
                        <label for="calculator-name">Quiz Name</label><br>
                        <input type="text" name="<?php echo $oneQuiz['id']; ?>-quizName" id="calculator-name" disabled value="<?php echo $oneQuiz['quizName']; ?>" >
                    </div>
                    <div>
                        <label for="estimate-text">After Text</label>
                        <textarea name="afterText" id="estimate-text" cols="30" rows="5" disabled value="<?php echo $oneQuiz['afterText']; ?>"><?php echo $oneQuiz['afterText']; ?></textarea>
                    </div>
                </div>
                <div>
                    <div class="mb-s">
                        <label for="calculator-heading">Quiz Heading</label>
                        <input type="text" name="quizHeading" id="calculator-heading" disabled value="<?php echo $oneQuiz['quizHeading']; ?>">
                    </div>
                    <div>
                        <label for="calculator-text">Quiz Text</label>
                        <textarea name="quizText" id="calculator-text" cols="30" rows="5" disabled value="<?php echo $oneQuiz['quizText']; ?>"><?php echo $oneQuiz['quizText']; ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="d-flex jc-sb gap-m">
                <div>
                    <label for="calculator-button">Quiz Button Text</label>
                    <input type="text" name="quizButton" id="calculator-button" disabled value="<?php echo $oneQuiz['quizButton']; ?>">
                </div>
                <div>
                    <label for="calculator-submit">Quiz Submit Text</label>
                    <input type="text" name="quizSubmit" id="calculator-submit" disabled value="<?php echo $oneQuiz['quizSubmit']; ?>">
                </div>
            </div>
            <div class="d-flex jc-sb gap-m">
                <div>
                    <label for="calculator-notice">Quiz Notice Text</label>
                    <textarea name="quizNotice" id="calculator-notice" cols="30" rows="5" disabled value="<?php echo $oneQuiz['quizNotice']; ?>"><?php echo $oneQuiz['quizNotice']; ?></textarea>
                </div>
            </div>
            <div class="d-flex jc-sb gap-m">
                <div>
                    <label for="background-color">Choose background color</label>
                    <input type="color" name="backgroundColor" id="background-color" disabled value="#<?php echo $oneQuiz['backgroundColor']; ?>">
                </div>
                <div>
                    <label for="color">Choose text color</label>
                    <input type="color" name="color" id="color" disabled value="#<?php echo $oneQuiz['color']; ?>">
                </div>
            </div>
            <div class="edit-form__icons">
                <span class="edit-icon">
                    <i class="fas fa-edit"></i>
                </span>
            </div>
            <button class="save save__calc" name="saveCalculator">Save</button>
            <button class="cancel">Cancel</button>  
        </div>
        <?php
            
            while($stepRow = mysqli_fetch_array($stepResult)) { ?>
            <div class="form" data-id="<?php echo $oneQuiz['id'] . '-' . $stepRow['id']; ?>">
                <div class="edit-form__question-container" >
                    <h3>Question</h3>
                    <p class="error-message"></p>
                    <input type="text" name="<?php echo $oneQuiz['id'] . '-' . $stepRow['id'] . '-question'; ?>" disabled value="<?php echo $stepRow['stepName']; ?>">
                    <div class="edit-form__icons">  
                        <span class="edit-icon">
                            <i class="fas fa-edit"></i>
                        </span>
                        <a href="inc/delete_step.inc.php?quiz_id=<?php echo $oneQuiz['id'] . '&id=' . $stepRow['id']; ?>"" class="delete-icon">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                    <button name="saveQuestion" class="save save__calc">Save</button>
                    <button class="cancel">Cancel</button>
                </div>
                <div class="calculator-option">
                    <?php
                        $i = 0;
                        $optionResult = $quiz->getOptions($stepRow['id']);
                        while($optionRow = mysqli_fetch_array($optionResult)) { ?>
                        <div class="edit-form__option">
                            <h3>Option <?php echo ++$i; ?></h3>
                            <p class="error-message"></p>
                            <div>
                                <label for="<?php echo $optionRow['id'] . '-optionName'; ?>">Name</label>
                                <input type="text" disabled name="<?php echo $oneQuiz['id'] . '-' . $optionRow['id'] . '-optionName'; ?>" id="<?php echo $optionRow['id'] . '-optionName'; ?>" value="<?php echo $optionRow['optionName']; ?>">
                            </div>
                            <div>
                                <label for="<?php echo $optionRow['id'] . '-' . $optionRow['optionPrice']; ?>">Correct Answer?</label>
                                <input type="checkbox" disabled name="<?php echo $optionRow['id'] . '-optionPrice'; ?>" id="<?php echo $optionRow['id'] . '-optionPrice'; ?>" value="<?php echo $optionRow['optionPrice']; ?>" <?php if($optionRow['optionValue'] == 'on') { echo 'checked';} ?>>
                            </div>
                            <div class="edit-form__icons">
                                <span class="edit-icon">
                                    <i class="fas fa-edit"></i>
                                </span>
                                <a href="../inc/delete_option.inc.php?quiz_id=<?php echo $oneQuiz['id'] . '&id=' . $optionRow['id']; ?>" class="delete-icon">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                            <div class="edit-buttons">
                                <button class="save save__option" name="saveOptions">Save</button>
                                <button class="cancel">Cancel</button>    
                            </div>
                        </div>
                        <?php } ?>
                </div>
                <button class="add-option">Add option</button>
            </div>
            <?php } ?>
    </form>
    <?php } else { ?>
    <div>
        <p>Sorry, you don't have any questions in your Quiz.</p>
    </div>
    <?php } ?>
    <a href="<?php base(); ?>add_question.php?id=<?php echo $id; ?>" id="redirect-link">Add question</a>
    </main>
    <script src="<?php base(); ?>js/sidebar.js"></script>
    <script src="<?php base(); ?>js/edit.js"></script>
    <script src="<?php base(); ?>js/preventSubmit.js"></script>
</body>
</html>