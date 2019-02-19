<?php
function Connect(){
	$server = "imc.kean.edu";
	$dbusername = "2018spf";
 	$dbpassword = "spf2018";
	$dbname = "2018spfdb"; 

	$conn = new mysqli($server, $dbusername, $dbpassword, $dbname) or die($conn -> connect_error);

	return $conn;
}
?>
