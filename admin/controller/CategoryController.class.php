<?php

class CategoryController extends CommonController {

	public function index() {
		$data = D('Category')->getData();
		$title = TITLE.'商品分类';
		require TEMPLATE;
	}


	public function add() {
		
		if (!empty($_POST)) {

			$data['name'] = $_POST['name'];
			$data['pid'] = $_POST['pid'];

			$id = M('Category')->insert($data);

			if ($id && isset($_POST['return'])) {
				$this->ajaxReturn(true,'',U('admin/Category'));
			} elseif ($id) {
				$this->ajaxReturn(true,'','?tip=1&id='.$id);
			}	
		}

		$tip = $this->getParam('tip',0);
		$id = $this->getParam('id',0);
		$data = D('Category')->getData();
		$title = TITLE.'分类添加';

		require TEMPLATE;
	}


	public function del() {

		$id = $_POST['id'];

		$model = M('Category');

		if ($model->fetch('*',"pid=$id")) {
			$this->ajaxReturn(false, '删除失败，只允许删除最底层分类');
		} 
			
		if ($model->delete("id=$id") && M('Attribute')->delete("cid=$id")) {
			$this->ajaxReturn(true);
		}
	}


	public function edit() {

		$id = $_GET['id'];

		if (!empty($_POST)) {
			
			$data['name'] = $_POST['name'];
			$data['pid'] = $_POST['pid'];

			$model = D('Category');

			if (in_array($data['pid'], $model->getSubIds($id))) {
				$this->ajaxReturn(false, '不允许将当前分类及其子类作为父分类');
			}

			$res = $model->update($data, "id=$id");

			if ($res && isset($_POST['return'])) {
				$this->ajaxReturn(true,'',U('admin/Category'));
			} elseif ($res) {
				$this->ajaxReturn(true,'','?tip=1&id='.$id);
			}
		}
			
		$tip = $this->getParam('tip',0);

		$model = D('Category');

		$category = $model->fetch('name,pid',"id=$id");
		$data = $model->getData();

		$title = TITLE.'分类修改';
		require TEMPLATE;
	}
}