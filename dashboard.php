<?php
//Secure page check
session_start();

if (!isset($_SESSION['userName'])){
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html>

<body>
    DASHBOARD PAGE SUCCESSFUL LOGIN
    <a class="small-link" href="logout.php">Logout</a>
</body>
</html>