<?php

class Image {

	public static function getPath($field) {
		
		$img = $_FILES[$field];

		list($width, $height) = getimagesize($img['tmp_name']);

		$maxwidth = $maxheight = 220;

		if ($width/$height > $maxwidth/$maxheight) {
			$newwidth = $maxwidth;
			$newheight = round($newwidth*$height/$width);
		} else {
			$newheight = $maxheight;
			$newwidth = round($newheight*$width/$height);
		}

		$thumb = imagecreatetruecolor($newwidth, $newheight);

		switch ($img['type']) {
			case 'image/jpeg':
				$create = 'imagecreatefromjpeg';
				$save = 'imagejpeg';
				break;
			case 'image/png':
				$create = 'imagecreatefrompng';
				$save = 'imagepng';
				break;
		}

		$source = $create($img['tmp_name']);

		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		$type = strrchr($img['name'], '.');
		$img_path = 'public/upload/'.uniqid().$type;
		
		($save=='imagejpeg')? $save($thumb, $img_path, 100):$save($thumb, $img_path);

		return $img_path;
	}
}