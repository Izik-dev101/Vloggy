<?php include 'header.php' ?>
    <main>
        <section id="singlepage-sec1">
            <article id="singlepage-sec1_inner">
            <?php PostComments(); ?>
            <!-- <div id="signup-success_box" class="animate__animated animate__backInLeft">Registration Successful</div>
            <div id="signup-erro_box" class="animate__animated animate__backInLeft">Registration Failed</div> -->
                <div id="singlepage-great">
                    <?php getSinglePost(); ?>
                    <?php post_views(); ?>
                    <!-- <ul class="singlepage-big">
                        <li class="singlepage-gro">tech</li>
                        <li class="singlepage-date">2024-02-07 00:00:00</li>
                        <li class="singlepage-time">3 min read</li>
                    </ul>
                    <article id="singlepage-sell">
                        <h3>Web development has proven to have more employers as many institutions needs a website</h3>
                    </article>
                     <ul id="index-maraton">
                        <li class="index-comments">comments</li>
                        <li class="index-likes">
                        <span id="like-count">Likes:</span>
                        <button class="like-button" id="like-button">Like</button>
                        </li>
                        <li class="index-share">
                        <span id="share-count">Shares:</span>
                        <button class="share-button" id="share-button">Share</button>
                        </li>
                    </ul>
                    <div class="singlepage-hom"><img src="img/web dev.PNG" alt="" ></div>
                    <p>
                        Web development has proven to have more employers as many institutions needs a website, Web development has proven to have more employers as many institutions needs a website
                        Web development has proven to have more employers as many institutions needs a website, Web development has proven to have more employers as many institutions needs a website
                        Web development has proven to have more employers as many institutions needs a website, Web development has proven to have more employers as many institutions needs a website 
                    </p> -->

                    <div id="comments">All Comments</div>
                    <?php GetComments(); ?>
                    <!-- <article id="singlepage-art1">
                        <div class="singlepage-art1_d1"><img src="img/ee288e2d3e24b4f51171b20b3bda7d87.jpg"  alt=""></div>
                        <div class="singlepage-art1_d2">
                            <ul id="singlepage-tech">
                                <li class="singlepage-seamt">Grace Martins</li>
                                <li id="singlepage-timer">2024-02-07 00:00:00</li>
                                <li class="singlepage-read"><button class="reply-button">Reply</button></li>
                                <li id="form-container" class="form-container" style="display:none;">
                                <form method="POST" class="formula" action="" id="formtag">
                                    <div id="westergot"><textarea name="content" placeholder="Your Reply:"></textarea></div>
                                    <div id="controlpan">
                                        <button type="submit">Post Reply</button>
                                        <input type="hidden" name="post_id" value="1">
                                        <input type="hidden" name="reply_to" value="2">
                                    </div>
                                </form>
                                </li>
                            </ul>
                            <div id="proxy">Web development has proven to have more employers as many institutions now has a website
                               Web development has proven to have more employers as many institutions now has a website
                            </div>
                        </div>
                    </article>

                    <article id="singlepage-art1">
                        <div class="singlepage-art1_d1"><img src="img/ee288e2d3e24b4f51171b20b3bda7d87.jpg"  alt=""></div>
                        <div class="singlepage-art1_d2">
                            <ul id="singlepage-tech">
                                <li class="singlepage-seamt">Grace Martins</li>
                                <li id="singlepage-timer">2024-02-07 00:00:00</li>
                                <li class="singlepage-read"><button class="reply-button">Reply</button></li>
                                <li id="form-container" class="form-container" style="display:none;">
                                <form method="POST" class="formula" action="" id="formtag">
                                    <div id="westergot"><textarea name="content" placeholder="Your Reply:"></textarea></div>
                                    <div id="controlpan">
                                        <button type="submit">Post Reply</button>
                                        <input type="hidden" name="post_id" value="1">
                                        <input type="hidden" name="reply_to" value="2">
                                    </div>
                                </form>
                                </li>
                            </ul>
                            <div id="proxy">Web development has proven to have more employers as many institutions now has a website
                               Web development has proven to have more employers as many institutions now has a website
                            </div>
                        </div>
                    </article>

                    <article id="singlepage-art1">
                        <div class="singlepage-art1_d1"><img src="img/ee288e2d3e24b4f51171b20b3bda7d87.jpg"  alt=""></div>
                        <div class="singlepage-art1_d2">
                            <ul id="singlepage-tech">
                                <li class="singlepage-seamt">Grace Martins</li>
                                <li id="singlepage-timer">2024-02-07 00:00:00</li>
                                <li class="singlepage-read"><button class="reply-button">Reply</button></li>
                                <li id="form-container" class="form-container" style="display:none;">
                                <form method="POST" class="formula" action="" id="formtag">
                                    <div id="westergot"><textarea name="content" placeholder="Your Reply:"></textarea></div>
                                    <div id="controlpan">
                                        <button type="submit">Post Reply</button>
                                        <input type="hidden" name="post_id" value="1">
                                        <input type="hidden" name="reply_to" value="2">
                                    </div>
                                </form>
                                </li>
                            </ul>
                            <div id="proxy">Web development has proven to have more employers as many institutions now has a website
                               Web development has proven to have more employers as many institutions now has a website
                            </div>
                        </div>
                    </article> -->
                </div>
            </article>
        </section>
        <section id="goater">
            <article class="goater-in">
            <div id="leavering">Leave a Comment</div>
                <form action="" method="post" enctype="multipart/form-data" id="vivo">
                    <!-- Hidden input for post ID -->
                    <?php
                        if (isset($_GET['postid'])) {
                            $postid = $_GET['postid'];
                            echo '<input type="hidden" name="postid" value="' . $postid . '">';
                        }
                    ?>

                    <ul id="dywane" >
                        <li class="mauwi">
                            <!-- Pre-fill username from session -->
                            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>" placeholder="Username:" required readonly>
                        </li>
                        <li class="mulan">
                            <!-- Pre-fill email from session -->
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Usermail:" required readonly>
                        </li>
                    </ul>

                    <div id="horsepower">
                        <!-- Textarea for comment -->
                        <textarea name="comments" id="keytan" cols="" rows="" placeholder="Your Comment:" required></textarea>
                    </div>

                    <div id="transcorp"><button type="submit" name="postcommentbtn">Post Comment</button></div>
                </form>
            </article>
        </section>
    </main>
<?php include 'footer.php' ?>