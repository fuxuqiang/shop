<?php

class goodsModel extends model {

	public function getData($type='goods', $cids=0) {
		if ($type=='goods') {
			$where = "g.recycle='no'";
		} elseif {
			$where = "g.recycle='yes'";
		}
		
	}
}