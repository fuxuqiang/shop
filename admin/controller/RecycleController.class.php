<?php

class RecycleController extends CommonController {

	public function index() {
		
		$data = D('Goods')->adminData('recycle', -1);

		$title = TITLE.'商品回收站';
		require TEMPLATE;
	}

	public function recover() {
		if(D('Goods')->change($_POST['id'], 'recycle', 'no')){
			$this->ajaxReturn(true);
		}
	}

	public function del() {
		$id = $_POST['id'];
		if (D('Goods')->delThumb($id) && M('Goods')->delete("id=$id") && M('GoodsAttr')->delete("gid=$id")) {
			$this->ajaxReturn(true);
		}
	}
}
