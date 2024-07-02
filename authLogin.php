<!-- We have 3 states here, fail, approval needed, and success -->
<?php
    function sanitizeString($var)
    {
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }

    require 'dbConn.php';
    $mysqli->close();
