//window.alert('hi');

let successbox = document.querySelector('#signup-success_box');
let errorbox = document.querySelector('#signup-erro_box');
let might = document.querySelector('#might');
let fronter = document.querySelector('#fronter');

setTimeout(() => {
    successbox.style.display = 'none';
}, 8000);

setTimeout(() => {
    errorbox.style.display = 'none';
}, 8000);

might.addEventListener('click', function(){
    //alert('hi');
    fronter.classList.toggle('showDropDown');
})

// Controls the toggle menu burger button
let hamburgercontainer = document.querySelector('.burger');
let dropdownbox = document.querySelector('#dropdownbox');
let exiticon = document.querySelector('#exiticon');

hamburgercontainer.addEventListener('click', function(){
    //alert('hi');
    dropdownbox.style.display = 'flex';
})

exiticon.addEventListener('click', function(){
    dropdownbox.style.display = 'none';
})

    function showReplyForm(commentId) {
        var form = document.getElementById('form-container-' + commentId);
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }

    document.getElementById('like-button').addEventListener('click', function() {
        var postid = this.getAttribute('data-postid');
        var username = this.getAttribute('data-username');  // this should be dynamically set from session
        var action = this.textContent === 'Like' ? 'like' : 'unlike';
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'like.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                // Update the like count and button text
                var response = JSON.parse(xhr.responseText);
                document.getElementById('like-count').textContent = response.like_count + ' Likes';
                document.getElementById('like-button').textContent = response.user_liked ? 'Unlike' : 'Like';
            }
        };
        xhr.send('action=' + action + '&postid=' + postid + '&username=' + username);
    });
        
// Ensure the page has been fully loaded before running the script
document.addEventListener('DOMContentLoaded', function() {
    // Select the share button and share buttons container
    var shareBtn = document.getElementById("sharebtn");
    var socialShareButtons = document.querySelector(".social-share-buttons");

    // Add click event to toggle the share buttons
    shareBtn.addEventListener('click', function() {
        // Toggle the visibility of the share buttons (show/hide)
        if (socialShareButtons.style.display === "none" || socialShareButtons.style.display === "") {
            socialShareButtons.style.display = "block";
        } else {
            socialShareButtons.style.display = "none";
        }
    });

    // Handle social share link clicks
    document.querySelectorAll('.social-share-buttons a').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var postUrl = encodeURIComponent(window.location.href); // Get current page URL
            var postTitle = encodeURIComponent(document.title); // Get the title of the page
            var shareType = e.target.className.split('-')[0]; // Get the share type (whatsapp, facebook, etc.)

            // Get post ID and username from the share button
            var postId = shareBtn.getAttribute('data-postid');
            var username = shareBtn.getAttribute('data-username');

            // Update the share count (via AJAX)
            updateShareCount(postId, username, shareType);  // Update share count

            // Construct the share URLs for each social platform
            if (e.target.classList.contains('whatsapp-share')) {
                button.href = `https://wa.me/?text=${postTitle} ${postUrl}`;
            } else if (e.target.classList.contains('facebook-share')) {
                button.href = `https://www.facebook.com/sharer/sharer.php?u=${postUrl}`;
            } else if (e.target.classList.contains('twitter-share')) {
                button.href = `https://twitter.com/intent/tweet?text=${postTitle}&url=${postUrl}`;
            } else if (e.target.classList.contains('instagram-share')) {
                // For Instagram, we'll try to open the app on mobile or go to the web
                var instagramUrl = `https://www.instagram.com/share?url=${postUrl}`;
                // Attempt to open Instagram app on mobile (android or iOS)
                button.href = `instagram://share?url=${postUrl}`;
                
                // For some cases, if Instagram app is not available, open the web version
                setTimeout(function() {
                    window.open(instagramUrl, '_blank');
                }, 500);  // Delay before opening the web version (in case the app doesn't open)
            } else if (e.target.classList.contains('tiktok-share')) {
                // TikTok share URL (TikTok doesn't have a share app URL for posts, so we open the URL directly)
                button.href = `https://www.tiktok.com/@${postTitle}/video/${postUrl}`;
            }

            // Now navigate to the chosen share URL
            window.open(button.href, '_blank');
        });
    });
});

// Function to update the share count via AJAX
function updateShareCount(postId, username, shareType) {
    var shareCountElement = document.getElementById("share-count");
    var currentShareCount = parseInt(shareCountElement.innerText.split(' ')[0]); // Get current share count

    // Send AJAX request to update the share count
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "share.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    // Handle the response from the PHP script
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);

            if (response.success) {
                // Update the share count displayed on the page
                shareCountElement.innerText = response.newCount + " Shares";
            } else {
                console.error('Error updating share count');
            }
        }
    };

    // Send the current share count, postId, and username to the server
    var data = JSON.stringify({
        shareType: shareType,
        currentCount: currentShareCount,
        postId: postId,
        username: username
    });

    xhr.send(data);
}
     
    document.addEventListener('DOMContentLoaded', function () {
        console.log('JavaScript loaded'); // Check if the script is running
        
        const likeButtons = document.querySelectorAll('.like-btn');
        likeButtons.forEach(button => {
            button.addEventListener('click', function () {
                console.log('Button clicked'); // Check if the click event is triggered
                const commentId = this.getAttribute('data-id');
                const isLiked = this.classList.contains('liked');
    
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'commentlike.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText); // Log the response for debugging
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            if (isLiked) {
                                button.classList.remove('liked');
                                button.innerHTML = '<img src="img/heart.png" alt=""> ';
                            } else {
                                button.classList.add('liked');
                                button.innerHTML = '<img src="img/hearty.png" alt=""> ';
                            }
    
                            const likeCountSpan = document.getElementById('like-count-' + commentId);
                            likeCountSpan.textContent = response.new_likecount;
                        }
                    }
                };
                xhr.send('id=' + commentId + '&action=' + (isLiked ? 'unlike' : 'like'));
            });
        });
    });
        