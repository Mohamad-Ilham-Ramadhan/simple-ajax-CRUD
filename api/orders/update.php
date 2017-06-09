<?php 
	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Header: Access-Control-Allow-Header, Authorization, X-Requested-With");

	// include database and object
	include_once('../config/database.php');
	include_once('../objects/orders.php');

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	// initialize orders object
	$orders = new Orders($db);

	// get data posted data
	$data = json_decode(file_get_contents("php://input"));

	// check if there's posted data
	if ($data) {
		// set orders property values
		$orders->id = $data->id;
		$orders->name = $data->name;
		$orders->drink = $data->drink;

		$orders->update();
	}
	
?>	