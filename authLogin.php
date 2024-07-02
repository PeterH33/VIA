<!-- We have 3 states here, fail, approval needed, and success -->
<?php
session_start();
    require 'dbConn.php';

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $userName = sanitizeString($_POST['userName']);
        $password = sanitizeString($_POST['password']);

        //fetch data on user
        $stmt = $mysqli->prepare('SELECT userName, password, isManager, accessApproved FROM users WHERE username = ?');
        $stmt->bind_param('s', $userName);
        $stmt->execute();
        $stmt->store_result();

        //Check user exists
        if ($stmt->num_rows > 0){
            $stmt->bind_result($userName, $hashedPW, $isManager, $accessApproved);
            $stmt->fetch();
            
            //check if user has accessApproved
            if (!$accessApproved){
                $stmt->close();
                $mysqli->close();
                header('Location: approvalRequired.html');
                exit;
            }
            //Check the pw if they exist and are approved
            if (password_verify($password, $hashedPW)){
                $_SESSION['userName'] = $userName;
                //I am not certain about the manager tag being handled by the session, maybe?
                $_SESSION['isManager'] = $isManager;
                $stmt->close();
                $mysqli->close();
                //goto the proper dashboard
                header('Location: dashboard.php');
                exit;
            } else {
                //password incorrect
                $stmt->close();
                $mysqli->close();
                header('Location: authFailure.html');
                exit;
            }
        } else {
            //user not listed
            $stmt->close();
            $mysqli->close();
            header('Location: authFailure.html');
            exit;
        }
        $stmt->close();
    }
    
    $mysqli->close();
?>