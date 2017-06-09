<?php 
	class Pagination {
		public function getPaging($page, $total_rows, $records_per_page, $page_url) {

			// paging array
			$paging_arr = array();

			// first page
			$paging_arr['first'] = $page > 1 ? "{$page_url}?page=1" : "";

			// hitung semua records di database untuk menentukan jumlah halaman
			$total_pages = ceil($total_rows / $records_per_page);

			// range links
			$range = 2;

			// display range di sekitar 'current page'
			$initial_num = $page - $range;
			$conditional_limit_num = ($page + $range) + 1;

			$paging_arr['pages'] = array();
			$page_count = 0;

			for ($i = $initial_num; $i < $conditional_limit_num; $i++) {
				// pastikan $i lebih besar dari nol dan lebih kecil atau sama dengan $total_pages
				if (($i > 0) && ($i <= $total_pages)) {
					$paging_arr['pages'][$page_count]['page'] = $i;
					$paging_arr['pages'][$page_count]['url'] = "{$page_url}?page={$i}";
					$paging_arr['pages'][$page_count]['current_page'] = ($i == $page) ? "yes" : "no";

					$page_count++;
				}
				
			}

			// last page
			$paging_arr['last'] = $page < $total_pages ? "{$page_url}?page={$total_pages}" : "";

			// json format
			return $paging_arr;
		}
	}
?>