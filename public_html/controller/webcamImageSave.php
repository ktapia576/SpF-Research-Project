
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
	$owner = "2018spf";
	//Create the imageÂ 
	//$filePath = '/home/students/2018spf/spf_images/' .$userFName . '_' . $userLName. '/';
	$filePath = '/home/students/2018spf/public_html/UserImg/' .$username .'/'. $fileName;

	
	$dirName = dirname($filePath);
	//echo $dirName;
	if (!is_dir($dirName))
	{

	    mkdir($dirName, 0777, true);
	    chown($filePath, "2018spf");
	}

	//saves image to server
	touch($filePath);
	$fp = fopen($filePath , 'w');
	fwrite($fp, $decodedData);
	fclose($fp);

	chmod($filePath, 0707);
	chown($filePath, $owner);

	echo "<br>cmd1:$cmd\n";
	$cmd= "/user/bin/chown $owner $filePath";
	exec($cmd);
	echo "<br>cmd2:$cmd\n";


	//calls script to output label of image. It will create a temp image then remove it
	$filePath2 = '/home/students/2018spf/public_html/uploads/temp.png';
	touch($filePath2);
	$fp2 = fopen($filePath2 , 'w');
	fwrite($fp2, $decodedData);
	fclose($fp2);

	chmod($filePath, 0707);
	$command = "python3 /home/students/2018spf/public_html/tensorFlowTest/label_image.py --graph=/home/students/2018spf/public_html/tensorFlowTest/retrained_graph.pb --labels=/home/students/2018spf/public_html/tensorFlowTest/retrained_labels.txt --input_layer=Placeholder --output_layer=final_result --image=/home/students/2018spf/public_html/uploads/temp.png";
	$handle = popen($command, "r");
	//echo "'$handle'; " . gettype($handle) . "\n";
	$read = fread($handle, 2096);
	echo "<BR>";
	$row = explode("\n", trim($read));
	for($i = 0; $i< count($row); $i++){
	    $a = $row[$i];
	    echo "$a"."<BR>";
	}
	pclose($handle);
 
// adds path to database 
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
