<?php

class model {

	private $table;

	protected $db;

	private function getField($data) {
		$fields = '';
		$params = '';
		foreach ($data as $k => $v) {
			$fields .= "`$k`,";
			$params .= ":$k,";
		}
		return array(rtrim($fields, ','), rtrim($params, ','));
	}

	public function __construct($table) {
		$this->table = $table;
		$this->db = MySQLPDO::getInstance();
	}

	public function fetchAll($fields, $where='1') {
		$stmt = $this->db->query("SELECT $fields FROM $this->table WHERE $where");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fetch($fields, $where='1') {
		$stmt = $this->db->query("SELECT $fields FROM $this->table WHERE $where");
		return $stmt->fetch();
	}


	public function insert($data) {

		$fields = $this->getField($data);

		$stmt = $this->db->query(
			"INSERT INTO $this->table ($fields[0]) VALUES ($fields[1])",
			$data
		);

		if ($stmt) {
			return $this->db->getDB()->lastInsertId();
		}
	}


	public function delete($where) {

		$stmt = $this->db->query("DELETE FROM $this->table WHERE $where");

		if ($stmt) {
			return true;
		} else {
			return false;
		}
	}


	public function update($data) {

		$fields = $this->getField($data);

		$stmt = $this->db->query(
			"REPLACE INTO $this->table ($fields[0]) VALUES ($fields[1])",
			$data
		);

		if ($stmt) {
			return true;
		} else {
			return false;
		}
	}
}