<?php

class Database {
	private $con;
	private static $instance = null;
	private function __construct() {
		try {
			$dsn = "mysql:host=localhost;dbname=php_labs";
			$option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8");
			$this->con = new PDO($dsn, "root", "", $option);
			$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		}
	}
	public static function getInstance(): Database {
		if (self::$instance === null) {
			self::$instance = new Database();
		}
		return self::$instance;
	}
	public function getConnection(): PDO {
		return $this->con;
	}
}
