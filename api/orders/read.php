<?php 
	// Read Orders
	
	header("Access-Control-Allow-Origin: *"); // which means that the resource can be accessed by any domain in a cross-site-manner
	header("Content-Type: application/json; charset = UTF-8");

	// include database and object file
	include_once '../config/database.php';
	include_once '../objects/orders.php';

	// instantiate database and product object
	$database = new Database();
	$db = $database->getConnection();

	// initialize object
	$orders = new Orders($db);

	// query orders
	$stmt = $orders->read();
	$num = $stmt->rowCount();

	// check if return more than 0 record
	if ($num > 0) {
		
		// products array
		$orders_arr = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			// extract row
			// this will make $row['name'] to just $name only
			extract($row);

			$orders_item = array(
				"id" => $id,
				"name" => $name,
				"drink" => $drink
			);

			array_push($orders_arr, $orders_item);
		}

		// make it into json biatch
		echo json_encode($orders_arr);
	} else {
		echo json_encode(
			array(
				"message" => "There is no orders sir!"
			)
		);
	}
?>