<?php

abstract class commonController extends controller{
	public function __construct() {
		if (!isset($_SESSION['admin'])) {
			header('location:'.U('admin/login'));
		}
	}
}