<?php 

	$page = isset($_GET['page']) ? $_GET['page'] : 1;

	// jumlah records per halaman
	$records_per_page = 3;

	// no index record
	$from_record_num = ($page * $records_per_page) - $records_per_page;

	// home URL
	$home_url = 'http://localhost/coffee_orders_ajax/api/';

?>