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
    <title>Manager Worker List</title>
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
                
            </div>
            <!-- The task table goes here -->
            <?php
                require 'dbDash.php';
                $SQLString = "SELECT u.userName, u.accessApproved, SUM(t.costEstimate) AS currentWorkload
                    FROM users u
                    LEFT JOIN assignments a ON u.userId = a.userId
                    LEFT JOIN tasks t ON a.taskId = t.taskId
                    GROUP BY u.userId, u.userName, u.accessApproved
                ";
                $result = $mysqli->query($SQLString);
                if ($result->num_rows > 0){
                    echo "
                    <table class='tasks-table'>
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Access Approved</th>
                                <th>Current Workload</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
                    while ($row = $result->fetch_assoc()){
                        //ternary for making a check mark or space instead of 0 or 1
                        $accessApprovedMark = $row["accessApproved"] == 1 ? '&#10003;' : '&nbsp;';
                        echo"
                            <tr>
                                <td>" . htmlspecialchars($row["userName"]) . "</td>
                                <td>" . $accessApprovedMark . "</td>
                                <td>" . htmlspecialchars($row["currentWorkload"]) . "</td>
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