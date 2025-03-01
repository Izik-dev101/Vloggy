<?php include 'header.php'  ?>
        <section id="index">
            <article id="index_inner">
                <article id="indonesia">
                    <h2>Dashboard</h2>
                    <a href="newvlog.php">Post A Vlog</a>
                </article>
                <div class="index_groo">
                    <article id="index-art1">
                        <a href="myvlog.php" class="index-mith">
                        <ul>
                            <li id="index-gret">My Vlogs</li>
                            <li id="index-meaw"><img src="img/home-heart.png" alt=""></li>
                        </ul>
                        </a>

                        <a href="newvlog.php" id="index-heat">
                        <ul>
                            <li id="index-oil">Post A Vlog</li>
                            <li class="index-port"><img src="img/shopping-bag-add.png" alt=""></li>
                        </ul>
                        </a>
                    </article>

                    <article id="index-art2">
                        <a href="profile.php" class="index-jas">
                        <ul>
                            <li class="index-pot">My Profile</li>
                            <li id="index-fert"><img src="img/user.png" alt=""></li>
                        </ul>
                        </a>

                        <ul id="index-root">
                            <li class="index-got">Total Vlogs <?php PostCount(); ?></li>
                            <li id="index-mast"><img src="img/heart.png" alt=""></li>
                        </ul>
                    </article>
                </div>
            </article>
        </section>
<?php include 'footer.php'  ?>