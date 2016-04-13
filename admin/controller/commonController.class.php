<?php

abstract class commonController extends controller{
	public function __construct() {
		if (!isset($_SESSION['admin'])) {
			$this->redirect(U('admin/login'));
		}
	}
}