<?php
	include 'dbconfig.php';
	$conn = Connect();
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['pass']);
	$encrypt = hash("sha256", $password);

	if(!empty($username) && !empty($password)) {
			    //Fetch from database
			    $query = "SELECT u_id, username, passwd, fname, lname from 2018spfdb.Users where username = '$username' and passwd = '$encrypt'";
			   
			    $result = mysqli_query($conn,$query);
				if(!$result) {
		    		die("Database query failed: " . mysqli_error($conn));
				}
				$count = mysqli_num_rows($result);
			     
				if ($count == 1){
					$row = mysqli_fetch_assoc($result);
					$uid = $row['u_id'];

					header("Location:../view/dashboard.html");
					
					//store user details in cookie
					setcookie("userId", $uid, time() + (86400 * 30), "/");
					setcookie("username", $username, time() + (86400 * 30), "/");
					setcookie("userFName", $row['fname'], time() + (86400 * 30), "/");
					setcookie("userLName", $row['lname'], time() + (86400 * 30), "/");
				}else{
					$message = "Please enter a valid username and password.";
					header("Location:../view/login.html?result=Please enter a valid username and password.");
					//echo $message;
				}
			}
mysqli_close($conn);
?>
	