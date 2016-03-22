<?php

class goodsController extends commonController {

	public function index() {
		$cid = $this->getParam('cid',-1);
		$category = D('category')->getData();

		$title = TITLE.'商品列表';
		require TEMPLATE;
	}


	public function add() {

		if (!empty($_POST)) {
			
		}

		$tip = $this->getParam('tip',0);
		$id = $this->getParam('id',0);

		$cid = $_GET['cid'];
		$cid<0 && $cid = 0;

		$category = D('category')->getData();
		$attribute = D('attribute')->getData("cid=$cid");

		$title = TITLE.'商品添加';
		require TEMPLATE;
	}
}