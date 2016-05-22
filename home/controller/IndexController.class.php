<?php

class IndexController extends Controller{

	public function Index() {
		$category = D('Category')->slideData();
		$best = D('Goods')->getBest();
		require TEMPLATE;
	}

	public function find() {

		$cid = $this->getParam('cid',0);

		if ($cids = D('Category')->getSubIds($cid)) {
			$data['categorys'] = D('Category')->getData($cid);
			//$data['categorys'] = M('Category')->where(array('id'=>$cids))->fetchAll();
		}
		
		$title = TITLE.'商品列表';
		require TEMPLATE;
	}
}
