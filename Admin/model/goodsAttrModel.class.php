<?php

class goodsAttrModel extends model {

	public function addData($data, $gid) {
		foreach ($data as $k => $v) {
			if(!$this->insert(array('aid'=>$k, 'value'=>$v, 'gid'=>$gid))) {
				return false;
			}
		}
		return true;
	}
	

	public function updateData($data, $gid) {

		foreach ($data as $k => $v) {

			if ($id = $this->getField('id', "aid=$k and gid=$gid")) {

				if(!$this->update(array('aid'=>$k, 'value'=>$v, 'gid'=>$gid), "id=$id")) {
					return false;
				}

			} else {

				if (!$this->insert(array('aid'=>$k, 'value'=>$v, 'gid'=>$gid))) {
					return false;
				}
			}
			
		}
		return true;
	}


	public function getData($cid, $gid) {

		$cids = D('category')->getParentIds($cid);

		$where = implode(',', $cids);
		
		$q = "SELECT `ga`.`id`, `ga`.`value`, `a`.`id` AS `aid`, `a`.`name`, `a`.`def_val` 
			FROM `attribute` AS `a` 
			LEFT JOIN (SELECT * FROM `goodsAttr` WHERE `gid`=$gid) as `ga` 
			ON `ga`.`aid`=`a`.`id` 
			WHERE `a`.`cid` IN ($where)";

		$data = $this->query($q);

		foreach ($data as $k => $v) {
			$data[$k]['def_val'] = explode(',', $v['def_val']);
		}

		return $data;
	}
}