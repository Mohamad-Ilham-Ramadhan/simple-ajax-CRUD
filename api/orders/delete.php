<?php 
	// required headers
	header("Access-Control-Allow-Origin: *");
	// header("Content-Type: application/json; charset=UTF-8");
	// header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	// include database and object file
	include_once '../config/database.php';
	include_once '../objects/orders.php';

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	// initialize orders
	$orders = new Orders($db);

	// get orders id
	$data = json_decode(file_get_contents("php://input"));

	// set orders id to be deleted
	$orders->id = $data->id;

	$orders->delete()
	

?>