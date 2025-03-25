<?php
require_once "Database.php";

abstract class Model {
	protected static  $con;
	protected static  $table;
	protected static $params = [];
	protected static $conditions = [];

	public static function init(){
		self::$con = Database::getInstance()->getConnection();
	}

	public static function all() {
		self::init();
		$stmt = self::$con->prepare("SELECT * FROM " . static::$table);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public static function find($id) {
		self::init();
		$stmt = self::$con->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
		$stmt->execute(array($id));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	public static function create($data) {
		self::init();
		$columns = implode(", ", array_keys($data));
		$placeholders = ":" . implode(", :", array_keys($data));
		$stmt = self::$con->prepare("INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)");
		foreach ($data as $key => $val) {
			$stmt->bindValue(":$key", $val);
		}
		return $stmt->execute();
	}
	public static function update($id, $data) {
		self::init();
		$setPart = implode(", ", array_map(function ($col) {
			return "$col = :$col";
		}, array_keys($data)));

		$stmt = self::$con->prepare("UPDATE " . static::$table . " SET $setPart WHERE id = :id");
		foreach ($data as $key => $val) {
			$stmt->bindValue(":$key", $val);
		}
		$stmt->bindValue(":id", $id);
		return $stmt->execute();
	}
	public static function delete($id) {
		self::init();
		$stmt = self::$con->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
		return $stmt->execute(array($id));
	}
	public static function where($column, $operator, $value): Model {
		self::$conditions[] = "$column $operator :$column";
		self::$params[$column] = $value;
		return new static;
	}
	public static function get() {
		$stmt = self::getPrepare();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public static function first() {
		$stmt = self::getPrepare();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * @return mixed
	 */
	public static function getPrepare(){
		self::init();
		$query = "SELECT * FROM " . static::$table;
		if (!empty(self::$conditions)) {
			$query .= " WHERE " . implode(" AND ", self::$conditions);
		}
		$stmt = self::$con->prepare($query);
		foreach (self::$params as $key => $val) {
			$stmt->bindValue(":$key", $val);
		}
		$stmt->execute();
		self::$conditions = [];
		self::$params = [];
		return $stmt;
	}
}