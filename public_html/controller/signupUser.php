<?php
	include 'dbconfig.php';
	$conn = Connect();
		
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$firstName = $conn->real_escape_string($_POST['firstName']);
			$lastName = $conn->real_escape_string($_POST['lastName']);
			$username = $conn->real_escape_string($_POST['uname']);
			$emailId = $conn->real_escape_string($_POST['emailID']);
			$birthdate = $conn->real_escape_string($_POST['birthdate']);
			$gender = $conn->real_escape_string($_POST['gender']);
			$password = $conn->real_escape_string($_POST['password']);
			$encrypt = hash("sha256", $password);
		
		//debug_to_console($firstName . ' ' . $lastName . ' ' . $emailId . ' ' . $birthdate . ' ' . $gender . ' ' . $password);

		   	$query = "INSERT INTO 2018spfdb.Users (username, email, fname, lname, sex, DOB, passwd) 
				values ('$username','$emailId','$firstName', '$lastName', '$gender', '$birthdate', '$encrypt')";
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