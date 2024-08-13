<?php
//Secure page check for login and permission
//I believe that the same logic as for the manager can be applied, the worker is baseically our default state
session_start();

if (!isset($_SESSION['userName'])){
    header('Location: login.php');
    exit;
}

//I feel like I need some logic to flag this as a user and check for user... but perhaps not?
if ($_SESSION['isManager']){
    header('Location: managerDashboard.php');
    exit;
}

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
        <header class="dash-header">
            <div class="site-logo">logo</div>
            <a class="small-link" href="logout.php">Log Out</a>
        </header>

        <div class="container">
            <div class="row">
                <div class="col">
                    Task Image goes here
                </div>
                <div class="col">
                    Details of the Task goes here
                </div>
            </div>
        </div>

        <h3>Available Tasks</h3>

        <!-- Carousel goes here -->
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item">
                    <img src="IMAGES/q1.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="IMAGES/q2.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="IMAGES/q3.png" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- I need to fetch all of the current tasks and put them up as cards -->


        <?php include 'footer.php';?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    </body>
</html>