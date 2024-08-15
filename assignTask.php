<?php
session_start();
require 'dbDash.php';

if (!isset($_SESSION['userName'])){
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['userName'];
// does task id need a null check?
$taskId = $_POST['taskId'];

//can kind of handle null check here as an if
if($taskId){
    $userQuery = "SELECT userId FROM users WHERE userName = ?";
    $stmt = $mysqli->prepare($userQuery);
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->bind_result($userId); //create the userID variable and point at it
    $stmt->fetch(); //actually assign value to userID, I am unsure of the validity of this
    $stmt->close();

    //kind of a null check again for userId
    if($userId){
        $insertQuery = "INSERT INTO assignments (userId, taskId) VALUES (?, ?)";
        $stmt = $mysqli->prepare($insertQuery);
        $stmt->bind_param("ii", $userId, $taskId);
        // $stmt->execute();
        //I am going to put in what amounts to a print statement error check
        if ($stmt->execute()){
            echo "assignment voulenteer successful";
        } else {
            echo "assignment failure";
        }
        $stmt->close();
    } else {
        echo "userId not found";
    }
} else {
    echo "taskId not found";
}

//the mysqli container is from dbDash
$mysqli->close();

?>