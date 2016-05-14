<?php

class GoodsAttrModel extends Model {

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

			if ($id = $this->where("aid=$k and gid=$gid")->getField('id')) {

				if(!$this->where("id=$id")->update(array('aid'=>$k, 'value'=>$v, 'gid'=>$gid))) {
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

		$cids = D('Category')->getParentIds($cid);

		$where = implode(',', $cids);
		
		$q = "SELECT `ga`.`id`, `ga`.`value`, `a`.`id` AS `aid`, `a`.`name`, `a`.`def_val` 
			FROM `attribute` AS `a` 
			LEFT JOIN (SELECT * FROM `goods_attr` WHERE `gid`=$gid) as `ga` 
			ON `ga`.`aid`=`a`.`id` 
			WHERE `a`.`cid` IN ($where)";

		$data = $this->query($q);

		foreach ($data as $k => $v) {
			$data[$k]['def_val'] = explode(',', $v['def_val']);
		}

		return $data;
	}
}