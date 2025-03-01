<?php include 'header.php'  ?>
        <section id="newvlog">
        <?php
        if(isset($_POST['editvlogbtn']) && isset($_GET['postid'])){

            $postid = $_GET['postid'];
            //echo $editid;
            if(!empty($_FILES['editvlogimage']['name'])){

                $vlogtitle = htmlspecialchars($_POST['editvlogtitle']);
                $vlogdescription = htmlspecialchars($_POST['editvlogdescription']);
                $vlogcategory = htmlspecialchars($_POST['editvlogcategory']);
                $readtime = htmlspecialchars($_POST['editreadtime']);
                $brandname = htmlspecialchars($_POST['editbrandname']);

                $file_name = $_FILES['editvlogimage']['name'];
                $file_size = $_FILES['editvlogimage']['size'];
                $file_tmp = $_FILES['editvlogimage']['tmp_name'];
                $unique_string = uniqid();

                //Get file Extention
                $file_ext = explode('.', $file_name);
                $file_ext = strtolower(end($file_ext));

                $target_dir = './img/'.$unique_string.".".$file_ext;
                $vlogimage_url = $unique_string.".".$file_ext;

                //echo $file_ext;

                //Validate File Extention
                $allowed_extentions = ['png', 'jpg', 'jpeg'];

                if(in_array($file_ext, $allowed_extentions)){
                    if($file_size <= 1000000){

                        move_uploaded_file($file_tmp, $target_dir);

                        $sql2 = "UPDATE vlogpost SET `vlogtitle` = '$vlogtitle', `vlogdescription` = '$vlogdescription',
                        `vlogimage` = '$vlogimage_url', `vlogcategory` = '$vlogcategory', `readtime` = '$readtime',
                         `brandname` = '$brandname' WHERE `postid`= '$postid'";

                        $result2 = $conn->query($sql2);
                        if($result2){
                            header('Location: myvlog.php');
                        }else{
                            echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Cannot Update Vlog Post</div>';
                        }
                    }else{
                        echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">File size should not exceed 1mb</div>';
                    }
                }else{
                    echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">File extention is not allowed</div>';
                }
            }else{

                $vlogtitle = htmlspecialchars($_POST['editvlogtitle']);
                $vlogdescription = htmlspecialchars($_POST['editvlogdescription']);
                $vlogcategory = htmlspecialchars($_POST['editvlogcategory']);
                $readtime = htmlspecialchars($_POST['editreadtime']);
                $brandname = htmlspecialchars($_POST['editbrandname']);

                $sql2 = "UPDATE vlogpost SET `vlogtitle` = '$vlogtitle', `vlogdescription` = '$vlogdescription',
                `vlogcategory` = '$vlogcategory', `readtime` = '$readtime', `brandname` = '$brandname' WHERE `postid`= '$postid'";

                $result2 = $conn->query($sql2);
                if($result2){
                    header('Location: myvlog.php');
                }else{
                    echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Cannot Update Vlog Post</div>';
                }

            }
        }
        ?>
            <!-- <div id="signup-success_box" class="animate__animated animate__backInLeft">Registration Successful</div>
            <div id="signup-erro_box" class="animate__animated animate__backInLeft">Registration Failed</div> -->
            <article id="newvlog_inner">
                <article id="gahna">
                    <h2>Edit Vlog</h2>
                    <p>We are happy to see you again !</p>
                </article>
                <div class="newvlog_grot">
                    <?php
                        if(isset($_GET['postid'])){
                            $postid = $_GET['postid'];

                            $sql = "SELECT * FROM vlogpost WHERE `postid` = '$postid'";

                            $result = $conn->query($sql);
                            if($result){
                                foreach($result as $value){
                                    $vlogtitle = $value['vlogtitle'];
                                    $vlogdescription = $value['vlogdescription'];
                                    $vlogcategory = $value['vlogcategory'];
                                    $vlogimage = $value['vlogimage'];
                                    $vlogdate = $value['vlogdate'];
                                    $readtime = $value['readtime'];
                                    $brandname = $value['brandname'];
                                }
                            }
                        }
                    ?>
                    <h2 class="grotter">Vlog Description</h2>
                    <form action="" method="post" enctype="multipart/form-data" class="newvlog-form1">
                        <label for="">Vlog Title</label><br><br>
                        <input type="text" value="<?php echo $vlogtitle ?>" name="editvlogtitle"><br><br>

                        <label for="">Vlog Description</label><br><br>
                        <textarea name="editvlogdescription" id="" cols="" rows="5"><?php echo $vlogdescription ?></textarea><br><br>

                        <label for="">Brand Name</label><br><br>
                        <input type="text" value="<?php echo $brandname ?>" name="editbrandname" placeholder="The HTSR Network"><br><br>

                    <h2 class="gotter">Category</h2>
                    <div class="newvlog-form2">
                        <p>Vlog Category</p><br>
                        <select name="editvlogcategory" id="">
                            <option value="<?php echo $vlogcategory ?>"><?php echo $vlogcategory ?></option>
                            <option value="tech">Tech</option>
                            <option value="sports">Sports</option>
                            <option value="fashion">Fashion</option>
                            <option value="entertainment">Entertainment</option>
                            <option value="business">Business</option>
                        </select><br><br>
                    </div>
                    <label for="">Read Time</label><br><br>
                    <input type="text" value="<?php echo $readtime ?>" name="editreadtime"><br><br>

                    <h2 class="mock">Media</h2>
                    <div id="newvlog-form3">
                        <input type="file" name="editvlogimage"><br><br>
                        <div class="mike"><img src="img/<?php echo $vlogimage ?>" alt=""></div>
                        <button type="submit" name="editvlogbtn">Update Vlog</button>
                    </div>
                    </form>
                </div>
            </article>
        </section>
     
<?php include 'footer.php'  ?>