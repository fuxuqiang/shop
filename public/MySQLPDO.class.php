<?php

class MySQLPDO {
	private static $instance;
	private $db;

	private function __construct($flag=false) {
		try {
			$this->db = new PDO(
				'mysql:host='.HOST.';dbname=shop;charset=utf8',
				USER,
				PWD,
				array(PDO::ATTR_ERRMODE=>2)
			);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	private function __clone() {}

	public static function getInstance() {
		if (!self::$instance instanceof self) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function getDB() {
		return $this->db;
	}

	public function query($sql, $data=null) {
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->execute($data);
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
		return $stmt;
	}
}