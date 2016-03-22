<?php

class categoryController extends commonController {

	public function index() {
		$data = D('category')->getData();
		$title = TITLE.'商品分类';
		require TEMPLATE;
	}


	public function add() {
		
		if (!empty($_POST)) {

			$data['name'] = $_POST['name'];
			$data['pid'] = $_POST['pid'];

			$id = M('category')->insert($data);

			if ($id && isset($_POST['return'])) {
				$this->ajaxReturn(true,'',U('admin/category'));
			} elseif ($id) {
				$this->ajaxReturn(true,'','?tip=1&id='.$id);
			}	
		}

		$tip = $this->getParam('tip',0);
		$id = $this->getParam('id',0);
		$data = D('category')->getData();
		$title = TITLE.'分类添加';

		require TEMPLATE;
	}


	public function del() {

		$id = $_POST['id'];

		$model = M('category');

		if ($model->fetch('*',"pid=$id")) {
			$this->ajaxReturn(false, '删除失败，只允许删除最底层分类');
		} 
			
		if ($model->delete("id=$id") && M('attribute')->delete("cid=$id")) {
			$this->ajaxReturn(true);
		}
	}


	public function edit() {

		if (!empty($_POST)) {
			
			$data['id'] = $_POST['id'];
			$data['name'] = $_POST['name'];
			$data['pid'] = $_POST['pid'];

			$model = D('category');

			if (in_array($data['pid'], $model->getSubIds($data['id']))) {
				$this->ajaxReturn(false, '不允许将当前分类及其子类作为父分类');
			}

			$res = $model->update($data);

			if ($res && isset($_POST['return'])) {
				$this->ajaxReturn(true,'',U('admin/category'));
			} elseif ($res) {
				$this->ajaxReturn(true,'','?tip=1&id='.$data['id']);
			}
		}
			
		$tip = $this->getParam('tip',0);
		$id = $_GET['id'];

		$model = D('category');

		$category = $model->fetch('name,pid',"id=$id");
		$data = $model->getData();

		$title = TITLE.'分类修改';
		require TEMPLATE;
	}
}