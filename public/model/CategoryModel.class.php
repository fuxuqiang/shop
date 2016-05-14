<?php

class CategoryModel extends Model{
	
	public function adminData() {
		$rst = array();
		$this->_tree($this->fetchAll(), $rst);
		return $rst;
	}

	public function homeData() {
		$data = $this->fetchAll();
		return $this->_child($data);
	}

	public function getSubIds($pid) {			
		$this->_tree($this->fetchAll(), $data, $pid);
		$result = array();
		foreach ($data as $v) {
			$result[] = $v['id'];
		}
		return $result;
	}

	public function getParentIds($id) {
		static $pids = array();		
		if ($pid = $this->where("id=$id")->getField('pid')) {
			$pids[] = $pid;
			$this->getParentIds($pid);
		}
		$pids[] = $id;
		return $pids;
	}

	private function _child($data, $pid=0) {
		$list = array();
		foreach ($data as $v) {
			if ($v['pid']==$pid) {
				$child = $this->_child($data, $v['id']);
				$v['child'] = $child;
				$list[] = $v;
			}
		}
		return $list;
	}

	private function _tree($data, &$rst, $pid=0, $level=0) {
		foreach ($data as $v) {
			if ($v['pid']==$pid) {
				$v['level'] = $level;
				$rst[] = $v;
				$this->_tree($data, $rst, $v['id'], $level+1);
			}
		}
	}
}