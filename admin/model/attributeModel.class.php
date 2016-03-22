<?php

class attributeModel extends model {

	public function getData($where) {

		$data = $this->fetchAll('*',$where);

		foreach ($data as $k => $v) {
			$data[$k]['def_val'] = explode(',', $v['def_val']);
		}

		return $data;
	}
}