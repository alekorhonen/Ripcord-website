<?php
require("php/configuration.php");

$sql = "SELECT pid,proxy,anonymity_level,country,region,city,speed FROM table_proxies LIMIT 25";
$result = $conn->query($sql);
if($result->num_rows > 0) {
	$arr = [];
	$inc = 0;
	while($row = $result->fetch_assoc()) {
		$jsonArrayObject = (array('pid' => $row["pid"], 'proxy' => base64_encode($row["proxy"]), 'anonymity_level' => $row["anonymity_level"], 'country' => $row["country"], 'region' => $row["region"], 'city' => $row["city"], 'speed' => $row["speed"]));
		$arr[$inc] = $jsonArrayObject;
		$inc++;
	}

	$json_array = json_encode($arr);
	echo $json_array;
} else {
	echo "No proxies.";
}
?>