<?php
    ob_start();
    session_start();

    $conn = new mysqli('localhost', 'root', '', 'vloggydatabase');

    //Checks if database is connected. if it is true it will output 'connected'.
     //if ($conn) {
      //   echo "connected";
    // }

    function RegisterUser(){
        global $conn;

        if(isset($_POST['registerbtn'])){
            $username = htmlspecialchars($_POST['username']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $lastname = htmlspecialchars($_POST['lastname']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $confirmpassword = htmlspecialchars($_POST['confirm-password']);

            //Checking if email already exist
            $checkemail = "SELECT * FROM registration WHERE `email` = '$email'";
            $Emailresult = $conn->query($checkemail);

            //Checking if Username already exist
            $checkusername = "SELECT * FROM registration WHERE `username` = '$username'";
            $Usernameresult = $conn->query($checkusername);

            if($password !== $confirmpassword){

                echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Password does not match</div>';

            }elseif(strlen($password) < 5){
                
                echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Password must be 5 or above 5 characters</div>';

            }elseif(mysqli_num_rows($Usernameresult) > 0){

                echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Username already exist</div>';

            }elseif(mysqli_num_rows($Emailresult) > 0){

                echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Email already exist</div>';

            }else{
                //Insert into - inserts new data into a registration table.

                $sql = "INSERT INTO registration
                (`username`, `firstname`, `lastname`, `email`, `password`, `confirmpassword`, `user_role`)
                VALUES ('$username', '$firstname', '$lastname', '$email', '$password', '$confirmpassword', 'subscriber')";

                $result = $conn->query($sql);

                if($result == true){

                    echo '<div id="signup-success_box" class="animate__animated animate__backInLeft">Registration Successful</div>';

                }else{

                    echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Registration Failed</div>';
                    die('Query Failed' . mysqli_error($conn));
                }
            }
        }
    }

    function Login(){
        global $conn;

        if(isset($_POST['loginbtn'])){

            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            
            $sql = "SELECT * FROM registration WHERE `email` = '$email'
            AND `password` = '$password' ";

            $result = $conn->query($sql);

            if(mysqli_num_rows($result) === 1){

                foreach($result as $row){
                    $username = $row['username'];
                }

                $_SESSION['username'] = $username;

                header('Location: ./dashboard/index.php');
            }else{
                echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Email or Password not correct</div>';
            }
        }
    }

    function PostComments(){
        global $conn;
    
        // Initialize variables to avoid undefined variable warnings
        $username = "";
        $email = "";
        $imagePath = "";

        // Check if the user is logged in
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            // Query the user details from the registration table
            $query = "SELECT username, email, profileimage FROM registration WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $username); // Use 's' for string type (username is a string)
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $username = $user['username'];
                $email = $user['email'];
                $imagePath = $user['profileimage']; // Fetch the user's profile image
            } else {
                // Handle case where user doesn't exist (e.g., redirect to login)
                header("Location: login.php");
                exit();
            }
        } else {
            // Handle case where user is not logged in
            header("Location: login.php");
            exit();
        }

        // Handle form submission to post a comment
        if (isset($_POST['postcommentbtn'])) {
            // Retrieve form data
            $comment = $_POST['comments'];
            $postid = $_POST['postid'];
            
            // Insert the comment into the database
            $query = "INSERT INTO allcomments (postid, username, email, comments, profileimage) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("issss", $postid, $username, $email, $comment, $imagePath);

            if ($stmt->execute()) {
                echo '<div id="signup-success_box" class="animate__animated animate__backInLeft">Comment Posted Successfully!</div>';
            } else {
                echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Error Posting Comment.</div>';
            }
        }
    }

    function GetComments(){
        global $conn;
    
        if(isset($_GET['postid'])){
            $postid = $_GET['postid'];
    
            $stmt = $conn->prepare("SELECT * FROM allcomments WHERE postid = ? ORDER BY parent_id ASC, date ASC");
            $stmt->bind_param('s', $postid);
            $stmt->execute();
            $result = $stmt->get_result();

            $comments = [];
            while ($value = $result->fetch_assoc()) {
                $comments[] = $value;
            }
            if (empty($comments)) {
                echo '<div class="fetcher">No comments found.</div>';
            }
    
            // Group comments by parent_id
            $nested_comments = [];
            foreach ($comments as $comment) {
                $nested_comments[$comment['parent_id']][] = $comment;
            }
    
            // Display comments and replies recursively
        function display_comments($parent_id, $nested_comments, $level = 0) {
        global $conn;
        if (!isset($nested_comments[$parent_id])) return;
    
        foreach ($nested_comments[$parent_id] as $comment) {
            // Calculate additional margin for nested comments
            $additional_margin_left = $level > 0 ? $level * 20 : 0; // 20px for each level of nesting
    
            $profileimage = htmlspecialchars($comment['profileimage']);
            $username = htmlspecialchars($comment['username']);
            $id = htmlspecialchars($comment['id']);
            $date = htmlspecialchars($comment['date']);
            $comments = htmlspecialchars($comment['comments']);
            $postid = $comment['postid'];
    
            // If it's a reply (parent_id > 0), fetch the username of the person being replied to
            $reply_to_username = '';
            if ($comment['parent_id'] > 0) {
                $stmt = $conn->prepare("SELECT username FROM allcomments WHERE id = ?");
                $stmt->bind_param('i', $comment['parent_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $parent_comment = $result->fetch_assoc();
                if ($parent_comment) {
                    $reply_to_username = htmlspecialchars($parent_comment['username']);
                }
            }
    
            // Add a margin-left of 25% from CSS, plus additional margin for nested comments
            echo '<article id="singlepage-art1" style="margin-left: calc(15% + ' . $additional_margin_left . 'px);">
                    <div class="singlepage-art1_d1"><img src="dashboard/uploads/'.$profileimage.'" alt=""></div>
                    <div class="singlepage-art1_d2">
                        <ul id="singlepage-tech">
                            <li class="singlepage-seamt">@'.$username.'</li>
                            <li id="singlepage-timer">'.$date.'</li>
                            <li class="singlepage-read"><button class="reply-button" onclick="showReplyForm('.$id.')">Reply</button></li>
                            <li id="form-container-'.$id.'" class="form-container" style="display:none;">
                                <form method="POST" class="formula" action="singlepage.php" id="formtag-'.$id.'">
                                    <div id="westergot"><textarea name="content" placeholder="Your Reply:"></textarea></div>
                                    <div id="controlpan">
                                        <button type="submit" name="postreplybtn">Post Reply</button>
                                        <input type="hidden" name="postid" value="'.$postid.'">
                                        <input type="hidden" name="reply_to" value="'.$id.'">
                                    </div>
                                </form>
                            </li>
                        </ul>
                        <div id="proxy">" '.$comments.' "</div>';
    
            // Show "Reply to @username" if it's a reply
            if ($reply_to_username) {
                echo '<div id="fragamento">Reply to @'.$reply_to_username.'</div>';
            }else{
                echo '';
            }
    
            echo '<div id="glosim">
                    <div class="sharkazulu">
                        <button class="like-btn" data-id="'.$comment['id'].'">
                            <img src="img/heart.png" alt=""> 
                        </button>
                        <span class="likercount" id="like-count-'.$comment['id'].'">' . $comment['likecount'] . '</span>
                    </div>
                  </div>
                </div>
                </article>';
    
            // Recursively display replies with incremented margin for deeper nesting
            display_comments($comment['id'], $nested_comments, $level + 1);
        }
    }
            // Start by displaying top-level comments
            display_comments(0, $nested_comments);
        }
    }
    
    if (isset($_POST['postreplybtn'])) {
        global $conn;
        
        $content = $_POST['content'];
        $postid = $_POST['postid'];
        $reply_to = $_POST['reply_to'];
        
        // Get the user's profile image (same as when posting a comment)
        $username = $_SESSION['username'];
        $stmt = $conn->prepare("SELECT profileimage FROM registration WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $profileimage = $user['profileimage']; // Get the profile image
        
        // Escape special characters to prevent SQL injection
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
        
        // Insert the reply with profile image
        $stmt = $conn->prepare("INSERT INTO allcomments (postid, parent_id, username, comments, profileimage) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('iisss', $postid, $reply_to, $username, $content, $profileimage);
        $stmt->execute();
        
        // Redirect to the same page to reload comments and replies
        header("Location: singlepage.php?postid=$postid");
        exit();
    }
    
    function Addvlog(){
        global $conn;

        if(isset($_POST['submitvlogbtn'])){

            if(isset($_SESSION['username'])){
                $username = $_SESSION['username'];
            }

            if(!empty($_FILES['vlogimage']['name'])){

                $vlogtitle = htmlspecialchars($_POST['vlogtitle']);
                $vlogdescription = htmlspecialchars($_POST['vlogdescription']);
                $vlogcategory = htmlspecialchars($_POST['vlogcategory']);
                $brandname = htmlspecialchars($_POST['brandname']);
                $readtime = htmlspecialchars($_POST['readtime']);

                $file_name = $_FILES['vlogimage']['name'];
                $file_size = $_FILES['vlogimage']['size'];
                $file_tmp = $_FILES['vlogimage']['tmp_name'];
                $unique_string = uniqid();

                //Get file Extention
                $file_ext = explode('.', $file_name);
                $file_ext = strtolower(end($file_ext));

                //Validate file Extention
                $allowed_extentions = ['png', 'jpg', 'jpeg'];

                if(in_array($file_ext, $allowed_extentions)){
                    if($file_size <= 1000000){

                        $target_dir = './img/'.$unique_string.".".$file_ext;
                        $vlogimage_url = $unique_string.".".$file_ext;

                        move_uploaded_file($file_tmp, $target_dir);

                        $sql = "INSERT INTO vlogpost (`vlogtitle`, `vlogdescription`, `vlogcategory`, `readtime`, `vlogimage`,
                        `brandname`, `username`) VALUES ('$vlogtitle', '$vlogdescription', '$vlogcategory', '$readtime', '$vlogimage_url', '$brandname', '$username')";
                        $result = $conn->query($sql);

                        if($result){
                            echo '<div id="signup-success_box" class="animate__animated animate__backInLeft">Upload Successful</div>';

                        }else{
                            echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Upload Failed</div>';

                            die("Query failed" . mysqli_error($conn));
                        }
                    }else{
                        echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Image size 
                        should not be more than 1mb</div>';
                    }
                }else{
                    echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Upload Failed</div>';
                }
            }
        }
    }

    function PostCount(){
        global $conn;

        if(isset($_SESSION['username'])){

            $username = $_SESSION['username'];

            $QueryPostCount = "SELECT * FROM vlogpost WHERE `username` = '$username' order by postid";
            $resultcount = $conn->query($QueryPostCount);
            $allpostcount = $resultcount -> num_rows;
            echo $allpostcount;
        }
    }

    function GetAllPost(){
        global $conn;

        // Pagination settings
        $articlesPerPage = 4;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pageStartLimit = ($currentPage - 1) * $articlesPerPage;

        // Count total articles for pagination
        $sql = "SELECT COUNT(*) AS total FROM vlogpost";
        $result = $conn->query($sql);
        $totalRow = $result->fetch_assoc();
        $totalArticles = $totalRow['total'];
        $totalPages = ceil($totalArticles / $articlesPerPage);

        // Fetch articles
        $sql = "SELECT * FROM vlogpost order by postid desc limit  $pageStartLimit, $articlesPerPage";
        $result = $conn->query($sql);        

        if($result == true){
            foreach($result as $row){
                $postid = $row['postid'];
                $vlogtitle = $row['vlogtitle'];
                $vlogdescription = $row['vlogdescription'];
                $vlogcategory = $row['vlogcategory'];
                $vlogimage = $row['vlogimage'];
                $username = $row['username'];
                $brandname = $row['brandname'];
                $vlogdate = $row['vlogdate'];
                $vlogview = $row['vlog_view'];
                $readtime = $row['readtime'];

            // Get the comment count
            $query = "SELECT COUNT(*) AS comment_count FROM allcomments WHERE postid = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $postid);
            $stmt->execute();
            $stmt->bind_result($comment_count);
            $stmt->fetch();
            $stmt->close();
        
            // Get the likes column and count
            $like_query = "SELECT likes FROM vlogpost WHERE postid = ?";
            $stmt = $conn->prepare($like_query);
            $stmt->bind_param("i", $postid);
            $stmt->execute();
            $stmt->bind_result($likes);
            $stmt->fetch();
            $stmt->close();

            // Convert the likes column into an array of usernames
            $likes_array = $likes ? explode(",", $likes) : [];

            // Check if the current user has already liked this post
            $user_liked = in_array($username, $likes_array);
            $like_count = count($likes_array);            
        
            // Get the share count
            $share_query = "SELECT share_count FROM vlogpost WHERE postid = ?";
            $stmt = $conn->prepare($share_query);
            $stmt->bind_param("i", $postid);
            $stmt->execute();
            $stmt->bind_result($share_count);
            $stmt->fetch();
            $stmt->close();

                //Split the text into an array of words
                $vlogdescription = explode(' ', $vlogdescription);

                //Convert the array back to string again
                $vlogdescription = implode(' ', array_slice($vlogdescription, 0, 10));

              echo '<article id="index-art1">
                        <div class="index-art1_d1"><img src="dashboard/img/'.$vlogimage.'" alt=""></div>
                        <div class="index-art1_d2">
                            <ul id="index-tech">
                                <li class="index-seam">'.$vlogcategory.'</li>
                                <li class="index-time">'.$vlogview.' Views</li>
                                <li class="index-min">'.$readtime.' read</li>
                            </ul>
                            <h4>'.$vlogtitle.'</h4>
                            <p>'.$vlogdescription.'</p>
                            <ul id="index-marater">
                                <li class="moana"><a href="singlepage.php?postid='.$postid.'">Continue Reading</a></li>
                                <li class="jackie"><span>'.$comment_count.'</span><img src="img/comment.png" alt=""></li>
                                <li id="humper"><span>'.$like_count.'</span><img src="img/heart.png" alt=""></li>
                                <li id="plumper"><span>'.$share_count.'</span><img src="img/share.png" alt=""></li>
                            </ul>
                             <ul id="monumento">
                                <li class="piolo">Posted By: '.$brandname.'</li>
                                <li class="zukarberg">On The: '.$vlogdate.'</li>
                            </ul>
                        </div>
                    </article>';

            }
        }

        //Pagination links
        echo '<ul id="myindex_ul">';
        if ($currentPage > 1) {
            echo '<li id="prev"><a href="?page=' . ($currentPage - 1) . '"><< Prev</a></li>';
        }

        if(isset($_GET['page'])){
            $page = $_GET['page'];
            echo '<li class="one">'.$page.'</li>';
        }

        echo '<li id="two">of</li>';
        echo '<li class="ten">'.$totalPages.'</li>';

        if ($currentPage < $totalPages) {
            echo '<li id="next"><a href="?page=' . ($currentPage + 1) . '">Next >></a></li>';
        }
        echo '</ul>';
        
    }

    function GetCategoryPost(){
        global $conn;
    
        // Ensure CategoryTitle is set before using it
        $CategoryTitle = isset($_GET['cat']) ? $_GET['cat'] : null;
    
        if($CategoryTitle === null) {
            // Optionally, you can redirect the user to a default category or show an error if no category is selected.
            echo "Category not selected.";
            return;  // Stop further execution if no category is provided.
        }
    
        // Pagination settings
        $articlesPerPage = 4;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pageStartLimit = ($currentPage - 1) * $articlesPerPage;
    
        // Count total articles for pagination
        $sql = "SELECT COUNT(*) AS total FROM vlogpost WHERE `vlogcategory` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $CategoryTitle);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalRow = $result->fetch_assoc();
        $totalArticles = $totalRow['total'];
        $totalPages = ceil($totalArticles / $articlesPerPage);
        
        // Fetch the posts for the given category
        $sql = "SELECT * FROM vlogpost WHERE `vlogcategory` = ? ORDER BY postid DESC LIMIT ?, ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $CategoryTitle, $pageStartLimit, $articlesPerPage);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $postid = $row['postid'];
                $vlogtitle = $row['vlogtitle'];
                $vlogdescription = $row['vlogdescription'];
                $vlogcategory = $row['vlogcategory'];
                $vlogimage = $row['vlogimage'];
                $username = $row['username'];
                $brandname = $row['brandname'];
                $vlogdate = $row['vlogdate'];
                $vlogview = $row['vlog_view'];
                $readtime = $row['readtime'];
    
                // Get the comment count
                $query = "SELECT COUNT(*) AS comment_count FROM allcomments WHERE postid = ?";
                $stmt2 = $conn->prepare($query);
                $stmt2->bind_param("i", $postid);
                $stmt2->execute();
                $stmt2->bind_result($comment_count);
                $stmt2->fetch();
                $stmt2->close();
            
                // Get the likes column and count
                $like_query = "SELECT likes FROM vlogpost WHERE postid = ?";
                $stmt2 = $conn->prepare($like_query);
                $stmt2->bind_param("i", $postid);
                $stmt2->execute();
                $stmt2->bind_result($likes);
                $stmt2->fetch();
                $stmt2->close();
    
                // Convert the likes column into an array of usernames
                $likes_array = $likes ? explode(",", $likes) : [];
    
                // Check if the current user has already liked this post
                $user_liked = in_array($username, $likes_array);
                $like_count = count($likes_array);            
            
                // Get the share count
                $share_query = "SELECT share_count FROM vlogpost WHERE postid = ?";
                $stmt2 = $conn->prepare($share_query);
                $stmt2->bind_param("i", $postid);
                $stmt2->execute();
                $stmt2->bind_result($share_count);
                $stmt2->fetch();
                $stmt2->close();
    
                //Split the text into an array of words
                $vlogdescription = explode(' ', $vlogdescription);
    
                //Convert the array back to string again
                $vlogdescription = implode(' ', array_slice($vlogdescription, 0, 10));
    
                echo '<article id="index-art1">
                        <div class="index-art1_d1"><img src="dashboard/img/'.$vlogimage.'" alt=""></div>
                        <div class="index-art1_d2">
                            <ul id="index-tech">
                                <li class="index-seam">'.$vlogcategory.'</li>
                                <li class="index-time">'.$vlogview.' Views</li>
                                <li class="index-min">'.$readtime.' read</li>
                            </ul>
                            <h4>'.$vlogtitle.'</h4>
                            <p>'.$vlogdescription.'</p>
                            <ul id="index-marater">
                                <li class="moana"><a href="singlepage.php?postid='.$postid.'">Continue Reading</a></li>
                                <li class="jackie"><span>'.$comment_count.'</span><img src="img/comment.png" alt=""></li>
                                <li id="humper"><span>'.$like_count.'</span><img src="img/heart.png" alt=""></li>
                                <li id="plumper"><span>'.$share_count.'</span><img src="img/share.png" alt=""></li>
                            </ul>
                            <ul id="monumento">
                                <li class="piolo">Posted By: '.$brandname.'</li>
                                <li class="zukarberg">On The: '.$vlogdate.'</li>
                            </ul>
                        </div>
                    </article>';
            }
        }
    
        //Pagination links
        echo '<ul id="myindex_ul">';
        if ($currentPage > 1) {
            echo '<li id="prev"><a href="?cat=' . $CategoryTitle . '&page=' . ($currentPage - 1) . '"><< Prev</a></li>';
        }
    
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            echo '<li class="one">'.$page.'</li>';
        }
    
        echo '<li id="two">of</li>';
        echo '<li class="ten">'.$totalPages.'</li>';
    
        if ($currentPage < $totalPages) {
            echo '<li id="next"><a href="?cat=' . $CategoryTitle . '&page=' . ($currentPage + 1) . '">Next >></a></li>';
        }
        echo '</ul>';
    }

    function getSinglePost(){
        global $conn;
        
        if(isset($_GET['postid'])){
            $postid = $_GET['postid'];
            
            // Ensure you're using the correct logged-in username from session
            $username = $_SESSION['username']; // Use session for the logged-in user's username
        
            // Fetch post details
            $sql = "SELECT * FROM vlogpost WHERE `postid` = '$postid'";
        
            // Get the comment count
            $query = "SELECT COUNT(*) AS comment_count FROM allcomments WHERE postid = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $postid);
            $stmt->execute();
            $stmt->bind_result($comment_count);
            $stmt->fetch();
            $stmt->close();
        
            // Get the likes column and count
            $like_query = "SELECT likes FROM vlogpost WHERE postid = ?";
            $stmt = $conn->prepare($like_query);
            $stmt->bind_param("i", $postid);
            $stmt->execute();
            $stmt->bind_result($likes);
            $stmt->fetch();
            $stmt->close();
        
            // Get the share count
            $share_query = "SELECT share_count FROM vlogpost WHERE postid = ?";
            $stmt = $conn->prepare($share_query);
            $stmt->bind_param("i", $postid);
            $stmt->execute();
            $stmt->bind_result($share_count);
            $stmt->fetch();
            $stmt->close();
    
            // Convert the likes column into an array of usernames
            $likes_array = $likes ? explode(",", $likes) : [];
        
            // Check if the current user has already liked this post
            $user_liked = in_array($username, $likes_array);
            $like_count = count($likes_array);
        
            // Fetch post details
            $result = $conn->query($sql);
            if($result){
                foreach($result as $value){
                    $brandname = $value['brandname'];
                    $vlogtitle = $value['vlogtitle'];
                    $vlogdescription = $value['vlogdescription'];
                    $vlogcategory = $value['vlogcategory'];
                    $vlogimage = $value['vlogimage'];
                    $vlogdate = $value['vlogdate'];
                    $vlogview = $value['vlog_view'];
                    $readtime = $value['readtime'];
        
                    // Display the post with like button and share button
                    echo ' <ul class="singlepage-big">
                                <li class="singlepage-gro">'.$vlogcategory.'</li>
                                <li class="singlepage-date">'.$vlogview.' Views</li>
                                <li class="singlepage-time">'.$readtime.' read</li>
                            </ul>
                            <ul id="marserk">
                                <li class="pilolo">Posted By: '.$brandname.'</li>
                                <li class="zuko">On The: '.$vlogdate.'</li>
                            </ul>
                            <article id="singlepage-sell">
                                <h3>'.$vlogtitle.'</h3>
                            </article>
                            <ul id="index-maraton">
                                <li class="index-comments">'.$comment_count.' Comments</li>
                                <li class="index-likes">
                                <span id="like-count">'.$like_count.' Likes</span>
                                <button class="like-button" id="like-button" 
                                    data-postid="'.$postid.'" data-username="'.$username.'">
                                    '.($user_liked ? 'Unlike' : 'Like').'
                                </button>
                                </li>
                            <li class="index-share">
                                <span id="share-count">'.$share_count.' Shares</span> <!-- This is where the share count will be dynamically updated -->
                                <button id="sharebtn"data-postid="'.$postid.'" data-username="'.$username.'">Share</button>
                                <div class="social-share-buttons" style="display: none;">
                                    <a href="#" class="whatsapp-share" target="_blank">WhatsApp</a>
                                    <a href="#" class="instagram-share" target="_blank">Instagram</a>
                                    <a href="#" class="facebook-share" target="_blank">Facebook</a>
                                    <a href="#" class="twitter-share" target="_blank">Twitter</a>
                                    <a href="#" class="tiktok-share" target="_blank">TikTok</a>
                                </div>
                            </li>
                            </ul>
                            <div class="singlepage-hom"><img src="dashboard/img/'.$vlogimage.'" alt="" ></div>
                            <p>'.$vlogdescription.'</p>';
                }
            }
        }
    }
                

    function post_views(){
        global $conn;

        if(isset($_GET['postid'])){
            $postid = $_GET['postid'];
            $sql = "UPDATE vlogpost SET `vlog_view` = `vlog_view` + 1 where `postid` = '$postid'";
            $result = $conn->query($sql);
        }
    }

    function GetTrendingPost(){
        global $conn;

        $sql = "SELECT * FROM vlogpost order by vlog_view desc limit 6";
        $result = $conn->query($sql);

        $num = 1;

        if($result == true){
            foreach($result as $value){
                $postid = $value['postid'];
                $vlogtitle = $value['vlogtitle'];
                $vlogimage = $value['vlogimage'];
                $vlogdate = $value['vlogdate'];

                echo '  <article id="index-latest1">
                            <div class="index-num1">'.$num.'</div>
                            <div id="index-latest1_d1"><img src="dashboard/img/'.$vlogimage.'" alt=""></div>
                            <div class="index-latest1_d2">
                                <a href="singlepage.php?postid='.$postid.'"><h5>'.$vlogtitle.'</h5></a>
                                <p>'.$vlogdate.'</p>
                            </div>
                        </article>';

            $num++;
            }
        }
    }

    function GetLatestPost(){
        global $conn;

        //$sql = "SELECT * FROM vlogposts order by id desc limit $pageStartLimit, $per_page";
        $sql = "SELECT * FROM vlogpost order by postid desc limit 3";
        $result = $conn->query($sql);

        if($result == true){
            foreach($result as $row){
                $postid = $row['postid'];
                $vlogtitle = $row['vlogtitle'];
                $vlogimage = $row['vlogimage'];
                $username = $row['username'];
                $vlogdate = $row['vlogdate'];

                //Split the text into an array of words
                //$vlogdescription = explode(' ', $vlogdescription);

                //Convert the array back to string again
                //$vlogdescription = implode(' ', array_slice($vlogdescription, 0, 10));

                echo '<article class="build">
                            <div id="him"><img src="dashboard/img/'.$vlogimage.'"  alt=""></div>
                            <div class="with">
                            <a href="singlepage.php?postid='.$postid.'"><h5>'.$vlogtitle.'</h5></a>
                            <p>'.$vlogdate.'</p>
                            </div>
                      </article>';
            }
        }
    }

    function AllAdminVlogs(){
        global $conn;

        if(isset($_SESSION['username'])){

            $username = $_SESSION['username'];

            $sql2 = "SELECT * FROM registration WHERE `username` = '$username'";
            $result2 = $conn->query($sql2);

            foreach($result2 as $value){
                $user_role = $value['user_role'];
            }

            if($user_role == 'admin'){

                $sql = "SELECT * FROM vlogpost order by postid desc limit 20";
                $result = $conn->query($sql);

                if($result == true){
                    foreach($result as $row){
                        $postid = $row['postid'];
                        $vlogtitle = $row['vlogtitle'];
                        $vlogdescription = $row['vlogdescription'];
                        $vlogcategory = $row['vlogcategory'];
                        $vlogimage = $row['vlogimage'];
                        $vlogdate = $row['vlogdate'];
                        $vlogview = $row['vlog_view'];

                        //Split the text into an array of words
                        $vlogdescription = explode(' ', $vlogdescription);

                        //Convert the array back to string again
                        $vlogdescription = implode(' ', array_slice($vlogdescription, 0, 10));

                        echo '<article id="myvlog-art1">
                        <div id="art1_de1">
                            <div class="techs"><img src="img/'.$vlogimage.'" alt=""></div>
                            <div class="frost">
                                <h4>'.$vlogtitle.'</h4>
                                <p>'.$vlogdescription.'</p>
                            </div>
                        </div>
                        <div id="art1_de2">
                            <p>'.$vlogdate.'</p>
                        </div>
                        <div id="art1-de3">
                            <p>'.$vlogcategory.'</p>
                        </div>
                        <div id="art1-de4">
                            <p>'.$vlogview.'</p>
                        </div>
                        <div id="art1_de5">
                            <div class="editing"><a href="edit.php?postid='.$postid.'"><img src="img/edit.png" alt=""></a></div>
                            <div class="trash"><a href="delete.php?postid='.$postid.'"><img src="img/trash.png" alt=""></a></div>
                        </div>
                            </article>';

                    }
                }
            }else{

                $sql = "SELECT * FROM vlogpost WHERE `username` = '$username' order by postid desc limit 8";
                $result = $conn->query($sql);

                if($result == true){
                    foreach($result as $row){
                        $postid = $row['postid'];
                        $vlogtitle = $row['vlogtitle'];
                        $vlogdescription = $row['vlogdescription'];
                        $vlogcategory = $row['vlogcategory'];
                        $vlogimage = $row['vlogimage'];
                        $vlogdate = $row['vlogdate'];
                        $vlogview = $row['vlog_view'];

                        //Split the text into an array of words
                        $vlogdescription = explode(' ', $vlogdescription);

                        //Convert the array back to string again
                        $vlogdescription = implode(' ', array_slice($vlogdescription, 0, 10));

                        echo '<article id="myvlog-art1">
                        <div id="art1_de1">
                            <div class="techs"><img src="img/'.$vlogimage.'" alt=""></div>
                            <div class="frost">
                                <h4>'.$vlogtitle.'</h4>
                                <p>'.$vlogdescription.'</p>
                            </div>
                        </div>
                        <div id="art1_de2">
                            <p>'.$vlogdate.'</p>
                        </div>
                        <div id="art1-de3">
                            <p>'.$vlogcategory.'</p>
                        </div>
                        <div id="art1-de4">
                            <p>'.$vlogview.'</p>
                        </div>
                        <div id="art1_de5">
                            <div class="editing"><a href="edit.php?postid='.$postid.'"><img src="img/edit.png" alt=""></a></div>
                            <div class="trash"><a href="delete.php?postid='.$postid.'"><img src="img/trash.png" alt=""></a></div>
                        </div>
                            </article>';
                    }
                }
            }
        }
    }

    function getprofile(){
        global $conn;

        if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];

            $sql = "SELECT * FROM registration WHERE `username` = '$username'";
            $result = $conn->query($sql);

            if($result == true){
                foreach($result as $row){

                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $email = $row['email'];
                    ?>
                    <div id="profile-div1">
                        <h3>Profile Information</h3>
                        <?php CheckProfileImage(); ?>
                        <!-- <img src="img/profile.png" width="200px" alt=""> -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="file" name="updateimage"><br><br>

                            <label for="">First Name</label><br><br>
                            <input type="text" name="firstname" value="<?php echo $firstname; ?>"><br><br>

                            <label for="">Last Name</label><br><br>
                            <input type="text" name="lastname" value="<?php echo $lastname; ?>"><br><br>

                            <label for="">Email</label><br><br>
                            <input type="email" name="email" value="<?php echo $email; ?>"><br><br>

                            <button type="submit" name="updateprofile">Update Profile</button>
                        </form>
                    </div>

                    <?php
                }
            }
        }
    }

    function CheckProfileImage(){
        global $conn;

        if(isset($_SESSION['username'])){

            $username = $_SESSION['username'];

            $sql = "SELECT * FROM registration WHERE `username` ='$username'";

            $result = $conn->query($sql);

            if($result)

            foreach($result as $value){
                $profileimage = $value['profileimage'];

                if(empty($profileimage)){
                    echo '<img src="uploads/profile.png" width="240px" alt="">';

                }else{
                    echo '<img src="uploads/'.$profileimage.'" width="240px" alt="">';
                }
            }
        }
    }

    function CheckProfileImage2(){
        global $conn;

        if(isset($_SESSION['username'])){

            $username = $_SESSION['username'];

            $sql = "SELECT * FROM registration WHERE `username` ='$username'";

            $result = $conn->query($sql);

            if($result)

            foreach($result as $value){
                $profileimage = $value['profileimage'];

                if(empty($profileimage)){
                    echo '<li id="mecat">
                            <a href="profile.php"><img src="uploads/profile.png" width="30px" alt=""></a>
                          </li>';

                }else{
                    echo '<li id="mecat">
                            <a href="profile.php"><img src="uploads/'.$profileimage.'" width="30px" alt=""></a>
                          </li>';
                }
            }
        }
    }

    function CheckProfileImage_frontend(){
        global $conn;

        if(isset($_SESSION['username'])){

            $username = $_SESSION['username'];

            $sql = "SELECT * FROM registration WHERE `username` ='$username'";

            $result = $conn->query($sql);

            if($result)

            foreach($result as $value){
                $profileimage = $value['profileimage'];

                if(empty($profileimage)){
                    echo '<li class="gut">
                             <a href="dashboard/index.php"><img src="dashboard/uploads/profile.png" width="30px" alt=""></a>
                         </li>';
                }else{
                    echo '<li class="gut">
                            <a href="dashboard/index.php"><img src="dashboard/uploads/'.$profileimage.'" width="30px" alt=""></a>
                         </li>';
                }
            }
        }
    }

    function UpdateProfile(){
        global $conn;

        if(isset($_POST['updateprofile']) && isset($_SESSION['username'])){

            $username = $_SESSION['username'];

            if(!empty($_FILES['updateimage']['name'])){

                $firstname = htmlspecialchars($_POST['firstname']);
                $lastname = htmlspecialchars($_POST['lastname']);
                $email = htmlspecialchars($_POST['email']);

                $file_name = $_FILES['updateimage']['name'];
                $file_size = $_FILES['updateimage']['size'];
                $file_tmp = $_FILES['updateimage']['tmp_name'];
                $unique_string = uniqid();

                //get file extension
                $file_ext = explode('.', $file_name);
                $file_ext = strtolower(end($file_ext));

                $target_dir = './uploads/'.$unique_string.".".$file_ext;
                $profileimage_url = $unique_string.".".$file_ext;

                //echo $file_ext;

                //validate file extension
                $allowed_extensions = ['png', 'jpg', 'jpeg'];

                if(in_array($file_ext, $allowed_extensions)){
                    if($file_size <= 1000000){

                        move_uploaded_file($file_tmp, $target_dir);

                        $sql = "UPDATE registration SET `firstname` = '$firstname', `lastname` = '$lastname',
                        `profileimage` = '$profileimage_url', `email` = '$email' WHERE `username` = '$username'";
                        $result = $conn->query($sql);
                        if($result){

                            header('Location: profile.php');
                        }else{
                            echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Cannot Update Profile</div>';
                        }
                    }
                }else{
                    echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">File Type not accepted</div>'; 
                }

            }else{

                $firstname = htmlspecialchars($_POST['firstname']);
                $lastname = htmlspecialchars($_POST['lastname']);
                $email = htmlspecialchars($_POST['email']);

                $sql = "UPDATE registration SET `firstname` = '$firstname', `lastname` = '$lastname', 
                `email` = '$email' WHERE `username` = '$username' ";
                $result = $conn->query($sql);

                if($result){

                    header('Location: profile.php');
                }else{
                    echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Cannot Update Profile</div>';
                }
            }
        }
    }

    function ChangePassword(){
        global $conn;

        if(isset($_POST['changepassword']) && isset($_SESSION['username'])){

            $username = $_SESSION['username'];

            $oldpassword = htmlspecialchars($_POST['oldpassword']);
            $newpassword = htmlspecialchars($_POST['newpassword']);
            $conpassword = htmlspecialchars($_POST['conpassword']);

            if($newpassword === $conpassword){

                $sql = "SELECT * FROM registration WHERE `password` = '$oldpassword' AND `username` = '$username'";
                $result = $conn->query($sql);

                if(mysqli_num_rows($result) == 1){

                    foreach($result as $row){
                        $id = $row['id'];

                        $sql2 = "UPDATE registration SET `password` = '$newpassword', `confirmpassword` = '$newpassword' 
                        WHERE `id` = '$id'";
                        $result2 = $conn->query($sql2);

                        if($result2){
                            echo '<div id="signup-success_box" class="animate__animated animate__backInLeft">Password Update Sucessful</div>';
                        }
                    }
                }else{
                    echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">Old password is incorrect</div>';
                }

            }else{
                echo '<div id="signup-erro_box" class="animate__animated animate__backInLeft">New Password does not match Confirm New Password</div>';
            }
        }
    }
?>