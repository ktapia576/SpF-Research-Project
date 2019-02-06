<?php
	include ("connection.php");
	$username = $_POST['username'];
	$password = $_POST['pass'];

	if(!empty($username) && !empty($password)) {
			    //Fetch from database
			    $query = "select * from 2018S_shelara.spf_user where email = '$username' and password = '$password';";
			   
			    $result = mysqli_query($conn,$query);
				if(!$result) {
		    		die("Database query failed: " . mysqli_error($conn));
				}
				$count = mysqli_num_rows($result);
			     
				if ($count == 1){
					$row = mysqli_fetch_assoc($result);
					$uid = $row['uid'];

					header("Location:../view/dashboard.html");
					
					//store user details in cookie
					setcookie("userId", $uid, time() + (86400 * 30), "/");
					setcookie("userFName", $row['first_name'], time() + (86400 * 30), "/");
					setcookie("userLName", $row['last_name'], time() + (86400 * 30), "/");
				}else{
					$message = "Please enter a valid email id and password.";
					header("Location:../view/login.html?result=Please enter a valid email id and password.");
					//echo $message;
				}
			}

?>
	