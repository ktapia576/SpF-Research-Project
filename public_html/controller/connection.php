<?php
include('utility.php');
$servername = "imc.kean.edu";
$username = "shelara";
$password = "1063113";
$dbname = "2017F_shelara";

// Create connection
$conn = mysqli_connect($servername , $username , $password , $dbname);
$db = mysqli_select_db($conn,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//debug_to_console("Connected successfully");
?>