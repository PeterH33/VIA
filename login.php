

<!DOCTYPE html>
<html>
<head>
    <title>VIA - login</title>
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
            <h2>Login</h2>
            <h3>Enter your login credentials</h3>
            <!-- Form with two fields -->
            <form action="authLogin.php" method="post">
                <input type="text" name="userName" id="userName" placeholder="Your User Name" required>
                <input type="password" name="password" id="password" placeholder="Your Password" required>
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