<?php
	include 'dbconfig.php';
	$userId = $_GET['userId']; // Get userId created from cookie and passed as GET method through AJAX

	$imageQuery = "SELECT * FROM 2018spfdb.Images WHERE userID = '$userId'";
	$imageQueryResult = mysqli_query($conn, $imageQuery);
	if(!$imageQueryResult) {
		die("Database query failed: " . mysqli_error($conn));
	}
	$returnVar = array();
	$countImage = mysqli_num_rows($imageQueryResult);
	$i = 0
	if ($countImage > 0){
		while($row = mysqli_fetch_array($imageQueryResult, MYSQLI_ASSOC)){
	        $returnVar[$i] = $row['path'];
	        $i++;
		}
	}

    echo json_encode($returnVar);
?>