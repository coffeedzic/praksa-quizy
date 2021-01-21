<?php
    // - sanitizing user input and finding user in database
    require ("inc/inc.php");
    
    if(isset($_SESSION['id'])) {
        header('Location: index.php');
        exit();
    }
    
    $errorMessage = '';
    if(isset($_POST['submit'])) {

        $email = $_POST['email'];
        $email = htmlspecialchars($email);
        $password = $_POST['password'];
        $password = htmlspecialchars($password);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = 'Please provide valid email';
        } else {
            $errorMessage = $users->findUser($email, $password);
        }

    }
?>

<!DOCTYPE html>
<?php require_once('theme/head.php'); ?>
<body>
    <?php require_once('theme/nav.php'); ?>
    <main>
        
    <form action="" method="POST" class="form login">
        <div class="main__heading">
            <h1>Login</h1>
        </div>
        <div>
            <label for="email">Email address</label> <br>
            <input type="text" name="email" id="email" value="<?php echo isset($_POST['submit']) ? $email : '' ; ?>">
        </div>
        <div>
            <label for="password">Password</label> <br>
            <input type="password" name="password" id="password" value="<?php echo isset($_POST['submit']) ? $password : '' ; ?>">
        </div>
        <span class="error"> <?php echo $errorMessage ?? ''; ?> </span>
        <button type="submit" name="submit">Login</button>
        <p>New user? <a href="register.php" class="info">Create account</a>.</p>
    </form>
    
</main>
</body>
</html>