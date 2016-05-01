<?php

class CategoryModel extends Model {

	public function getData(){
		$data = $this->fetchAll();
		return $this->_child($data);
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
}