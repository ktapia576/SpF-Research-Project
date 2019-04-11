
<?php
include 'dbconfig.php';
try
{
	$rawData = $_POST['imgBase64'];
	$userId = $_POST['userId'];
	$username = $_POST['username'];
	$userFName = $_POST['userFName'];
	$userLName = $_POST['userLName'];
	$filteredData = explode(',', $rawData);
	$decodedData = base64_decode($filteredData[1]);	
	$fileName = round(microtime(true) * 1000) .'.png';
	//Create the imageÂ 
	//$filePath = '/home/students/2018spf/spf_images/' .$userFName . '_' . $userLName. '/';
	$filePath = '../UserImg/' .$username .'/'. $fileName;

	/*$dirName = dirname($filePath .$fileName);
	if (!is_dir($dirName))
	{
	    mkdir($dirName, 0777, true);
	}*/

	//saves image to server
	touch($filePath);
	chmod($filePath, 0705);
	$fp = fopen($filePath , 'w');
	fwrite($fp, $decodedData);

	fclose($fp);

	$conn=Connect();
	$date=date('Y-m-d H:i:s');
	$query = "INSERT INTO Images (userID, path, uploadDate) VALUES ('$userId', '$filePath', '$date')";
	$result = mysqli_query($conn,$query);
	if($result) {
		//Tensorflow here to get output of a match or not
		//run py script on image and display classify results
		$output = shell_exec('sh ../tensorFlow/runImageClassifier.sh '.$fileName);
		//echo "</br>";
		echo "<pre><h3>$output</h3></pre>";
		
		//non functional at this point, but cqn be worked on
		/*if((strpos($output , 'Success') !== false) && (strpos($output , $userFName) !== false)){
		    //save image to respective directory as well

		    $respectiveFilePath = '/home/students/2018spf/public_html/UserImg' .$userFName . '_' . $userLName. '//';      
		    $respectivedirName = dirname($respectiveFilePath . $fileName);
			if (!is_dir($respectivedirName ))
			{
	    		mkdir($respectivedirName , 0755, true);
			}
			$respectivefp = fopen($respectiveFilePath .$fileName, 'w');
			fwrite($respectivefp, $decodedData);
			fclose($respectivefp);
			//echo $fileName. " " . $respectiveFilePath . " " . $fileName. " Image uploaded to respective Directory as well";
		} */
		//echo "</center>";
	}	
	else {
		echo "Failure: couldn't insert into database";
		echo "File Path is: ". $filePath;
	}

}
catch (Exception $e) {
	echo 'Failure: ' .$e->getMessage();
}
?>