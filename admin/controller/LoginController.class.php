<?php
/**
* 后台登陆控制器类
*/
class LoginController extends Controller{

	// 显示登陆页面及实现登陆
	public function index() {
		// 根据POST请求验证登陆
		if (!empty($_POST)) {
			if ($_POST['captcha']==$_SESSION['captcha']) {
				unset($_SESSION['captcha']);
				if ($_POST['name']=='admin' && $_POST['pwd']=='admin') {
					$_SESSION['admin'] = 'admin';
					$this->ajaxReturn(true, '', U('admin'));
				} else {
					$this->ajaxReturn(false, '用户名或密码错误');
				}				
			} else {
				$this->ajaxReturn(false, '验证码输入有误');
			}
		}
		// 显示登陆页面
		$captcha = U('admin/Login/captcha');
		require VIEW;
	}

	// 显示验证码
	public function captcha() {
		Tool::captcha();
	}

	// 退出登陆
	public function logout() {
		//unset($_SESSION);
		setcookie(session_name(), '', time()-1);
		session_destroy();
		$this->redirect(U('admin/Login'));
	}
}
