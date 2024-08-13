<?php
//Secure page check for login and permission
//I believe that the same logic as for the manager can be applied, the worker is baseically our default state
session_start();

if (!isset($_SESSION['userName'])){
    header('Location: login.php');
    exit;
}

//I feel like I need some logic to flag this as a user and check for user... but perhaps not?

require_once 'sani.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Worker Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="CSS/mainStyle.css">
    </head>

    <body>
        Worker Dashboard
        <a class="small-link" href="logout.php">Logout</a>

        <?php include 'footer.php';?>
    </body>
</html>