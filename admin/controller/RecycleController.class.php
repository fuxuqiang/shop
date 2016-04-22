<?php

class RecycleController extends CommonController {

	public function index() {
		
		$data = D('Goods')->getData('recycle', -1);

		$title = TITLE.'商品回收站';
		require TEMPLATE;
	}
}
