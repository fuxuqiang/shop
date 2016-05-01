<?php

class GoodsModel extends Model {
	
	public function getBest() {
		$map = array('recommend'=>'yes', 'on_sale'=>'yes', 'recycle'=>'no');
		return $this->fetchAll('*', $map);
	}
}