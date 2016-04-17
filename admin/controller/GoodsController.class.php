<?php

class GoodsController extends CommonController {

	public function index() {

		$cid = $this->getParam('cid',-1);
		
		$category = D('Category');
		$cids = ($cid>0)? $category->getSubIds($cid) : $cid;

		$data['category'] = $category->getData();
		$data['goods'] = D('Goods')->getData('goods',$cids);
		
		$title = TITLE.'商品列表';
		require TEMPLATE;
	}


	public function add() {

		if (!empty($_POST)) {
			
			$data = I($_POST);

			if (empty($_FILES['pic']['name'])) {
				$data['thumb'] = 'public/upload/preview.jpg';
			} else {				
				$data['thumb'] = image::getPath('pic');
			}

			if (isset($data['attr'])) {
				$attr = $data['attr'];
				unset($data['attr']);

				if ($id = M('goods')->insert($data)) {
					if(D('GoodsAttr')->addData($attr, $id)){
						$this->redirect(U('admin/Goods').'?cid='.$data['cid']);
					}
				}
			}

			if (M('Goods')->insert($data)) {
				$this->redirect(U('admin/Goods').'?cid='.$data['cid']);
			}			
		}

		$tip = $this->getParam('tip',0);
		$id = $this->getParam('id',0);

		$cid = $_GET['cid'];
		$cid<0 && $cid = 0;

		$category = D('Category')->getData();
		$attribute = D('Attribute')->getData($cid);

		$title = TITLE.'商品添加';
		require TEMPLATE;
	}


	public function change() {

		$id = $_POST['id'];
		$name = $_POST['name'];
		$value = $_POST['value'];

		if (D('Goods')->change($id, $name, $value)) {
			$this->ajaxReturn(true);
		}
	}


	public function edit() {

		$id = $_GET['id'];

		if (!empty($_POST)) {
			
			$data = I($_POST);

			if (!empty($_FILES['pic']['name'])) {
				$data['thumb'] = D('Goods')->handleThumb($id);
			}

			if (isset($data['attr'])) {
				
				$attr = $data['attr'];
				unset($data['attr']);
				
				if (M('Goods')->update($data, "id=$id")) {
					if(D('GoodsAttr')->updateData($attr, $id)){
						$this->redirect(U('admin/Goods').'?cid='.$data['cid']);
					}
				}
			}

			if (M('Goods')->insert($data)) {
				$this->redirect(U('admin/Goods').'?cid='.$data['cid']);
			}
		}

		$cid = $_GET['cid'];

		$data['category'] = D('Category')->getData();
		$data['goods'] = M('Goods')->fetch('*',"id=$id");
		$data['attribute'] = D('GoodsAttr')->getData($cid, $id);
		
		$title = TITLE.'商品修改';
		require TEMPLATE;
	}
}