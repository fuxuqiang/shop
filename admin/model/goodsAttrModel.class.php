<?php

class goodsAttrModel extends model {
	public function addData($data, $gid) {
		foreach ($data as $k => $v) {
			if(!$this->insert(array('aid'=>$k, 'avalue'=>$v, 'gid'=>$gid))) {
				return false;
			}
		}
		return true;
	}
}