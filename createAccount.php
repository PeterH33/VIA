


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
            <form action="authLogin.php" method="post">
                <input type="text" name="userName" id="userName" placeholder="Your Managers User Name"required>
                <input type="text" name="userName" id="userName" placeholder="Your User Name"required>
                <input type="password" name="password" id="password" placeholder="Your Password"required>
                <input type="password" name="password" id="password" placeholder="Re-Enter Your Password"required>
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