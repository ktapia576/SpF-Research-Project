<?php
	include ("connection.php");
	$userId = $_GET['userId'];

	$imageQuery = "select * from 2018S_shelara.spf_image where uid = '$userId' and deleteUserImage <> 'Y';";
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

    echo json_encode($returnVar);
?>