<?php
//Secure page check
session_start();

if (!isset($_SESSION['userName'])){
    header('Location: login.php');
    exit;
}

if ($_SESSION['isManager']){
    header('Location: managerDashboard.php');
    exit;
} else {
    header('Location: workerDashboard.php');
    exit;
}

?>

<!DOCTYPE html>
<html>

<body>
    DASHBOARD PAGE SUCCESSFUL LOGIN - Redirecting
    <a class="small-link" href="logout.php">Logout</a>
</body>
</html>