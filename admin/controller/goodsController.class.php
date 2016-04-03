<?php

class goodsController extends commonController {

	public function index() {

		$cid = $this->getParam('cid',-1);
		
		$category = D('category');
		$cids = ($cid>0)? $category->getSubIds($cid) : $cid;

		$data['category'] = $category->getData();
		$data['goods'] = D('goods')->getData('goods',$cids);
		
		$title = TITLE.'商品列表';
		require TEMPLATE;
	}


	public function add() {

		if (!empty($_POST)) {
			
			$data = I($_POST);

			if (empty($_FILES['pic']['name'])) {
				$data['thumb'] = 'public/upload/preview.jpg';
			} else {				
				$data['thumb'] = upload::getPath('pic');
			}

			if (isset($data['attr'])) {
				$attr = $data['attr'];
				unset($data['attr']);

				if ($id = M('goods')->insert($data)) {
					if(D('goodsAttr')->saveData($attr, $id)){
						$this->redirect(U('admin/goods').'?cid='.$data['cid']);
					}
				}
			}

			if (M('goods')->insert($data)) {
				$this->redirect(U('admin/goods').'?cid='.$data['cid']);
			}			
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


	public function change() {

		$id = $_POST['id'];
		$name = $_POST['name'];
		$value = $_POST['value'];

		if (D('goods')->change($id, $name, $value)) {
			$this->ajaxReturn(true);
		}
	}


	public function edit() {

		$id = $_GET['id'];

		if (!empty($_POST)) {
			
			$data = I($_POST);

			if (!empty($_FILES['pic']['name'])) {
				$data['thumb'] = D('goods')->handleThumb($id);
			}

			if (isset($data['attr'])) {
				
				$attr = $data['attr'];
				unset($data['attr']);
				
				if (M('goods')->update($data)) {
					if(D('goodsAttr')->updateData($attr, $id)){
						$this->redirect(U('admin/goods').'?cid='.$data['cid']);
					}
				}
			}

			if (M('goods')->insert($data)) {
				$this->redirect(U('admin/goods').'?cid='.$data['cid']);
			}
		}

		$cid = $_GET['cid'];

		$data['category'] = D('category')->getData();
		$data['goods'] = M('goods')->fetch('*',"id=$id");
		$data['attribute'] = D('goodsAttr')->getData($cid, $id);
		
		$title = TITLE.'商品修改';
		require TEMPLATE;
	}
}