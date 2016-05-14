<?php

class Model {

	private $q = array('where'=>null, 'limit'=>null);

	private $db;

	public function __construct($table) {
		$pre = defined('TABLE_PREFIX')? TABLE_PREFIX:'';
		$this->q['table'] = $pre.strtolower(preg_replace('/([A-Z])/', '_$1', lcfirst($table)));
		$this->db = MySQLPDO::getInstance();
	}

	public function where($where, $return=false) {
		// 根据传入参数组合查询条件 
		if (is_array($where)) {
			$conditions = array();
			foreach ($where as $k => $v) {
				if (is_array($v)) {
					$v = array_map(function($v){return "'".$v."'";}, $v);
					$val = implode(',', $v);
					$conditions[] = "$k IN ($val)";
				} else {
					$conditions[] = "$k=$v";
				}
			}
			$this->q['where'] = 'WHERE '.implode(' AND ', $conditions);
		} else {
			$this->q['where'] = 'WHERE '.$where;
		}
		// 返回当前对象，用于连贯操作
		return $this;
	}

	public function limit($offset, $len=null) {
		$this->q['limit'] = "LIMIT ".is_null($len)? "$offset":"$offset,$len";
		return $this;
	}

	public function fetchAll($fields=null) {
		$fields = $this->_fields($fields);
		$q = "SELECT $fields FROM `{$this->q['table']}` {$this->q['where']} {$this->q['limit']}";	  
		return $this->query($q);
	}

	public function fetch($fields=null) {
		$fields = $this->_fields($fields);
		$q = "SELECT $fields FROM `{$this->q['table']}` {$this->q['where']}";
		$stmt = $this->db->query($q);
		return $stmt->fetch();
	}

	public function getField($field, $all=false) {
		if ($all) {
			$fields = array();
			foreach ($this->fetchAll($field) as $v) {
				$fields[] = $v[$field];
			}
			return $fields;
		} else {
			return $this->fetch($field)[0];
		}	
	}

	public function insert($data) {
		// 将参数转换为SQL格式 
		$fields = '';
		$params = '';
		foreach ($data as $k => $v) {
			$fields .= "`$k`,";
			$params .= ":$k,";
		}
		$fields = rtrim($fields, ','); 
		$params = rtrim($params, ',');
		// 执行查询 
		$stmt = $this->db->query(
			"INSERT INTO `{$this->q['table']}` ($fields) VALUES ($params)",
			$data
		);
		// 返回插入的主键ID 
		if ($stmt) return $this->db->getDB()->lastInsertId();
	}

	public function delete($where) {
		$stmt = $this->db->query("DELETE FROM `{$this->q['table']}` WHERE $where");
		if ($stmt) return true;
	}

	public function update($data) {
		// 将参数转换为SQL格式 
		$q = 'SET ';
		foreach ($data as $k => $v) {
			$q .= "`$k`=:$k,";
		}
		$q = rtrim($q, ',');
		// 执行查询 
		$stmt = $this->db->query(
			"UPDATE `{$this->q['table']}` $q {$this->q['where']}",
			$data
		);
		// 返回结果 
		if ($stmt) return true;
	}

	protected function query($sql) {
		$stmt = $this->db->query($sql);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	private function _fields($fields) {
		if (is_null($fields)) {
			return '*';
		} else {
			if (is_array($fields)) {
				$fields = array_map(function($v){return '`'.$v.'`';}, $fields);
			} else {
				$fields = array_map(function($v){return '`'.$v.'`';}, explode(',', $fields));
			}
			return implode(',', $fields);
		}
	}
}
