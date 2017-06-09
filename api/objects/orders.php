<?php 
	
	class Orders {
		// contruct with $db as database connection

		public function __construct($db) {
			$this->conn = $db;
		}	

		// Database connection and table name
		private $conn;
		private $table_name = 'orders';

		// Object properties
		public $id;
		public $name;
		public $drink;

		// read orders 
		public function read() {
			// select query
			$query = "SELECT * FROM $this->table_name";

			// perpare statement
			$stmt = $this->conn->prepare($query);

			// execute query
			$stmt->execute();
			return $stmt;
		}// read orders

		// create order
		public function create() {
			// insert query
			$query = "INSERT INTO $this->table_name SET name=:name, drink=:drink";

			// prepare query
			$stmt = $this->conn->prepare($query);

			// sanitize
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->drink = htmlspecialchars(strip_tags($this->drink));

			// bind values
			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':drink', $this->drink);

			// execute query
			if ($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		}// create order

		// create order response
		public function createResponse() {
			$query = "SELECT * FROM $this->table_name WHERE name=:name AND drink=:drink";

			// prepare 
			$stmt = $this->conn->prepare($query);

			// bind values
			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':drink', $this->drink);

			$stmt->execute();

			// get retrieved row
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// set values to object properties
			$this->id = $row['id'];
			$this->name = $row['name'];
			$this->drink = $row['drink'];
		}// create order response

		// delete order
		public function delete() {
			$query = "DELETE FROM $this->table_name WHERE id=?";

			// prepare biatch
			$stmt = $this->conn->prepare($query);

			// bind id biatch
			$stmt->bindParam(1, $this->id);

			// execute query
			if ($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		}// delete order

		// update order
		public function update() {
			$query = "UPDATE $this->table_name SET name=:name, drink=:drink WHERE id=:id";

			// prepare motherfucker
			$stmt = $this->conn->prepare($query);

			$stmt->bindParam(':id', $this->id);
			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':drink', $this->drink);

			if ($stmt->execute()) {
				return true;
			}else {
				return false;
			}
		}

		// readPaging
		public function readPaging($from_record_num, $records_per_page) {
			$query = "SELECT * FROM $this->table_name LIMIT ?, ?";

			$stmt = $this->conn->prepare($query);

			// bindParam
			$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt;
		} // readPaging

		// count
		public function count() {
			$query = "SELECT * FROM $this->table_name";

			$stmt = $this->conn->prepare($query);

			$stmt->execute();

			return $stmt->rowCount();
		}
	}
?>