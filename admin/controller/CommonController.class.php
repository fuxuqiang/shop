<?php

abstract class CommonController extends Controller{
	public function __construct() {
		if (!isset($_SESSION['admin'])) {
			$this->redirect(U('admin/Login'));
		}
	}
}