<?php
include 'dbconfig.php';

if(!isset($_COOKIE[$username])){
	echo "Cookie not set!";
}
else {
	echo "Cookie set!";
}


?>