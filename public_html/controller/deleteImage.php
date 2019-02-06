<?php
	include ("connection.php");
	$imageId = $_GET['imageId'];

	$imageDeleteQuery = "update 2018S_shelara.spf_image set deleteUserImage = 'Y' where iid = '$imageId';";
	$imageDeleteQueryResult = mysqli_query($conn, $imageDeleteQuery);
	if(!$imageDeleteQueryResult) {
		die("Database query failed: " . mysqli_error($conn));
		echo "Failed to delete image in database";
	}
	echo "Successfully deleted image in database";
?>