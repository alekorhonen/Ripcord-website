<?php

require_once("../../assets/php/configuration.php");

//Start: Json return functions
function return_false($message) {
	$jsonArrayObject = 
		array(
			'success' => false,
			'message' => $message
		);
		
	return json_encode($jsonArrayObject);
}

function return_true($message) {
	$jsonArrayObject = 
		array(
			'success' => true,
			'message' => $message
		);
		
	return json_encode($jsonArrayObject);
}
//End: Json return functions

if(!isset($_GET['action'])) {
	echo return_false("Invalid API call.");
	exit;
}

if(!isset($_GET['apikey'])) {
	echo return_false("Invalid API key.");
	exit;
}

$date = date("Y-m-d h:i:sa");

//Lets check our API key before letting the user do anything. Start by securing the request, as it is indeed a user inputted value.
$apikey = $conn->real_escape_string(htmlspecialchars(strip_tags($_GET['apikey'])));

//Do our query, and check at the same time if the apikey is banned, this way we can store our old ip logs.
$select_query = "SELECT * FROM table_apikeys WHERE apikey = '$apikey' AND banned = 0";
$result = $conn->query($select_query);
if($result->num_rows == 0) {
	echo return_false("Invalid API key.");
	exit;
}

//Time to check if our limit is already reached.
$keydata = $result->fetch_assoc();
$date = date("Y-m-d");

//Lets get the apikey limit data from another table
$select_query = "SELECT * FROM table_limits WHERE apikey = '$apikey' AND date_created = '$date'";
$result = $conn->query($select_query);
if($result->num_rows == 0) {
	//If there is no requests created today, create a row
	$conn->query("INSERT INTO table_limits VALUES ('$apikey', 0, '$date')");
} else {
	//If the apikey is found in limits table from today's date then check how many requests has he done
	$limitdata = $result->fetch_assoc();
	if($limitdata['requests_done'] < 2) {
		
	} else {
		echo return_false("You have reached your daily limit.");
		exit;
	}
}

if($_GET['action'] == "getdetails") {
	$jsonArrayObject = 
		array(
			'success' => true,
			'apikey' => $keydata['apikey'], 
			'my_limit' => $keydata['request_limit'], 
			'total_lookups' => $keydata['total_lookups']
		);
		
	echo json_encode($jsonArrayObject);
}


if($_GET['action'] === "getproxy") {
	//If the action get proxy details is set, then continue by checking if inputted proxy is valid to avoid any unnessecary database calls.
	if(!isset($_GET['proxy'])) {
		//If the proxy is not set on request then report for invalid api call.
		echo return_false("Incorrect parameters.");
		exit;
	}
	
	$proxy = $_GET['proxy'];
	
	//If the proxy matches the regex, then continue by grabbing its details from the database.
	if(!preg_match("/[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}:[0-9]{2,5}/", $proxy)) {
		echo return_false("Proxy was inputted incorrectly.");
		exit;
	}
	
	//Lets secure the get request of "proxy" as it is indeed again a user inputted value.
	$proxy = $conn->real_escape_string(htmlspecialchars(strip_tags($_GET['proxy'])));
	
	$select_query = "SELECT * FROM table_proxies WHERE proxy = '$proxy'";
	$result = $conn->query($select_query);
	
	if($result->num_rows == 0) {
		echo return_false("Proxy was not found in our database.");
		exit;
	}
	
	//Update the user request limit, add 1 to it
	$conn->query("UPDATE table_limits SET requests_done = requests_done + 1 WHERE apikey = '$apikey'");
	
	//Lets fetch the data if proxy is found.
	$row = $result->fetch_assoc();
		
	//Convert our proxy into 
	$jsonArrayObject = 
		array(
			'success' => true,
			'proxy' => base64_encode($row["proxy"]), 
			'anonymity_level' => $row["anonymity_level"], 
			'country' => $row["country"], 
			'region' => $row["region"], 
			'city' => $row["city"], 
			'speed' => $row["speed"],
			'first_found_on' => $row["date_uploaded"],
			'last_checked' => $row["last_checked"],
			'total_times_checked' => $row["times_checked"]
		);
		
	$json_array = json_encode($jsonArrayObject);
	echo $json_array;
	exit;
}

