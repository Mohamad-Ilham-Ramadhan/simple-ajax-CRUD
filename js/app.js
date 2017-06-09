let orders =  (function(){

	// cache DOM
	var $orders = $('#orders');
	var $name = $('#name');
	var $drink = $('#drink');
	var $orderTemplate = $('#order-template').html();
	var $paging = $('#orders-paging');

	//bind event
	$('#add-order').on('click', addOrder);
	$orders.delegate('.remove', 'click', _removeOrder);
	$orders.delegate('.saveEdit', 'click', _editOrder);
	$orders.delegate('.editOrder', 'click', _editState);
	$orders.delegate('.cancelEdit', 'click', _normalState);
	$paging.delegate('li', 'click', _getOrdersPaging);

	_getOrders(); // initial read data
	

	function _render(data) {
		var order_template = "";
			$.each(data.records, function(key, val) {
				order_template += '<li data-id="">';
					order_template += '<p>';
						order_template += '<strong>Name: </strong>';
						order_template += '<span class="noedit name">'+val.name+'</span>';
						order_template += '<input class="edit name" type="text">';
					order_template += '</p>';
					order_template += '<p>';
						order_template += '<strong>Drink: </strong>';
						order_template += '<span class="noedit drink">'+val.drink+'</span>';
						order_template += '<input class="edit drink" type="text">';
					order_template += '</p>';
					order_template += '<button data-id="'+val.id+'" class="remove">Delete</button>';
					order_template += '<button class="editOrder noedit">Edit</button>';
					order_template += '<button class="saveEdit edit">Save</button>';
					order_template += '<button class="cancelEdit edit">Cancel</button>';
				order_template += '</li>';
			});		

			$orders.html(order_template);
	}

	function renderPaging(data) {
		var paging_template = "";
		if (!data.message) {
			if (data.paging.first !== "") {
				paging_template += "<li data-url='"+data.paging.first+"'><a href=''>First</a></li>";
			}

			$.each(data.paging.pages, function(key, val){
				if (val.current_page == "yes") {
					paging_template += "<li data-url='"+val.url+"' class='active'><a href=''>"+val.page+"</a></li>";
				} else {
					paging_template += "<li data-url='"+val.url+"'><a href=''>"+val.page+"</a></li>";
				}
			});

			if (data.paging.last !== "") {
				paging_template += "<li data-url='"+data.paging.last+"'><a href=''>Last</a></li>";
			}
		}

		$paging.html(paging_template);
	}
		

	function _getOrders() {
		
		$.ajax({
			type: 'GET',
			url: '/coffee_orders_ajax/api/orders/read-paging.php',
			success: function(data) {
				_render(data);

				renderPaging(data);
			}
		});
	} // _getOrders()

	function _getOrdersPaging(event) {
		var $getURL = $(this).closest('li').attr('data-url');
		
		$.ajax({
			type: 'GET',
			url: $getURL,
			success: function(data) {
				_render(data);

				renderPaging(data);
			}
		});

		event.preventDefault();
	} // _getOrders()

	function addOrder(name, drink) {

		if (name && drink != undefined) {
			var order = {
				name: name,
				drink: drink
			};

			order = JSON.stringify(order);

			$.ajax({
				type: 'POST',
				url: '/coffee_orders_ajax/api/orders/create.php',
				data: order,
				success: function(data) {
					
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			});

			_getOrders();

			$name.val('');
			$drink.val('');
		} else if(event != undefined) {
			var order = {
				name: $name.val(),
				drink: $drink.val()
			};

			order = JSON.stringify(order);
			var getURL = $paging.find('li.active').attr('data-url');
			// console.log(getURL);

			$.ajax({
				type: 'POST',
				url: '/coffee_orders_ajax/api/orders/create.php',
				data: order,
				success: function() {
					$.ajax({
						type: 'GET',
						url: getURL,
						success: function(data) {
							_render(data);

							renderPaging(data);
						}
					});
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			});

			

			$name.val('');
			$drink.val('');
		}	
	} // addOrder

	function _removeOrder() {
		var $li = $(this).closest('li');
		var $id = $(this).attr('data-id');
		var order = {
			id: $id,
		};
		var getURL = $paging.find('li.active').attr('data-url');
		var prevPage = parseInt(getURL.slice(-1)) - 1;
		console.log(prevPage)
		$.ajax({
			type: 'DELETE',
			url: '/coffee_orders_ajax/api/orders/delete.php',
			data: JSON.stringify(order), 
			success: function(resp) {

				$li.fadeOut(150, function(){
					$(this).remove();
					var list = $orders.find('li');
					if (list.length < 1) {
						$.ajax({
							type: 'GET',
							url: 'http://localhost/coffee_orders_ajax/api/orders/read-paging.php?page='+prevPage,
							success: function(data) {
								_render(data);

								renderPaging(data);
							}
						});
					}
				});
			},
			error: function(xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		});
	} // removeOrder

	function _editOrder() {
		var $li = $(this).closest('li');
		var order = {
			id: $li.attr('data-id'),
			name: $li.find('input.name').val(),
			drink: $li.find('input.drink').val()
		};

		$.ajax({
			type: 'PUT',
			url: '/coffee_orders_ajax/api/orders/update.php',
			data: JSON.stringify(order),
			success: function() {
				$li.find('span.name').html(order.name);
				$li.find('span.drink').html(order.drink);
				$li.removeClass('edit');
			},
			error: function(xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		});
	}// editOrder 

	function _editState() {
		var $li = $(this).closest('li');
		$li.find('input.name').val( $li.find('span.name').html());
		$li.find('input.drink').val( $li.find('span.drink').html());
		$li.addClass('edit');
	} // editState

	function _normalState() {
		var $li = $(this).closest('li');
		$li.removeClass('edit');
	}

	return {
		addOrder: addOrder // bisa diakses dari console orders.addOrder(name, drink) untuk menambah order tanpa harus mengisi input field
	}
})();