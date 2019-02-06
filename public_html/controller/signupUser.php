<?php
	include ("connection.php");
		
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$emailId = $_POST['emailID'];
			$birthdate = $_POST['birthdate'];
			$gender = $_POST['gender'];
			$password = $_POST['password'];
		
		//debug_to_console($firstName . ' ' . $lastName . ' ' . $emailId . ' ' . $birthdate . ' ' . $gender . ' ' . $password);

		   	$query = "insert into 2018S_shelara.spf_user (`first_name`, `last_name`, `gender`, `birthdate`, `email`, `password`) 
				values ('$firstName','$lastName','$gender', '$birthdate', '$emailId', '$password');
				;";
			$result = mysqli_query($conn,$query);
			if(!$result) {
	    		//die("Database query failed: " . mysql_error());
	    		header('Location: ../view/signup.html?result=User signup was unsuccessful. Please try again');
			}	
			else {
				$last_id = mysqli_insert_id($conn);
				//store user details in cookie
				setcookie("userId", $last_id, time() + (86400 * 30), "/");
				setcookie("userFName", $firstName, time() + (86400 * 30), "/");
				setcookie("userLName", $lastName, time() + (86400 * 30), "/");
			
				//redirect to student dashboard
				header('Location: ../view/dashboard.html');
			}	
	}
?>