if($_GET['action'] === "postproxy") {
	
	//Check if our data post value is set
	if( !isset($_POST['data']) ) {
		echo return_false("Incorrect parameters.");
		exit;
	}
	
	//Lets decode the data that was sent
	$data = json_decode( urldecode($_POST['data']) , true );
	
	/*
		START: Check if all data values are set
	*/
	
	if( !isset( $data['proxy'] ) ){
		echo return_false("Proxy was not set in inputted data.");
		exit;
	}
	
	if( !isset( $data['anonymity'] ) ){
		echo return_false("Anonymity was not set in inputted data.");
		exit;
	}
	
	if( !isset( $data['country'] ) ){
		echo return_false("Country was not set in inputted data.");
		exit;
	}
	
	if( !isset( $data['region'] ) ){
		echo return_false("Region was not set in inputted data.");
		exit;
	}
	
	if( !isset( $data['city'] ) ){
		echo return_false("City was not set in inputted data.");
		exit;
	}
	
	if( !isset( $data['response_time'] ) && is_numeric( $data['response_time'] ) && $data['response_time'] > 0 ){
		echo return_false("Response was not set in inputted data, or was inputted incorrectly.");
		exit;
	}
	
	//Secure our data values
	
	$proxy = $conn->real_escape_string(htmlspecialchars(strip_tags($data['proxy'])));
	$anonymity = $conn->real_escape_string(htmlspecialchars(strip_tags($data['anonymity'])));
	$country = $conn->real_escape_string(htmlspecialchars(strip_tags($data['country'])));
	$region = $conn->real_escape_string(htmlspecialchars(strip_tags($data['region'])));
	$city = $conn->real_escape_string(htmlspecialchars(strip_tags($data['city'])));
	$response_time = $conn->real_escape_string(htmlspecialchars(strip_tags($data['response_time'])));
	
	//Double check the values
	
	if(!preg_match("/[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}:[0-9]{2,5}/", $proxy)) {
		echo return_false("Proxy was inputted incorrectly.");
		exit;
	}
	
	if($data['anonymity'] != "Transparent" || $data['anonymity'] != "Anonymous" || $data['anonymity'] != "Elite") {
		echo return_false("Anonymity was inputted incorrectly.");
		exit;
	}
	
	/*
		Massive region check on the user inputted data ( = correct results )
	*/
	
	//Check if the country exists
	$qcountry = $conn->query("SELECT * FROM countries WHERE name = '$country'");
	if( $qcountry->num_rows == 0 ) {
		echo return_false("Country was inputted incorrectly.");
		exit;
	}
	
	$countrydata = $qcountry->fetch_assoc();
	
	//Check if the region exists in the country
	$qregion = $conn->query("SELECT * FROM regions WHERE name = '$region' AND country_id = ".$countrydata['id']);
	if( $qregion->num_rows == 0 ) {
		echo return_false("Region was inputted incorrectly.");
		exit;
	}
	
	$regiondata = $qregion->fetch_assoc();
	
	//Check if city name exists in the region
	$qcity = $conn->query("SELECT * FROM cities WHERE region_id = ".$regiondata['id']." AND name = '$city'");
	if( $qcity->num_rows == 0 ) {
		echo return_false("City was inputted incorrectly.");
		exit;
	}
	
	/*
		END: Check if all data values are set
	*/
	
	//If everything went well in our check, we get to proceed into inserting/updating the data 
	
	$check_proxy = $conn->query("SELECT * FROM table_proxies WHERE proxy = '$proxy'");
	if( $check_proxy->num_rows > 0 ) {
		//If it did find the proxy in our database, then update the data rather than insert another row.
		
		$conn->query("UPDATE table_proxies SET times_checked = times_checked + 1 WHERE proxy = '$proxy'");
		$conn->query("UPDATE table_proxies SET speed = $response_time WHERE proxy = '$proxy'");
		$conn->query("UPDATE table_proxies SET last_checked = $date WHERE proxy = '$proxy'");
		
		echo return_true("Proxy was updated in our database.");
		exit;
	}
	$insert_query = "INSERT INTO table_proxies (proxy, anonymity_level, country, region, city, speed, date_uploaded, last_checked, added_by) VALUES
		($proxy, $anonymity, $country, $region, $city, $response_time, $date, $date, $apikey)";
	$result = $conn->query($insert_query);
	if( !$result ) {
		echo return_false("Proxy was inserted into our database.");
		exit;
	} 
	
	echo return_true("Proxy was uploaded to database."); 
	exit;
}

?>