<?php

class AttributeModel extends Model {

	public function getData($cid) {

		$cids = D('Category')->getParentIds($cid);
		
		$where = array('cid'=>$cids);

		$data = $this->fetchAll('*',$where);

		foreach ($data as $k => $v) {
			$data[$k]['def_val'] = explode(',', $v['def_val']);
		}

		return $data;
	}
}