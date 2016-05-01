<?php

class IndexController {
	public function Index() {
		$category = D('Category')->getData();
		require TEMPLATE;
	}
}