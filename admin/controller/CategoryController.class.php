<?php
/**
* 后台分类控制器类
*/
class CategoryController extends CommonController {

	// 显示分类首页
	public function index() {
		$data = D('Category')->getData();
		$title = TITLE.'商品分类';
		require TEMPLATE;
	}

	// 分类添加
	public function add() {
		
		if (!empty($_POST)) {

			$data['name'] = htmlspecialchars($_POST['name']);
			$data['pid'] = htmlspecialchars($_POST['pid']);

			$id = M('Category')->insert($data);

			if ($id && isset($_POST['return'])) {
				$this->ajaxReturn(true, '', U('admin/Category'));
			} elseif ($id) {
				$this->ajaxReturn(true, '', '?tip=1&id='.$id);
			}	
		}
		
		// 显示分类添加页面
		$tip = $this->getParam('tip',0);
		$id = $this->getParam('id',0);
		$data = D('Category')->getData();
		$title = TITLE.'分类添加';

		require TEMPLATE;
	}

	// 删除分类
	public function del() {

		$id = $_POST['id'];

		$Category = M('Category');

		if ($Category->where("pid=$id")->fetch()) {
			$this->ajaxReturn(false, '删除失败，只允许删除最底层分类');
		} 
			
		if ($Category->delete("id=$id") && M('Attribute')->delete("cid=$id")) {
			$this->ajaxReturn(true);
		}
	}

	// 修改分类
	public function edit() {

		$id = $_GET['id'];

		if (!empty($_POST)) {
			
			$data['name'] = htmlspecialchars($_POST['name']);
			$data['pid'] = htmlspecialchars($_POST['pid']);

			$Category = D('Category');

			$sub_ids = $Category->getSubIds($id);

			if (in_array($data['pid'], $sub_ids) || $data['pid']==$id) {
				$this->ajaxReturn(false, '不允许将当前分类及其子类作为父分类');
			}

			$res = $Category->where("id=$id")->update($data);

			if ($res && isset($_POST['return'])) {
				$this->ajaxReturn(true, '', U('admin/Category'));
			} elseif ($res) {
				$this->ajaxReturn(true, '', '?tip=1&id='.$id);
			}
		}
		
		// 显示分类修改页面
		$tip = $this->getParam('tip',0);

		$Category = D('Category');

		$data['category'] = $Category->where("id=$id")->fetch('name,pid');
		$data['categories'] = $Category->getData();
		$title = TITLE.'分类修改';
		
		require TEMPLATE;
	}
}
