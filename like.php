<?php
    ob_start();
    session_start();

    $conn = new mysqli('localhost', 'root', '', 'vloggydatabase');

    //Checks if database is connected. if it is true it will output 'connected'.
    //if ($conn) {
    //   echo "connected";
    // }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action']; // 'like' or 'unlike'
    $postid = $_POST['postid'];
    $username = $_SESSION['username']; // Use the current logged-in username from session

    // Check if session username is set, if not, handle the error
    if (!isset($username)) {
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }

    // Get the current likes column
    $like_query = "SELECT likes FROM vlogpost WHERE postid = ?";
    $stmt = $conn->prepare($like_query);
    $stmt->bind_param("i", $postid);
    $stmt->execute();
    $stmt->bind_result($likes);
    $stmt->fetch();
    $stmt->close();

    // Convert the likes column into an array
    $likes_array = $likes ? explode(",", $likes) : [];

    if ($action === 'like') {
        // Add the username to the likes array if not already liked
        if (!in_array($username, $likes_array)) {
            $likes_array[] = $username;
        }
    } else if ($action === 'unlike') {
        // Remove the username from the likes array
        $likes_array = array_diff($likes_array, [$username]);
    }

    // Convert the likes array back to a comma-separated string
    $likes_string = implode(",", $likes_array);

    // Update the likes column
    $update_query = "UPDATE vlogpost SET likes = ? WHERE postid = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $likes_string, $postid);
    $stmt->execute();
    $stmt->close();

    // Return the updated like count and user like status
    $like_count = count($likes_array);
    $user_liked = in_array($username, $likes_array);
    echo json_encode(['like_count' => $like_count, 'user_liked' => $user_liked]);
}
?>