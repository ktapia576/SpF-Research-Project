<?php 
	$imagePath = $_GET['imagePath']; 
	//echo $result;

	$imageData = base64_encode(file_get_contents($imagePath));

	// Format the image SRC:  data:{mime};base64,{data};
	$src = 'data: '.mime_content_type($imagePath).';base64,'.$imageData;

	// Echo out a sample image
	echo $src;
?>