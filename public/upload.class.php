<?php

class upload {

	public static function getPath() {
		if (empty($_FILE)) {
			exit('没有文件被上传');
		}
		foreach ($_FILE as $k => $v) {
			$type = strrchr($v['name'], '.');
			$filename = 'public/upload/'.uniqid().$type;
			if (move_uploaded_file($_v['tmp_name'], $filename)) {
				$path[$k] = $filename;
			}
		}
		return $path;
	}
}