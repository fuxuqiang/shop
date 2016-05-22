<?php

class GoodsModel extends Model {

	public function adminData($type='goods', $cids=0) {
		if ($type=='goods') {
			$where = "g.recycle='no'";
		} elseif ($type=='recycle') {
			$where = "g.recycle='yes'";
		}
		
		if (is_array($cids)) {
			$where .= 'AND g.cid in ('.implode(',', $cids).')';
		} elseif ($cids!=-1) {
			$where .= "AND g.cid=$cids";
		}
	
		$q = "SELECT `c`.`name` as `cname`, `g`.* FROM `goods` as `g` LEFT JOIN `category` as `c` ON `c`.`id`=`g`.`cid` WHERE $where";
			
		return $this->query($q);
	}


	public function homeData() {
		
	}


	public function change($id, $name, $value) {
		if ($this->db->query("UPDATE `goods` SET `$name`='$value' WHERE `id`=$id")) {
			return true;
		}
	}


	public function delThumb($id) {
		$thumb = $this->where("id=$id")->getField('thumb');
		if ($thumb!='public/upload/preview.jpg' && is_file($thumb)) {
			unlink($thumb);
		}
		return true;
	}


	public function getBest() {
		$map = array('recommend'=>'yes', 'on_sale'=>'yes', 'recycle'=>'no');
		return $this->where($map)->fetchAll();
	}
}