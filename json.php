<?php
	$jsonArrayObject = 
		array(
			'success' => true,
			'message' => "Proxy was inserted into our database."
		);
		
	echo json_encode($jsonArrayObject);
?>