<?php

class attributeModel extends model {

	public function getData($cid) {

		$cids = D('category')->getParentIds($cid);
		
		$where = array('cid'=>$cids);

		$data = $this->fetchAll('*',$where);

		foreach ($data as $k => $v) {
			$data[$k]['def_val'] = explode(',', $v['def_val']);
		}

		return $data;
	}
}