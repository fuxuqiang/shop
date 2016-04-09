<?php

class image {

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

		$source = imagecreatefromjpeg($img['tmp_name']);

		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		//$type = strrchr($file['name'], '.');
		$img_name = 'public/upload/'.uniqid().'.jpg';
		
		imagejpeg($thumb, $img_name, 100);

		return $img_name;
	}
}