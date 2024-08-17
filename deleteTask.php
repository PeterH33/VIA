<?php
if (isset($_POST['taskId'])) {
    require 'dbDash.php';
    $taskId = $_POST['taskId'];
    
    //Having this call second caused issues, lets see if it works if it goes first?
    //Neat! totally works, so you need to delete aoociative tables first and then delete primary tables
    $SQLString = "DELETE FROM assignments WHERE taskId = ?";
    $stmt = $mysqli->prepare($SQLString);
    $stmt->bind_param('i', $taskId);
    
    if ($stmt->execute()) {
        echo "Task deleted successfully from assignments. ";
    } else {
        echo "Error deleting task from assignments. ";
    }
    
    $stmt->close();

    // Prepare and execute the SQL statement to delete the task
    $SQLString = "DELETE FROM tasks WHERE taskId = ?";
    $stmt = $mysqli->prepare($SQLString);
    $stmt->bind_param('i', $taskId);
    
    if ($stmt->execute()) {
        echo "Task deleted successfully from task list.";
    } else {
        echo "Error deleting task from tasks. ";
    }
    
    $stmt->close();


    $mysqli->close();
} else {
    echo "Task ID not provided. ";
}
?>