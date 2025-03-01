<?php include "./dashboard/function.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="css/style.css">
    <title>Vloggy</title>
</head>
<body>
    <header>
        <section id="dropdownbox">
            <div id="exiticon">X</div>
            <ul id="caseup">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="mailto:vloggycare@gmail.com">Email Us</a></li>
                <li><a href="https://wa.me/+27679481745" target="_blank">Contact Us</a></li>
            </ul>
            <ul id="bookup">
                <li><a href="category.php?cat=news">News</a></li>
                <li><a href="category.php?cat=tech">Tech</a></li>
                <li><a href="category.php?cat=fashion">Fashion</a></li>
                <li><a href="category.php?cat=sports">Sports</a></li>
                <li><a href="category.php?cat=business">Business</a></li>
                <li><a href="category.php?cat=entertainment">Entertainment</a></li>
            </ul>
            <ul id="markup">
                <li class="wait"><a href="https://www.twitter.com"><img src="img/twitter.png" alt=""></a></li>
                <li id="booker"><a href="https://www.facebook.com"><img src="img/facebook.png" alt=""></a></li>
                <li class="instant"><a href="https://www.intagram.com"><img src="img/instagram.png" alt=""></a></li>
                <li id="liker"><a href="https://www.linkedin.com"><img src="img/linkedin.png" alt=""></a></li>
            </ul>
        </section>

        <ul id="fronter">
            <li><a href="category.php?cat=tech">Tech</a></li>
            <li><a href="category.php?cat=sports">Sports</a></li>
            <li><a href="category.php?cat=business">Business</a></li>
            <li><a href="category.php?cat=entertainment">Entertainment</a></li>
        </ul>

        <nav>
            <a href="index.php" id="logo">vloggy</a>
            <ul id="nav_ul1">
                <li class="hymn"><a href="index.php">Home</a></li>
                <li id="cast"><a href="category.php?cat=news">News</a></li>
                <li class="wear"><a href="category.php?cat=fashion">Fashion</a></li>
                <li id="might">More <span class="what"><img src="img/angle-small-down.png" alt=""></span></li>
                <!-- <li><a href="login.php" class="goto">Sign In</a></li> -->
                <!-- <li class="gut"><a href="dashboard/index.php"><img src="img/profile.png" width="30px" alt=""></a></li> -->

                <li class="wait"><a href="https://www.twitter.com"><img src="img/twitter.png" alt=""></a></li>
                <li id="booker"><a href="https://www.facebook.com"><img src="img/facebook.png" alt=""></a></li>
                <li class="instant"><a href="https://www.intagram.com"><img src="img/instagram.png" alt=""></a></li>
                <li id="liker"><a href="https://www.linkedin.com"><img src="img/linkedin.png" alt=""></a></li>
                <li class="burger"><img src="img/burger.png" alt=""></li>
                <?php
                   if(isset($_SESSION['username'])){
                        CheckProfileImage_frontend();
                   }else{
                    echo '<li><a href="login.php" class="goto">Sign In</a></li';
                   }
                ?>
            </ul>
        </nav>
    </header>