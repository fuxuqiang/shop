<?php

class goodsModel extends model {

	public function getData($type='goods', $cids=0) {
		if ($type=='goods') {
			$where = "g.recycle='no'";
		} elseif (is_array($cids)) {
			$where = "g.recycle='yes'";
		}
		
		if ($cids==0) {
			$where .= 'and g.cid=0';
		} elseif (is_array($cids)) {
			$where .= 'and g.cid in ('.implode(',', $cids).')';
		}

		$q = "SELECT `c`.`name` as `cname`, `g`.* FROM `goods` as `g` LEFT JOIN `category` as `c` ON `c`.`id`=`g`.`cid` WHERE $where";	
		$stmt = $this->db->query($q);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}