<?php include 'header.php'  ?>
        <section id="newvlog">
            <article id="newvlog_inner">
            <!-- <div id="signup-success_box" class="animate__animated animate__backInLeft">Registration Successful</div>
            <div id="signup-erro_box" class="animate__animated animate__backInLeft">Registration Failed</div> -->
                <article id="gahna">
                    <h2>Add New Vlog</h2>
                    <p>We are happy to see you again !</p>
                </article>
                <?php Addvlog(); ?>
                <div class="newvlog_grot">
                    <h2 class="grotter">Vlog Description</h2>
                    <form action="" method="post" enctype="multipart/form-data" class="newvlog-form1">
                        <label for="">Vlog Title</label><br><br>
                        <input type="text" name="vlogtitle" required><br><br>

                        <label for="">Vlog Description</label><br><br>
                        <textarea name="vlogdescription" id="" cols="" rows="5" required></textarea><br><br>

                        <label for="">Brand Name</label><br><br>
                        <input type="text" name="brandname" placeholder="The HTSR Network" required><br><br>

                    <h2 class="gotter">Category</h2>
                    <div class="newvlog-form2">
                        <p>Vlog Category</p><br>
                        <select name="vlogcategory" id="">
                            <option value="">Select Category</option>
                            <option value="tech">Tech</option>
                            <option value="news">News</option>
                            <option value="sports">Sports</option>
                            <option value="fashion">Fashion</option>
                            <option value="entertainment">Entertainment</option>
                            <option value="business">Business</option>
                        </select><br><br>
                     </div>
                    <label for="">Read Time</label><br><br>
                    <input type="text" name="readtime"><br><br>

                    <h2 class="mock">Media</h2>
                    <div id="newvlog-form3">
                        <input type="file" name="vlogimage"><br><br>
                        <button type="submit" name="submitvlogbtn">Submitt Vlog</button>
                    </div>
                    </form>
                </div>
            </article>
        </section>
<?php include 'footer.php'  ?>