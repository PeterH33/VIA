<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    require 'dbConn.php';
        //TODO: Add logic to check for the managers name
        $managerName = sanitizeString($_POST['muName']);
        $userName = sanitizeString($_POST['userName']);
        $password = sanitizeString($_POST['password']);
        $pwHash = password_hash($password, PASSWORD_DEFAULT);

        $sqlStatement = $mysqli->prepare("INSERT INTO Users(userName, password) VALUES (?,?)");
        $sqlStatement->bind_param('ss', $userName, $pwHash);
        $sqlStatement->execute();
        $sqlStatement->close();
    
    $mysqli->close();

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>VIA - Account Created</title>
    <link rel="stylesheet" href="CSS/mainStyle.css">
</head>
<body>
    <header>
        <!-- site logo on the left -->
        <div class="site-logo">logo</div>
    </header>

    <main class="login-main">
        <div class="login-container">
            <!-- Vertical stack of Login and sub heading -->
            <h2>Thank you for creating your account</h2>
            <h3>Please contact your manager to gain access to your account.</h3>
            <!-- Form with two fields -->
            <a class="small-link wide-link" href="index.html">Back to VIA</a>
            
        </div>




    </main>

</body>

</html>