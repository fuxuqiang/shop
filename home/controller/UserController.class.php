<?php

class UserController {
	public function register() {
		if (!empty($_POST)) {
			
		}

		$captcha = U('home/User/captcha');
		require VIEW;
	}

	public function captcha() {
		Captcha::create();
	}
}