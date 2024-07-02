<?php
function sanitizeString($var)
{
    // if (get_magic_quotes_gpc())
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    

    // $DBConnect = mysqli_connect("127.0.0.1", "viaDemon", "pword", "viaDB");

    // //if there is no db connection, let the admin know
    // if ($DBConnect == false)
    // {
    //     print"Unable to conect to database: ". mysqli_errno();
    // } else {
    //     //setup table name
    //     $tableName = "users";
    //     //setup the php variable to hold the data from the form
    //     $firstName = sanitizeString($_POST['firstName']) ;
    //     $lastName = sanitizeString ($_POST['lastName']) ;
    //     $address = sanitizeString ($_POST['address']) ;
    //     $city = sanitizeString ($_POST['city']) ;
    //     $state = sanitizeString ($_POST['state']) ;
    //     $zipCode = sanitizeString ($_POST['zipCode']) ;
    //     $colors = sanitizeString ($_POST['colors']) ;
    //     $favNumber = sanitizeString ($_POST['favNumber']) ;
    //     $day = sanitizeString ($_POST['day']) ;
        

    //     //construct our SQL string to insert the data in the database and table
    //     // $SQLString = "insert into $tableName(artist, cd, song) values ('$artist', '$cd', '$song')";
    //     $SQLString = "CALL insertPerson('$firstName', '$lastName', '$address', '$city', '$state', '$zipCode', '$colors', '$favNumber', '$day')";
    //     //this is the code to insert the values and report if it doesn't happen
    //     if(mysqli_query($DBConnect, $SQLString))
    //         $confirmation = "Record created";
    //     else
    //         $confirmation = "There was an error on insert: Record not created";

    // }
    // mysqli_close($DBConnect);
    $mysqli = new mysqli("127.0.0.1", "viaDemon", "pword", "viaDB");

    if ($mysqli->connect_error){
        die("Connection failed: " . $mysqli->connect_error);
    } else {
        //TODO: Add logic to check for the managers name
        $managerName = sanitizeString($_POST['muName']);
        $userName = sanitizeString($_POST['userName']);
        $password = sanitizeString($_POST['password']);
        $pwHash = password_hash($password, PASSWORD_DEFAULT);

        $sqlStatement = $mysql->prepare("INSERT INTO Users(userName, password) VALUES (?,?)");
        $sqlStatement->bind_param('ss', $userName, $pwHash);
        $sqlStatement->execute();
        $sqlStatement->close();
    }
    $mysqli->close();

}

?>


<!DOCTYPE html>
<html>
<head>
    <title>VIA - Create Account</title>
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
            <h2>Create your account</h2>
            <h3>please contact your manager to gain access to your account.</h3>
            <!-- Form with two fields -->
            <form action="createAccount.php" method="post">
                <input type="text" name="muName" id="muName" placeholder="Your Managers User Name"required>
                <input type="text" name="userName" id="userName" placeholder="Your User Name"required>
                <input type="password" name="password" id="password" placeholder="Your Password"required>
                <input type="password" name="password2" id="password2" placeholder="Re-Enter Your Password"required>
                <!-- button login -->
                <input class="small-link wide-link" type="submit" value="Submit">
            </form>
            <!-- div for -------or---------- -->
            <h3>--or--</h3>
            <!-- button to create account -->
            <a class="small-link wide-link" href="createAccount.php">Create Account</a>
        </div>




    </main>

</body>

</html>