<!-- Check for user permissions -->
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

require_once 'sani.php';
//  Need to check if a post was sent, it will be sent by this page
// If post sent, use it to insert a db item for the task
if($_SERVER['REQUEST_METHOD'] ==='POST'){
    require 'dbDash.php';

    $taskName = sanitizeString($_POST['taskName']) ;
    $costEstimate = sanitizeString($_POST['costEstimate']) ;
    $description = sanitizeString($_POST['description']) ;
    $details = sanitizeString($_POST['details']) ; 
    //TODO: The image path needs to be setup somehow, not sure about how to do that atm
    $SQLString = $mysqli->prepare("INSERT INTO tasks (taskName, costEstimate, description, details) VALUES (?, ?, ?, ?)");
    $SQLString->bind_param("siss", $taskName, $costEstimate, $description, $details);
    $SQLString->execute();
    $SQLString->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Create Task</title>
    <link rel="stylesheet" href="CSS/mainStyle.css">
</head>
<body>
    <header class="dash-header">
        
        <!-- logo on the left -->
        <div class="site-logo">logo</div>
        
        <!-- Manager icon portrait on right next to logout button-->

        <!-- Logout button on the right -->
        <a class="small-link" href="logout.php">Log Out</a>

    </header>    

    <div class="dash-container">
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

        <div class="dash-mainContent">
            <!-- Search bar kind of a header and add task button -->
            <div><h2>Create Task</h2></div>
            
            <!-- The task table goes here -->
            <form class="task-form" action="addTask.php" method="post">
                <input type="text" name="taskName" placeholder="Task Name" required>
                <input type="text" name="costEstimate" placeholder="Time Estimate, Priority, or Value" required>
                <input type="text" name="description" placeholder="Description of the task and what is considered done" required>
                <input type="text" name="details" placeholder="Aditional Details" required>
                <input class="small-link" type="submit" value="Save">
            </form>
        </div>
    </div>

    <main>

    </main>
</body>
</html>

<!-- Clean all user input before it is even sent to post?-->

