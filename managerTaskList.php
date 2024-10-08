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
                <input type="text" placeholder="Search Tasks" id="searchInput" class="taskList-searchBar">
                <button id="openModalBtn">Create Task</button>
            </div>
            <!-- The task table goes here -->
            <?php
                require 'dbDash.php';
                //NEW grab of the taskId this should work
                $SQLString = "SELECT t.taskId, t.taskName, t.costEstimate, u.userName
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
                                <th>Assigned / Volunteering Worker</th>
                                <th>Delete Task</th>
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
                                <td>
                                    <button class='btn btn-danger delete-task' data-task-id='" . htmlspecialchars($row["taskId"]) . "'>
                                    Delete
                                    </button>
                                </td>
                            </tr>
                        ";
                    }
                } else {
                    echo "<h3>No tasks available, use the plus button to add a task.</h3>";
                }
                $mysqli->close();
            ?>
            <br>
            <hr>
            <!-- This is where we will call our AI -->
            <a href="#" id="taskAssignAIBtn">Click for AI recomended task assignment</a>
            <div id="aiResponse"></div>
        </div>
    </div>


    <!-- Modal Sheet NEW CONTENT Might need to be up in the above div... not sure-->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <!-- This line is odd, need to understand it -->
            <span class="close">&times;</span>
            <form id="taskForm">
                <input type="text" name="taskName" placeholder="Task Name" maxlength="32" required>
                <input type="number" name="costEstimate" placeholder="Time Estimate, Priority, or Value">
                <input type="text" name="description" placeholder="Description of the task and what is considered done" maxlength="600">
                <input type="text" name="details" placeholder="Aditional Details" maxlength="500">
                <button type="submit">Save</button>
            </form>
            <div id="formResponse"></div>
        </div>
    </div>
    
    <!-- This script is new and I am unused to the syntax -->
    <script>
        // restrain function to only run when doc is loaded
        $(document).ready(function(){
            //declare vars off of the ids above the #name syntax is grabbing things off of the id
            var modal = $('#myModal');
            var btn = $('#openModalBtn');
            var span = $('.close');

            //make the openModalBtn show myModal
            btn.click(function() {
                //jquery show
                modal.show();
            });

            //Make clicking on the x id=close close the modal
            span.click(function() {
                //jquery hide
                modal.hide();
            });

            //Make clicking outside the modal close it clicking in the window
            $(window).click(function(event) {
                if ($(event.target).is(modal)) {
                    modal.hide();
                }
            });

            //AJAX call using jquery
            //Create a submit handler for the id taskForm
            $('#taskForm').submit(function(event) {
                //turn off the normal form behavior to make it ajax instead
                event.preventDefault();
                //jquery AJAX call setting teh data
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

        //Showing different ways to reference something for a button function effect, this one through class
        //Button for calling delete a task, how do people organize all this in a dev setting?
        $(document).ready(function(){
            $('.delete-task').click(function(){
                var taskId = $(this).data('task-id');
                //lets see if this will work to just pop up a confirmation box
                var confirmed = confirm('Are you sure you want to delete this task?');
                if (confirmed) {
                    $.ajax({
                        url: 'deleteTask.php',  // The PHP script to handle deletion
                        type: 'POST',
                        data: { taskId: taskId },
                        success: function(response) {
                            alert(response);  // Optional: Show success message
                            location.reload();  // Reload the page after deletion
                        },
                        error: function() {
                            alert('Error deleting task.');
                        }
                    });
                }
            });
        });

        //This one through an a href link that has an ID attached. Id is probably the better way so that you dont wind up messing with the css in the classes
        $(document).ready(function(){
            $('#taskAssignAIBtn').click(function(event){
                event.preventDefault();

                //disable button while loading
                $('#taskAssignAIBtn').prop('disabled', true).css('pointer-events', 'none');

                //spawn loading anim
                $('#aiResponse').html('<div class="loader"></div>');

                $.ajax({
                    url: 'taskAssignAI.php',
                    type:'GET',
                    success: function(response){
                        $('#aiResponse').html(response);
                        $('#taskAssignAIBtn').prop('disabled', false).css('pointer-events', 'auto');
                    },
                    error: function(){
                        $('#aiResponse').html('Error loading AI recommendation.');
                        $('#taskAssignAIBtn').prop('disabled', false).css('pointer-events', 'auto');
                    }
                });
            });
        });

        //JS for the serch filter This is super responsive! Gotta note down this logic, gpt suggestion
        $(document).ready(function(){
            $('#searchInput').on('keyup', function(){
                var target = $(this).val().toLowerCase();

                $('.tasks-table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(target) > -1);
                });
            });
        });

    </script>

</body>
</html>