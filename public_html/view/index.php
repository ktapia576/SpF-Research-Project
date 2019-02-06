<!DOCTYPE html>
<html>
<head>
	<title>Image Classifier</title>
<style type = "text/css">
body{
	background-color: #E3E4FA;
}
</style>
</head>

<body>
<center>
<h1><u>Image Classification using TensorFlow </u></h1>
<hr />
<h2>Upload a photo of a person!</h2>
<h4>(This application will predict your emotion)</h4>

<form action="index.php" method="POST" enctype="multipart/form-data">
	<input type="file" name="file">
	<button type="submit" name="submit">Upload</button>
</form>
</center>

</body>
<?php
//include label_image.py;


if (isset($_POST['submit'])) {
	$file = $_FILES['file'];

	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['size'];
	$fileError = $file['error'];
	$fileType = $file['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg', 'jpeg', 'png', 'pdf');

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileSize < 1000000) {
				$fileNameNew = uniqid('', true).".".$fileActualExt;
				$fileDestination = '../tensorFlow/tempUploads/'.$fileNameNew;

				move_uploaded_file($fileTmpName, $fileDestination);
echo $fileDestination;
				//header("Location: index.php?uploadsuccess");
				
				echo "<br>";
				echo "<center>";
				//display upload imge
				$image = '../tensorFlow/tempUploads/'.$fileNameNew;
				$imageData = base64_encode(file_get_contents($image));
				$src = 'data: '.mime_content_type($image).';base64,'.$imageData;
				echo '<img src="' . $src . '">';
				
				//run py script on image and display classify results
				$output = shell_exec('sh ../tensorFlow/runImageClassifier.sh '.$fileNameNew);
				//echo "<BR><b>My top guess is...</b><BR>";
				echo "<h3>What's your emotion today?</h3>";
				echo "<pre><h3>$output</h3></pre>";
				echo "</center>";
				
			} else {
				echo "Your file is too big!";
			}
		} else {
			echo "There was an error uploading your file!";
		}
	} else {
		echo "You cannot upload files of this type!";
	}
}
?>
</html>
