<?php

class attributeController extends commonController {

	public function index() {

		$cid = $this->getParam('cid',0);

		$category = D('category')->getData();

		if ($cid==0 && isset($category[0]['id'])) {
			$cid = $category[0]['id'];
		}

		$attribute = M('attribute')->fetchAll('*',"cid=$cid");

		$title = TITLE.'商品属性';
		require TEMPLATE;
	}


	public function add() {

		if (!empty($_POST)) {
			
			$data = I($_POST);

			if (M('attribute')->insert($data)) {
				header('location:'.U('admin/attribute'));
				die;
			}
		}

		$cid = $_GET['cid'];

		$title = TITLE.'属性添加';
		require TEMPLATE;
	}


	public function del() {

		$id = $_POST['id'];
			
		if (M('attribute')->delete("id=$id")) {
			$this->ajaxReturn(true);
		}
	}


	public function edit() {
		
		if (!empty($_POST)) {

			$data = I($_POST);

			if (M('attribute')->update($data)) {
				header('location:'.U('admin/attribute'));
				die;
			}
		}

		$id = $_GET['id'];
		$cid = $_GET['cid'];

		$attribute = M('attribute')->fetch('*',"id=$id");

		$title = TITLE.'属性修改';
		require TEMPLATE;
	}
}