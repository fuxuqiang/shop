<?php

class Model {

	protected $table;

	protected $db;

	public function __construct($table) {
		$this->table = strtolower(preg_replace('/([A-Z])/', '_$1', lcfirst($table)));
		$this->db = MySQLPDO::getInstance();
	}


	private function where($where) {

		if (is_array($where)) {

			$conditions = array();

			foreach ($where as $k => $v) {

				if (is_array($v)) {
					$v = array_map(function($v){return "'".$v."'";}, $v);
					$val = implode(',', $v);
					$conditions[] = "`$k` IN ($val)";
				} else {
					$conditions[] = "`$k`='$v'";
				}
			}

			return implode(' AND ', $conditions);

		} else {
			return $where;
		}
	}


	protected function query($sql) {
		$stmt = $this->db->query($sql);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fetchAll($fields='*', $where='1') {
		$where = $this->where($where);
		return $this->query("SELECT $fields FROM `$this->table` WHERE $where");		
	}

	public function fetch($fields, $where) {
		$stmt = $this->db->query("SELECT $fields FROM `$this->table` WHERE $where");
		return $stmt->fetch();
	}

	public function getField($field, $where) {
		$where = $this->where($where);
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

		$where = $this->where($where);

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