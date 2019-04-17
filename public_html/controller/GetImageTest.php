<?php
include 'dbconfig.php';

if(!isset($_COOKIE['userId'])){
	echo "Cookie not set!";
}
else {
	echo "Cookie set!";
	$conn = Connect();
	$userId = $_COOKIE['userId'];

	$query = "SELECT path from 2018spfdb.Images where userID = '$userId'";
	$result = mysqli_query($conn, $query);
	echo "<table border='1'>
			<tr>
				<th>Image</th>
				<th>Select to delete</th>
			</tr>";
	while($row = mysqli_fetch_assoc($result)){
		echo "<tr>";
		echo "<td>". $row['path']."</td>";
		echo "<td><img src='".$row['path']."' width = '400' height='250'></td>";
		echo "<td><input type='radio'></td>";
		echo "</tr>";
	}
	echo "</table>";
}


?>