<?php

class AttributeModel extends Model {

	public function getData($cid) {

		$cids = D('Category')->getParentIds($cid);

		$data = $this->where(array('cid'=>$cids))->fetchAll();

		foreach ($data as $k => $v) {
			$data[$k]['def_val'] = explode(',', $v['def_val']);
		}

		return $data;
	}
}