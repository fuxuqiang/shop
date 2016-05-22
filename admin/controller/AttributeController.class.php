<?php

class AttributeController extends CommonController {

	public function index() {

		$cid = $this->getParam('cid',0);

		$category = D('Category')->getData();

		if ($cid==0 && isset($category[0]['id'])) {
			$cid = $category[0]['id'];
		}

		$attribute = M('Attribute')->where("cid=$cid")->fetchAll();

		$title = TITLE.'商品属性';
		require TEMPLATE;
	}


	public function add() {

		$cid = $_GET['cid'];

		if (!empty($_POST)) {
			
			$data = I($_POST);

			if (M('Attribute')->insert($data)) {
				$this->redirect(U('admin/Attribute?cid='.$cid));
			}
		}

		$title = TITLE.'属性添加';
		require TEMPLATE;
	}


	public function del() {

		$id = $_POST['id'];
			
		if (M('Attribute')->delete("id=$id")) {
			$this->ajaxReturn(true);
		}
	}


	public function edit() {

		$id = $_GET['id'];
		
		if (!empty($_POST)) {

			$data = I($_POST);

			if (M('Attribute')->where("id=$id")->update($data)) {
				$this->redirect(U('admin/Attribute'));
			}
		}

		$cid = $_GET['cid'];

		$attribute = M('Attribute')->where("id=$id")->fetch();

		$title = TITLE.'属性修改';
		require TEMPLATE;
	}
}