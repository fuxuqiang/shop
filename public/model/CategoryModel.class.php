<?php
/**
 * 分类控制器类
 */
class CategoryModel extends Model{
	
	/**
	 * 查询层级分类数据
	 *
	 * @param int $pid 父分类ID
	 * @return array
	 */
	public function getData($pid=0) {
		$rst = array();
		$this->_tree($this->fetchAll(), $rst, $pid);
		return $rst;
	}

	public function slideData() {
		$data = $this->fetchAll();
		return $this->_child($data);
	}

	public function getSubIds($pid) {
		$data = array();
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

	/**
	 * 给分类数据添加层级
	 *
	 * @param array $data 待处理分类数据
	 * @param array $rst 添加层级后分类数据
	 * @param int $pid 起始分类ID
	 * @param int $level 起始层级
	 * @return null
	 */
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
