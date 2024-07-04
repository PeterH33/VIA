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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard</title>
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

    <!-- Menu -->
    <div class="dash-container">
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
            <!-- Next round button and time remaining -->
            <div class="dash-header">
                <a class="small-link" href="">Next VIA Round</a>
                <div>Time remaining in round: time</div>
            </div>
            <!-- loadup remaining Tasks -->
            <div>
                <h2>Remaining Tasks</h2>
                <!-- Table code here -->
                <?php
                //establish connection
                require 'dbDash.php';
                //sql for getting remaining tasks
                $SQLString = "SELECT taskName, costEstimate FROM Tasks WHERE taskIsAssigned = 0";
                $result = $mysqli->query($SQLString);
                if ($result->num_rows > 0){
                    echo "
                    <table class='tasks-table'>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Time / Value</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
                    while ($row = $result->fetch_assoc()){
                        echo "
                            <tr>
                                <td>" . $row["taskName"] . "</td>
                                <td>" . $row["costEstimate"] . "</td>
                                <td>...</td>
                            </tr>
                        ";
                    }
                    echo "
                        </tbody>
                    </table>
                    ";
                } else {
                    echo "<h3>No unassigned tasks</h3>";
                }
                $mysqli->close();
                ?>
            </div>
            <!-- Loadup current bids -->
            <div>
                <h2>Current Bids</h2>
                <?php
                //establish connection
                require 'dbDash.php';
                //sql for getting remaining tasks
                $SQLString = "SELECT u.userName, t.taskName, a.bid 
                    FROM assignments a 
                    JOIN users u ON a.userId = u.userIdWHERE 
                    JOIN tasks t ON a.taskId = t.taskId
                    WHERE a.bid IS NOT NULL";
                $result = $mysqli->query($SQLString);
                if ($result->num_rows > 0){
                    echo "
                    <table class='tasks-table'>
                        <thead>
                            <tr>
                                <th>Task Title</th>
                                <th>Bid</th>
                                <th>Worker</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
                    while ($row = $result->fetch_assoc()){
                        echo "
                            <tr>
                                <td>" . $row["taskName"] . "</td>
                                <td>" . $row["bid"] . "</td>
                                <td>" . $row["userName"] . "</td>
                                <td>...</td>
                            </tr>
                        ";
                    }
                    echo "
                        </tbody>
                    </table>
                    ";
                } else {
                    echo "<h3>No current bids</h3>";
                }
                $mysqli->close();
                ?>
            </div>

        </div>
    </div>
</body>
</html>