<header>
    <nav class="navigation index-nav">
        <a href="index.php" class="navigation__link logo">Quizy.</a>
        <ul class="navigation__menu">
            <?php if(isset($_SESSION['id'])) { ?>
                <li><a href="<?php base(); ?>quizzes.php" class="navigation__link">Dashboard</a></li>
                <li><a href="<?php base(); ?>logout.php" class="navigation__link">Logout</a></li>
            <?php } else { ?>
                <li><a href="<?php base(); ?>login.php" class="navigation__link">Login</a></li>
                <li><a href="<?php base(); ?>register.php" class="navigation__link">Register</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>