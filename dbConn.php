<?php
function sanitizeString($var)
{
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}

$mysqli = new mysqli("127.0.0.1", "viaDemon", "pword", "viaDB");

if ($mysqli->connect_error){
    die("Connection failed: madeAccount " . $mysqli->connect_error);
}


?>