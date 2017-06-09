<?php 
	// required headers
	header("Access-Control-Allow-Origin: *");
	// header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	// get database connection
	include_once '../config/database.php';
	include_once '../objects/orders.php';

	$database = new Database();
	$db = $database->getConnection();

	// initialize object
	$orders = new Orders($db);

	// get posted data
	$data = json_decode(file_get_contents("php://input"));

	if ($data) {
		// set orders property values
		$orders->name = $data->name;
		$orders->drink = $data->drink;

		// add orders

		$orders->create();
	}

	
?>