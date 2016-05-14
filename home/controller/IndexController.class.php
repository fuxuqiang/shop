<?php

class IndexController extends Controller{

	public function Index() {
		$category = D('Category')->homeData();
		$best = D('Goods')->getBest();
		require TEMPLATE;
	}

	public function find() {

		$cid = $this->getParam('cid',0);

		$data['goods'] = M('Goods')->where(array('cid'=>$cid))->fetchAll();
		if ($cids = D('Category')->getSubIds($cid)) {
			$data['categorys'] = M('Category')->where(array('id'=>$cids))->getField('name',true);
		}
		
		$title = TITLE.'商品列表';
		require TEMPLATE;
	}
}
