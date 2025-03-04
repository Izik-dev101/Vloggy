<?php include 'header.php'  ?>
        <!-- <div id="signup-success_box" class="animate__animated animate__backInLeft">Registration Successful</div>
        <div id="signup-erro_box" class="animate__animated animate__backInLeft">Registration Failed</div> -->
        <section id="profile">
            <article id="profile_inner">
                <article id="faroke">
                    <h2>My Profile</h2>
                    <p>We are happy to see you again !</p>
                </article>
            <?php  UpdateProfile();?>
            <?php ChangePassword(); ?>
            <?php getprofile(); ?>
                <!-- <div id="profile-div1">
                    <h3>Profile Information</h3>
                    <img src="img/profile.png" width="200px" alt="">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="updateimage"><br><br>

                        <label for="">First Name</label><br><br>
                        <input type="text" name="firstname"><br><br>

                        <label for="">Last Name</label><br><br>
                        <input type="text" name="lastname"><br><br>

                        <label for="">Email</label><br><br>
                        <input type="email" name="email"><br><br>

                        <button type="submit" name="updateprofile">Update Profile</button>
                    </form>
                </div> -->
                <div id="profile-div2">
                    <h3>Change Password</h3>
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="">Old Password</label><br><br>
                        <input type="password" name="oldpassword" class="profile-old"><br><br>
                        <ul id="prfile-pass">
                            <li>
                                <label for="">New Password</label><br><br>
                                <input type="password" name="newpassword" ><br><br>
                            </li>
                            <li>
                                <label for="">Confirm New Password</label><br><br>
                                <input type="password" name="conpassword"><br><br>
                            </li>
                        </ul>
                        <button type="submit" name="changepassword">Change Password</button>
                    </form>
                </div>
            </article>
        </section>
<?php include 'footer.php'  ?>