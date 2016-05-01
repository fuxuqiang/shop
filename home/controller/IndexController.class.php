<?php

class IndexController {
	public function Index() {
		$category = D('Category')->getData();
		$best = D('Goods')->getBest();
		require TEMPLATE;
	}
}