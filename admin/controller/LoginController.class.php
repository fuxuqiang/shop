<?php

class LoginController extends controller{

	public function index() {

		if (!empty($_POST)) {

			if ($_POST['captcha']==$_SESSION['captcha']) {

				if ($_POST['username']=='admin' && $_POST['password']=='admin') {
					$_SESSION['admin'] = 'admin';
					$this->ajaxReturn(true, '', U('admin'));
				} else {
					$this->ajaxReturn(false, '用户名或密码错误');
				}
				
			} else {
				$this->ajaxReturn(false, '验证码输入有误');
			}
		}

		$captchaUrl = U('admin/Login/captcha');
		require VIEW;		
	}


	public function captcha() {
		captcha::create();
	}


	public function logout() {
		unset($_SESSION);
		setcookie(session_name(), '', time()-1);
		session_destroy();
		$this->redirect(U('admin/login'));
	}
}