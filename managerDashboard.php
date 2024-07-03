<?php
//Secure page check for login and permission
session_start();

if (!isset($_SESSION['userName'])){
    header('Location: login.php');
    exit;
}

if (!$_SESSION['isManager']){
    header('Location: workerDashboard.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="CSS/mainStyle.css">
</head>
<body>
    <header>
        
        <!-- logo on the left -->
        <div class="site-logo">logo</div>
        
        <!-- Manager icon portrait on right next to logout button-->

        <!-- Logout button on the right -->
        <a class="small-link" href="logout.php">Log Out</a>

    </header>    

    <!-- Menu -->
    <div class="dash-menuContainer">
        <nav class="dash-sidebar">
            <ul class="dash-menu">
                <li><a href="managerDashboard.php"><img src="ICONS/home.svg" alt="Home Icon" class="dash-icon">VIA Round</a></li>
                <li><a href="managerTaskList.php"><img src="ICONS/plus.svg" alt="Task Icon" class="dash-icon"> Task List</a></li>
                <li><a href="managerWorkers.php"><img src="ICONS/person.svg" alt="Worker Icon" class="dash-icon">Workers</a></li>
                <li><a href="managerSettings.php"><img src="ICONS/gear.svg" alt="Settings Icon" class="dash-icon">Settings</a></li>
            </ul>
        </nav>
    </div>

    <main>

    </main>
</body>
</html>