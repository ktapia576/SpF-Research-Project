<?php
	include 'dbconfig.php';
	$conn = Connect();
	$userId = $_COOKIE['userId']; // Get userId created from cookie and passed as GET method through AJAX

	$imageQuery = "SELECT * FROM 2018spfdb.Images WHERE userID = '$userId'";
	$imageQueryResult = mysqli_query($conn, $imageQuery);
	if(!$imageQueryResult) {
		die("Database query failed: " . mysqli_error($conn));
	}
	$returnVar = array();
	$countImage = mysqli_num_rows($imageQueryResult);

	if ($countImage > 0){
		while($row = mysqli_fetch_array($imageQueryResult, MYSQLI_ASSOC)){
			$returnVar[] = $row;
		}
	}
	else {
		echo "No Images Found. CountImage=".$countImage.", userid=".$userId;
	}

    echo json_encode($returnVar);
?>