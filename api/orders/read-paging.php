<?php 
	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	// include database and object files
	include_once '../config/pagination.php';
	include_once '../config/database.php';
	include_once '../utilities/pagination.php';
	include_once '../objects/orders.php';

	// utilities
	$pagination = new Pagination();

	$database = new Database();
	$db = $database->getConnection();

	$orders = new Orders($db);

	$stmt = $orders->readPaging($from_record_num, $records_per_page);
	$num = $stmt->rowCount();

	// check if more than 0 records found
	if ($num > 0) {
		
		// orders array
		$orders_arr = array();
		$orders_arr['records'] = array();
		$orders_arr['paging'] = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			extract($row);

			$orders_item = array(
				"id" => $id,
				"name" => $name,
				"drink" => $drink
			);

			array_push($orders_arr['records'], $orders_item);
		}

		// paging
		$total_rows = $orders->count();
		$page_url = "{$home_url}orders/read-paging.php";
		$paging = $pagination->getPaging($page, $total_rows, $records_per_page, $page_url);
		$orders_arr['paging'] = $paging;

		echo json_encode($orders_arr);
	} else {
		echo json_encode(
			array("message" => "No products found.")
		);
	}
?>