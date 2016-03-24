<?php

class upload {

	public static function getPath($field) {
		if ($_FILES[$field]['error']==4) {
			return 'public/upload/preview.jpg';
		}
		
		$file = $_FILES[$field];
		$type = strrchr($file['name'], '.');
		$filename = 'public/upload/'.uniqid().$type;
		if (move_uploaded_file($file['tmp_name'], $filename)) {
			return $filename;
		}
	}
}