<!-- 
    - updating and adding steps and options for a specific calculator
    - check the POST array for saveOptions, submit or saveQuestion keys
    ### saveOption ###
    - updating options table with updated data
    ### submit ###
    - adding new option to options table
    ### saveQuestion ###
    - updating question table with updated data
 -->
 <?php 
    require("inc/inc.php");

    if(!isset($_SESSION['fullName'])) {
        session_unset();
        header('Location: index.php');
        exit();
    }
    

    // update option
    if(isset($_POST['saveOptions'])) {
        $errorMessage = '';
        foreach($_POST as $k => $v) {
            if (strpos($k, 'optionName')) {
                $errorMessage = $quiz->validateInput($v);
                if($errorMessage) {
                    break;
                }
                $optionName = htmlspecialchars($v);
                $id = htmlspecialchars(explode('-', $k)[1]);
                $quiz_id = htmlspecialchars(explode('-', $k)[0]);
            }
            if(strpos($k, 'optionPrice')) {
                $optionPrice = htmlspecialchars($v);
            }
        }

        if(!$errorMessage) {

            $quiz->updateOptions($id, $optionName, $optionPrice);         
            header('Location: ./edit.php?id=' . $quiz_id);
            exit();

        
        }
    }

    // add one more option to options table 
    if(isset($_POST['submit'])) {
        $errorMessage = '';
        foreach($_POST as $k => $v) {
            if (strpos($k, 'name')) {
                $errorMessage = $quiz->validateInput($v);
                if($errorMessage) {
                    break;
                }
                $optionName = htmlspecialchars($v);
                $step_id = htmlspecialchars(explode('-', $k)[1]);
                $quiz_id = htmlspecialchars(explode('-', $k)[0]);
            }
            if(strpos($k, 'price')) {
                $errorMessage = validateNumber($v);
                if($errorMessage) {
                    break;
                }
                $optionPrice = htmlspecialchars($v);
            }
        }
        if(!$errorMessage) {
            $quiz->createOptions($optionName, $optionPrice, $step_id);
            header('Location: ./edit.php?id=' . $quiz_id);
            exit();
        }
        else {
            header('Location: ./edit.php?i=' . $quiz_id);
            exit();
        }
    }

    //update question field
    if(isset($_POST['saveQuestion'])) {
        require_once('db_connection.php');
        require_once('functions.inc.php');
        foreach($_POST as $k => $v) {
            if(strpos($k, 'question')) {
                $question = htmlspecialchars($v);
                $calc_id = htmlspecialchars(explode('-', $k)[0]);
                $id = htmlspecialchars(explode('-', $k)[1]);
            }
        }
        $query = "UPDATE step SET stepName = ? WHERE id = ?";
        $stmt = $conn->stmt_init();
        if(!$stmt -> prepare($query)) {
            header('Location: ./edit/' . $calc_id . '&error=stmtError');
            exit();
        } else {
            $stmt->bind_param('ss', $question, $id);
            $stmt->execute();
            $stmt->close();
            header('Location: ./edit/' . $calc_id);
            exit();
        }
    }

    // update calculator fields
    if(isset($_POST['saveCalculator'])) {
        $errorMessage = '';
        foreach($_POST as $key => $value) {
            if(empty($_POST[$key]) && $key !== 'saveCalculator') {
                $errorMessage = 'Fields can\'t be empty';
            }
            if(strpos($key, 'quizName')) {
                $quizId = htmlspecialchars(explode('-', $key)[0]);
                $quizName = htmlspecialchars($_POST[$key]);
            }
        }
        $afterText = htmlspecialchars($_POST['afterText']);
        $quizText = htmlspecialchars($_POST['quizText']);
        $quizHeading = htmlspecialchars($_POST['quizHeading']);
        $quizButton = htmlspecialchars($_POST['quizButton']);
        $backgroundColor = substr($_POST['backgroundColor'], 1);
        $backgroundColor = htmlspecialchars($backgroundColor);
        $color = substr($_POST['color'], 1);
        $color = htmlspecialchars($color);
        if(!$errorMessage) {
            $quiz->updateQuiz($quizId, $quizName, $afterText, $quizText, $quizHeading, $quizButton, $backgroundColor, $color);
            header('Location: ./edit.php?id=' . $quizId);
            exit();
        }
    }
    if(!isset($_POST['submit']) || !isset($_POST['saveOption']) || !isset($_POST['saveCalculator']) || !isset($_POST['saveQuestion'])) {
        header('Location: ./quizzes.php');
        exit();
    }
?>