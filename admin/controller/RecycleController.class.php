<?php

class RecycleController extends CommonController {

	public function index() {
		
		$data = D('Goods')->getData('recycle', -1);

		$title = TITLE.'商品回收站';
		require TEMPLATE;
	}

	public function recover() {
		$id = $_POST['id'];
		if(D('Goods')->change($id, 'recycle', 'no')){
			$this->ajaxReturn(true);
		}
	}

	public function del() {
		$id = $_POST['id'];
		if (M('Goods')->delete("id=$id")) {
			$this->ajaxReturn(true);
		}
	}
}
