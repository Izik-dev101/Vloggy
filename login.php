<?php include "./dashboard/function.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Vloggy</title>
</head>
<body>
    <section id="login-sec1">
        <article id="login-sec1_inner">
        <?php Login(); ?>
            <a href="index.php" class="login-gbth">Go back to home</a>
            <div id="login-come">
                <h3>Welcome back to Vloggy</h3>
                <form action="" method="post">
                    <!-- <label for="">Email</label><br> -->
                    <input type="email" name="email" class="login-email" placeholder="Enter your email address"><br>
                    <!-- <label for="">Password</label><br> -->
                    <input type="password" name="password" class="login-pass" placeholder="Enter your password"><br>
                    <button class="login-btn" name="loginbtn">Login</button>
                </form>
                <p>Don't have an account yet? <a href="signup.php">Sign up</a></p>
            </div>
            <h2 id="login-den">Vloggy</h2>
        </article>
    </section>
    <script src="js/script.js"></script>
</body>
</html>