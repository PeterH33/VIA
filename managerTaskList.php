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
    <title>Manager Task List</title>
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
            <div><h2>Tasks</h2></div>
            <div class="dash-header">
                <h3>Search bar</h3>
                <a class="dash-plusButton" href="addTask.php">+</a>
            </div>
            <!-- The task table goes here -->
            <?php
                require 'dbDash.php';
                $SQLString = "SELECT t.taskName, t.costEstimate, u.userName
                    FROM tasks t
                    LEFT JOIN assignments a ON t.taskId = a.taskId
                    LEFT JOIN users u ON a.userId = u.userId
                ";
                $result = $mysqli->query($SQLString);
                if ($result->num_rows > 0){
                    echo "
                    <table class='tasks-table'>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Time / Value</th>
                                <th>Assigned Worker</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
                    while ($row = $result->fetch_assoc()){
                        echo"
                            <tr>
                                <td>" . $row["taskName"] . "</td
                                <td>" . $row["costEstimate"] . "</td
                                <td>" . $row["userName"] . "</td
                                <td>...</td>
                            </tr>
                        ";
                    }
                } else {
                    echo "<h3>No tasks available, use the plus button to add a task.</h3>";
                }
                $mysqli->close();
            ?>
        </div>
    </div>

    <main>

    </main>
</body>
</html>