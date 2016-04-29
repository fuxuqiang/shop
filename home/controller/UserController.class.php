<?php

class UserController extends Controller {

	public function register() {

		if (!empty($_POST)) {

			$info = I($_POST);

			if ($info['captcha']==$_SESSION['captcha']) {

				if (M('User')->getField('id', array('name'=>$info['name']))) {

					$this->ajaxReturn(false, '用户名已经存在');
					
				} else {

					$data['name'] = $info['name'];
					$data['pwd'] = md5($info['pwd']);

					if ($id = M('User')->insert($data)) {
						$_SESSION['user'] = array('id'=>$id, 'name'=>$info['name']);
						$this->ajaxReturn(true, '注册成功，正在跳转');
					}
				}
				
			} else {
				$this->ajaxReturn(false, '验证码输入有误');
			}
		}

		$captcha = U('home/User/captcha');
		require VIEW;
	}


	public function captcha() {
		Captcha::create();
	}


	public function login() {
		if (!empty($_POST)) {
			# code...
		}

		$captcha = U('home/User/captcha');
		require VIEW;
	}


	public function logout() {
		
	}
}
