<?php
ob_start();
session_start();

$conn = new mysqli('localhost', 'root', '', 'vloggydatabase');

    //Checks if database is connected. if it is true it will output 'connected'.
    //if ($conn) {
    //   echo "connected";
    // }

// Check if the request contains id and action
if (isset($_POST['id'], $_POST['action'])) {
    $comment_id = $_POST['id'];
    $action = $_POST['action'];
    $username = $_SESSION['username']; // Assuming the user is logged in

    // Retrieve the current like count (use different connection or close the statement)
    $stmt = $conn->prepare("SELECT likecount FROM allcomments WHERE id = ?");
    $stmt->bind_param('i', $comment_id);
    $stmt->execute();
    $stmt->bind_result($current_likecount);
    $stmt->fetch();
    $stmt->close();  // Close the SELECT statement before performing an UPDATE

    // Handle the like/unlike action
    if ($action === 'like') {
        // Increment the like count by 1
        $new_likecount = $current_likecount + 1;
    } elseif ($action === 'unlike') {
        // Decrement the like count by 1 (but make sure it doesn't go below 0)
        $new_likecount = max(0, $current_likecount - 1);
    }

    // Update the like count in the database
    $stmt = $conn->prepare("UPDATE allcomments SET likecount = ? WHERE id = ?");
    $stmt->bind_param('ii', $new_likecount, $comment_id);
    $stmt->execute();
    $stmt->close();

    // Send the response
    echo json_encode(['success' => true, 'new_likecount' => $new_likecount]);
} else {
    // Return an error if the request doesn't have the correct parameters
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
