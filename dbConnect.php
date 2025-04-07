<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "jphp21";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn)
    echo "DB Not Connected";
?>