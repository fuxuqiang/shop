<?php
/**
 * 工具类
 * 
 * 封装了缩略图上传，验证码图片显示等方法
 */
class Tool {

	// 生成验证码并显示在图片中
	public static function captcha() {
		// 图片参数及字体参数
		$img_w = 100;
		$img_h = 40;
		$char_len = 4;
		$fontSize = 20;
		$font = './public/UbuntuMono-RI.ttf';
		// 生成验证码
		$char = array_merge(range('A','Z'), range('a','z'), range(1,9));
		$rand_keys = array_rand($char, $char_len);
		shuffle($rand_keys);
		$code = '';
		foreach($rand_keys as $v){
			$code.=$char[$v];
		}
		// 赋值给SESSION
		$_SESSION['captcha'] = strtolower($code);
		// 生成画布并设置背景色
		$img = imagecreatetruecolor($img_w, $img_h);
		$img_color = imagecolorallocate($img, 0xcc, 0xcc, 0xcc);
		imagefill($img, 0, 0, $img_color);
		// 随机字体颜色
		$str_color = imagecolorallocate($img, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
		// 将码值写入画布
		imagettftext(
			$img, 
			$fontSize, 
			0,//mt_rand(-10,10), 
			mt_rand(1, $img_w/$char_len), 
			mt_rand($img_h*0.8, $img_h*0.9), 
			$str_color, 
			$font, 
			$code
		);
		// 显示图片
		//ob_clean();
		header('content-type:image/png');
		imagepng($img);
		// 销毁
		imagedestroy($img);
	}

	// 
	public static function getThumb($field) {
		
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