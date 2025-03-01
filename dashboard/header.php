<?php include "function.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Vloggy</title>
</head>
<body>
    <header>
        <nav>
        <div id="zik"><a href="../index.php">Vloggy</a></div>
        <div id="tobi">Hello, 
            <?php
            if(isset($_SESSION['username'])){
                echo $_SESSION['username'];
            }
            ?>
        </div>
            <ul id="nav_ul1">
                <li class="foxt"><div id="switchBtnCon"><span class="switchBtn"></span></div></li>
                <li class="envi"><a href="mailto:vloggycare@gmail.com">Email Us</a></li>
                <li class="noti"><a href="https://wa.me/+27679481745" target="_blank">Contact Us</a></li>
                <li id="weep"><img src="img/burger.png" alt=""></li>
                <!-- <li id="mecat"><a href="profile.php"><img src="img/profile.png" width="30px" alt=""></a></li> -->
                <?php CheckProfileImage2(); ?>
            </ul>
        </nav>
    </header>
    <aside id="sidebar">
        <ul id="nay">
            <li class="dash">
                <a href="index.php"><img src="img/dashboard.png" alt=""> Dashboard</a>
            </li>
            <li class="cret">
                <a href="newvlog.php"><img src="img/shopping-bag-add.png" alt=""> Post A Vlog</a>
            </li>
            <li class="view">
                <a href="myvlog.php"><img src="img/home-heart.png" alt=""> My Vlogs</a>
            </li>
            <li class="pro">
                <a href="profile.php"><img src="img/user.png" alt=""> My Profile</a>
            </li>
            <li class="lot">
                <a href="logout.php"><img src="img/sign-out-alt.png" alt=""> Logout</a>
            </li>
        </ul>
    </aside>
    <main id="main-content">