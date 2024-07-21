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
    <!-- NEW CONTENT JQuery from google -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
                <!-- NEW CONTENT logic for button and modal sheet -->
                <!-- <a class="dash-plusButton" href="addTask.php">+</a> -->
                <!-- Test button -->
                <button id="openModalBtn">Create Task</button>
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
                                <th>Edit Task</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
                    while ($row = $result->fetch_assoc()){
                        echo"
                            <tr>
                                <td>" . htmlspecialchars($row["taskName"]) . "</td>
                                <td>" . htmlspecialchars($row["costEstimate"]) . "</td>
                                <td>" . htmlspecialchars($row["userName"]) . "</td>
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

    <!-- Test button -->
    <button id="openModalBtn">Create Task</button>

    <!-- Modal Sheet NEW CONTENT Might need to be up in the above div... not sure-->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <!-- This line is odd, need to understand it -->
            <span class="close">&times;</span>
            <form id="taskForm">
                <input type="text" name="taskName" placeholder="Task Name" maxlength="32" required>
                <input type="number" name="costEstimate" placeholder="Time Estimate, Priority, or Value" required>
                <input type="text" name="description" placeholder="Description of the task and what is considered done" maxlength="600" required>
                <input type="text" name="details" placeholder="Aditional Details" maxlength="500" required>
                <button type="submit">Save</button>
            </form>
            <div id="formResponse"></div>
        </div>
    </div>
    
    <!-- This script is new and I am unused to the syntax -->
    <script>
        $(document).ready(function(){
            var modal = $('#myModal');
            var btn = $('#openModalBtn');
            var span = $('.close');

            btn.click(function() {
                modal.show();
            });

            span.click(function() {
                modal.hide();
            });

            $(window).click(function(event) {
                if ($(event.target).is(modal)) {
                    modal.hide();
                }
            });

            $('#taskForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'addTask.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#formResponse').html(response);
                        $('#taskForm')[0].reset();
                        setTimeout(function() {
                            modal.hide();
                            location.reload();
                        }, 2000);
                    },
                    error: function() {
                        $('#formResponse').html('Error creating task.');
                    }
                });
            });
        });
    </script>

</body>
</html>