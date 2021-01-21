<?php

class Quiz {

    public function createQuiz($quizName, $afterText, $quizHeading, $quizText, $quizButton, $quizSubmit, $quizNotice, $backgroundColor, $color, $id) {

        global $database;

        $quizName = $database->escape_string($quizName);
        $afterText = $database->escape_string($afterText);
        $quizHeading = $database->escape_string($quizHeading);
        $quizText = $database->escape_string($quizText);
        $quizButton = $database->escape_string($quizButton);
        $quizSubmit = $database->escape_string($quizSubmit);
        $quizNotice = $database->escape_string($quizNotice);
        $backgroundColor = $database->escape_string($backgroundColor);
        $color = $database->escape_string($color);
        $id = $database->escape_string($id);

        $sql = "INSERT INTO quiz (quizName, afterText, quizHeading, quizText, quizButton, quizSubmit, quizNotice, backgroundColor, color, user_id) VALUES ('";
        $sql .= $quizName . "','" . $afterText . "','" . $quizHeading . "','" . $quizText . "','" . $quizButton . "','" . $quizSubmit . "','" . $quizNotice . "','" . $backgroundColor . "','";
        $sql .= $color . "','" . $id . "')";

        $result = $database->query($sql);

        return $database->the_insert_id();

    }

    public function validateInput($string) {

        $error = false;
        if(empty($string)) {
            $error = 'Question and option fields can\'t be empty';
            return $error;
        }
        if(!preg_match('/^[a-z0-9A-Z\s\?]*$/', $string)) {
            $error = 'Please provide valid input, no special characters allowed in option and question fields';
            return $error;
        }
        return $error;
    }

    public function createStep($question, $exp, $id) {

        global $database;

        $sql = "INSERT INTO step (stepName, stepDescription, quiz_id) VALUES ('" . $question . "','" . $exp . "','" . $id . "')";

        if($database->query($sql)) {
            return false;
        } else {
            $error = "Error!";
            return $error;
        }
    }

    public function selectStep($name, $id) {

        global $database;
        $error = false;

        $sql = "SELECT * FROM step WHERE stepName = '" . $name . "' AND quiz_id = '" . $id . "'";

        $result = $database->query($sql);

        return $result;

    }

    public function createOptions($name, $correctAnswer, $id) {

        $error = false;
        
        global $database;

        $sql = "INSERT INTO options (optionName, optionValue, step_id) VALUES ('" . $name . "','" . $correctAnswer . "','" . $id . "')";

        if($database->query($sql)) {
            return $error;
        } else {
            $error = "Error!";
            return $error;
        }

    }

    public function getQuizzes($id, $archived) {

        global $database;

        $sql = "SELECT * FROM quiz WHERE user_id = '" . $id . "' AND archived = '" . $archived . "' ORDER BY id DESC";

        $result = $database->query($sql);

        return $result;

    }

    public function getQuiz($id) {

        global $database;

        $sql = "SELECT * FROM quiz WHERE id = '" . $id . "'";

        $result = $database->query($sql);

        return $result;

    }

    public function getStep($id) {

        global $database;

        $sql = "SELECT * FROM step WHERE quiz_id = '" . $id . "'";

        $result = $database->query($sql);

        return $result;
        
    }

    public function getStepById($id) {

        global $database;

        $sql = "SELECT * FROM step WHERE id = '" . $id . "'";

        $result = $database->query($sql);

        return $result;
        
    }

    public function getOptions($id) {

        global $database;

        $sql = "SELECT * FROM options WHERE step_id = '" . $id . "'";

        $result = $database->query($sql);

        return $result;
        
    }

    public function validateFolk($email) {

        global $database;

        $sql = "SELECT * FROM folk WHERE email = '" . $email . "'";

        $result = $database->query($sql);

        return $result;

    }

    public function createFolk($name, $email, $phone) {

        global $database;

        $sql = ("INSERT INTO folk (fullName, email, phone) VALUES ('" . $name . "','" . $email . "','" . $phone . "')");

        if($database->query($sql)) {
     
            return true;
      
        } else {
            
            $error = "Error";
            return $error;
      
        }

    }

    public function answers($answer, $user_id, $option_id, $attempt) {

        global $database;

        $sql = ("INSERT INTO answers (answer, user_id, option_id, attempt) VALUES ('" . $answer . "','" . $user_id . "','" . $option_id .  "','" . $attempt . "')");

        return $database->query($sql);
        

    }

    public function createAttempt($id, $attempt) {

        global $database;

        $sql = ("UPDATE folk SET attempts = $attempt WHERE id = '" . $id . "'");

        $result = $database->query($sql);

        return $result; 

    }

    public function archiveQuiz($id, $arch) {

        global $database;

        $sql = ("UPDATE quiz SET archived = '"  . $arch . "' WHERE id = '" . $id . "'");

        $result = $database->query($sql);

        return $result;         

    }

    public function getExamples($default, $archived) {

        global $database;

        $sql = "SELECT * FROM quiz WHERE defaultQuiz = '" . $default. "' AND archived = '" . $archived . "' ORDER BY id DESC";

        $result = $database->query($sql);

        return $result;

    }

    public function setExample($id, $example) {

        global $database;

        $sql = "UPDATE quiz SET defaultQuiz = '" . $example . "' WHERE id = '" . $id . "'";

        $result = $database->query($sql);

        return $result;

    }

    public function updateQuiz($id, $name, $atext, $text, $heading, $button, $submit, $notice, $bg, $color) {

        global $database;

        $sql = "UPDATE quiz SET quizName = '" . $name . "', afterText = '" . $atext . "', quizText = '" . $text . "', quizHeading = '" . $heading . "', ";
        $sql .= "quizButton = '" . $button . "', quizSubmit = '" . $submit . "', quizNotice = '" . $notice . "', backgroundColor = '" . $bg . "', color = '" . $color . "' WHERE id = '" . $id . "'";

        $result = $database->query($sql);

        return $result;

    }

    public function updateOptions($id, $name, $chck) {

        global $database;

        $sql = "UPDATE options SET optionName = '" . $name . "', optionValue = '" . $chck . "' WHERE id = '" . $id . "'";

        $result = $database->query($sql);

        return $result;

    }

    public function deleteOption($id) {
        
        global $database;

        $sql = "DELETE FROM options WHERE id = $id";

        return $database->query($sql);

    }

    public function deleteStepOptions($id) {
        
        global $database;

        $sql = "DELETE FROM options WHERE step_id = $id";

        return $database->query($sql);

    }

    public function deleteStep($id) {
        
        global $database;

        $sql = "DELETE FROM step WHERE id = $id";

        return $database->query($sql);

    }
}

$quiz = new Quiz;

?>