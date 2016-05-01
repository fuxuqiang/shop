<?php

class CategoryModel extends Model{

	private function _tree($data, $pid=0, $level=0) {
		static $rst = array();
		foreach ($data as $v) {
			if ($v['pid']==$pid) {
				$v['level'] = $level;
				$rst[] = $v;
				$this->_tree($data, $v['id'], $level+1);
			}
		}
		return $rst;
	}
	
	public function getData() {
		$data = $this->fetchAll();
		return $this->_tree($data);
	} 

	public function getSubIds($pid) {
			
		$data = $this->_tree($this->fetchAll(), $pid);
		$result = array($pid);
		foreach ($data as $v) {
			$result[] = $v['id'];
		}
		return $result;
	}

	public function getParentIds($id) {
		static $pids = array();		
		if ($pid = $this->getField('pid',"id=$id")) {
			$pids[] = $pid;
			$this->getParentIds($pid);
		}
		$pids[] = $id;
		return $pids;
	}
}