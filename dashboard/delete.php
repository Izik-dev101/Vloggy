<?php include "function.php";

if(isset($_GET['postid'])){
    global $conn;

    $deleteId = $_GET['postid'];

    $sql = "DELETE FROM vlogpost WHERE `postid` = '$deleteId'";

    $result = $conn->query($sql);

    if($result){
        header('Location: myvlog.php');
    }
}
 ?>