<?php

class Users {

    public function validateUserInput($fullName, $email, $password, $confirmPassword) {

        $error = false;

        if(empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
            $error = "Fields can\'t be empty";
            return $error;
        }

        if(!preg_match('/^[a-zA-Z0-9\s]*$/', $fullName)) {
            $error = 'Please provide valid full name';
            return $error;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please provide valid email';
            return $error;
        }

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);

        if(!$uppercase || !$lowercase || !$number || strlen($password) < 6) {
            $error = 'Password must be a minimum of 6 characters, must contain 1 number, 1 uppercase and 1 lowercase character';
            return $error;
        }

        if($password !== $confirmPassword) {
            $error = 'Passwords must match';
            return $error;
        }

        if(!$this->userExists($email)) {
            $error = 'Email already taken';
        }

        return $error;

    }

    public function createUser($fullName, $email, $password) {

        global $database;

        $fullName = $database->escape_string($fullName);
        $email = $database->escape_string($email);
        $password = $database->escape_string($password);

        $hashedPassword = md5($password);

        $sql = ("INSERT INTO users (fullName, userEmail, userPassword) VALUES ('" . $fullName . "','" . $email . "','" . $hashedPassword . "')");

        if($database->query($sql)) {
     
            return true;
      
        } else {
      
            return false;
      
        }    

    }

    public function findUser($email, $password) {

        $error = false;
        $check = $this->userExists($email);
        $user = $this->getUser($email);
        $user = mysqli_fetch_array($user);

        if(!$check) {
            $error = "Wrong email or password.";
            return $error;
        }        

        if(isset($user["userPassword"]) && md5($password) == $user["userPassword"]) {

            $_SESSION["fullName"] = $user["fullName"];
            $_SESSION["id"] = $user["id"];
            header('Location: quizzes.php');
            exit();
        } else {
            $error = "Wrong email or password.";
            return $error;
        }
    }

    public function userExists($email) {

        global $database;

        $sql = "SELECT * FROM users WHERE userEmail = '" . $email . "'";

        if($database->query($sql)) {            
            
            return true;
      
        } else {
            
            $error = "Error";
            return $error;
      
        }
        
    }

    private function getUser($email) {

        global $database;

        $sql = "SELECT * FROM users WHERE userEmail = '" . $email . "'";

        return $database->query($sql);
    }

}

$users = new Users;