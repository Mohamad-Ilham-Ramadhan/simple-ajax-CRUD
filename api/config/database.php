<?php 

	class Database {
		private $hostname = 'localhost';
		private $database = 'coffee_orders';
		private $username = 'root';
		private $password = '';

		public $conn;

		public function getConnection(){

			$this->conn = null;

			try {
				$this->conn = new PDO('mysql:host='.$this->hostname.';dbname='.$this->database, $this->username, $this->password); 
			} catch(PDOException $exception) {
				echo 'Connection Error: '.$exception->getMessage();
			}

			return $this->conn;
		} // getConnection()
	}
?>