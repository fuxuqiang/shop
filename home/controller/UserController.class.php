<?php

class UserController extends Controller {

	public function index() {

	}


	public function register() {

		if (!empty($_POST)) {

			$info = I($_POST);

			if ($info['captcha']==$_SESSION['captcha']) {

				unset($_SESSION['captcha']);

				if (M('User')->getField('id', array('name'=>$info['name']))) {

					$this->ajaxReturn(false, '用户名已经存在');
					
				} else {

					$data['name'] = $info['name'];
					$data['pwd'] = md5($info['pwd']);

					if ($id = M('User')->insert($data)) {
						$_SESSION['user'] = $info['name'];
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

			if ($_POST['captcha']==$_SESSION['captcha']) {

				unset($_SESSION['captcha']);

				if (md5($_POST['pwd'])==M('User')->getField('pwd', array('name'=>$_POST['name']))) {

					$_SESSION['user'] = $info['name'];
					$this->ajaxReturn(true, '', ROOT);
					
				} else {
					$this->ajaxReturn(false, '用户名或密码错误');
				}
				
			} else {
				$this->ajaxReturn(false, '验证码输入有误');
			}
		}

		$captcha = U('home/User/captcha');
		require VIEW;
	}


	public function logout() {
		setcookie(session_name(), '', time()-1);
		session_destroy();
		$this->redirect(ROOT);
	}
}
