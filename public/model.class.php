<?php

class model {

	private $table;

	protected $db;

	public function __construct($table) {
		$this->table = $table;
		$this->db = MySQLPDO::getInstance();
	}

	protected function query($sql) {
		$stmt = $this->db->query($sql);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fetchAll($fields, $where='1') {
		return $this->query("SELECT $fields FROM `$this->table` WHERE $where");		
	}

	public function fetch($fields, $where) {
		$stmt = $this->db->query("SELECT $fields FROM `$this->table` WHERE $where");
		return $stmt->fetch();
	}

	public function getField($field, $where) {
		return $this->fetch($field, $where)[0];
	}


	public function insert($data) {

		$fields = '';
		$params = '';
		foreach ($data as $k => $v) {
			$fields .= "`$k`,";
			$params .= ":$k,";
		}
		$fields = rtrim($fields, ','); 
		$params = rtrim($params, ',');

		$stmt = $this->db->query(
			"INSERT INTO `$this->table` ($fields) VALUES ($params)",
			$data
		);

		if ($stmt) {
			return $this->db->getDB()->lastInsertId();
		}
	}


	public function delete($where) {

		$stmt = $this->db->query("DELETE FROM `$this->table` WHERE $where");

		if ($stmt) {
			return true;
		} else {
			return false;
		}
	}


	public function update($data, $where) {

		$q = '';
		foreach ($data as $k => $v) {
			$q .= "`$k`=:$k,";
		}
		$q = rtrim($q, ',');

		$stmt = $this->db->query(
			"UPDATE `$this->table` SET $q WHERE $where",
			$data
		);

		if ($stmt) {
			return true;
		} else {
			return false;
		}
	}
}