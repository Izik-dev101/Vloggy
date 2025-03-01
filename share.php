<?php
    ob_start();
    session_start();

    $conn = new mysqli('localhost', 'root', '', 'vloggydatabase');
    
    //Checks if database is connected. if it is true it will output 'connected'.
    //if ($conn) {
    //   echo "connected";
    // }

    // Get the POST data
    $data = json_decode(file_get_contents("php://input"));

// Check if the data is available
if ($data) {
    $postId = $data->postId;  // Get the post ID from the AJAX request
    $username = $data->username;  // Get the username from the AJAX request
    $currentCount = $data->currentCount;  // Current share count passed from the frontend
    $shareType = $data->shareType;  // Share type (e.g. whatsapp, facebook, etc.)

    // Increment share count
    $newCount = $currentCount + 1;

    // Debugging log
    error_log("Received Post ID: " . $postId);
    error_log("Received Username: " . $username);
    error_log("Current Share Count: " . $currentCount);
    error_log("Share Type: " . $shareType);
    error_log("New Share Count: " . $newCount);

    // Assuming you have a "vlog_posts" table with a "share_count" column and a unique "id" column
    $sql = "UPDATE vlogpost SET share_count = ? WHERE postid = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $newCount, $postId);  // Bind the new share count and post ID

        // Execute the query
        if ($stmt->execute()) {
            // Return the new share count on success
            echo json_encode([
                "success" => true,
                "newCount" => $newCount
            ]);
        } else {
            // Return failure response if query execution fails
            echo json_encode(["success" => false, "message" => "Error updating share count"]);
        }

        $stmt->close();
    } else {
        // Return failure response if the statement preparation fails
        echo json_encode(["success" => false, "message" => "Error preparing SQL statement"]);
    }

    $conn->close();
} else {
    // Return failure response if no data is received
    echo json_encode(["success" => false, "message" => "No data received"]);
}

?>
    
    