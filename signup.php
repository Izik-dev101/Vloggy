<?php include "./dashboard/function.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="css/style.css">
    <title>Vloggy</title>
</head>
<body>
    <section id="signup-sec1">
        <article id="signup-sec1_inner">
            <?php RegisterUser(); ?>
            <!-- <div id="signup-success_box" class="animate__animated animate__backInLeft">Registration Successful</div>
            <div id="signup-erro_box" class="animate__animated animate__backInLeft">Registration Failed</div> -->
            <a href="index.php" id="signup-gbth">Go back to home</a>
            <div id="signup-sign">
                <h3>Sign Up to Vloggy</h3>
                <form action="" method="post">
                    <!-- <label for="">First Name</label><br>  -->
                    <input type="text" name="username" placeholder="Enter your preferred username" class="signup-username"><br>
                    <!-- <label for="">Last Name</label><br> -->
                    <input type="text" name="firstname" placeholder="Enter your first name" class="signup-firstname"><br>
                    <!-- <label for="">Last Name</label><br> -->
                    <input type="text" name="lastname" placeholder="Enter your last name" class="signup-lastname"><br>
                    <!-- <label for="">Email</label><br> -->
                    <input type="email" name="email" placeholder="Enter your email address" class="signup-email"><br>
                    <!-- <label for="">Password</label><br> -->
                    <input type="password" name="password" placeholder="Enter your password" class="signup-password"><br>
                    <input type="password" name="confirm-password" placeholder="Comfirm your password" class="signup-comfirm"><br>
                    <button class="signup-btn" name="registerbtn" type="submit">Register</button>
                </form>
                <p class="yartzed">Signed up already? <a href="login.php">Login</a></p>
            </div>
            <h2 id="signup-gets">Vloggy</h2>
        </article>
    </section>
    <script src="js/script.js"></script>
</body>
</html>