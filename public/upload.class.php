<?php

class upload {

	public static function getPath($field) {
		
		$file = $_FILES[$field];
		$type = strrchr($file['name'], '.');
		$filename = 'public/upload/'.uniqid().$type;
		if (move_uploaded_file($file['tmp_name'], $filename)) {
			return $filename;
		}
	}
}