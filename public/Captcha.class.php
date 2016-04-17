<?php

class Captcha {

	public static function create() {
		
		$img_w = 100;
		$img_h = 40;
		$char_len = 4;
		$fontSize = 20;
		$font = './public/UbuntuMono-RI.ttf';

		$char = array_merge(range('A','Z'), range('a','z'), range(1,9));
		$rand_keys = array_rand($char, $char_len);
		shuffle($rand_keys);
		$code = '';
		foreach($rand_keys as $v){
			$code.=$char[$v];
		}
		
		$_SESSION['captcha'] = strtolower($code);

		$img = imagecreatetruecolor($img_w, $img_h);
		$img_color = imagecolorallocate($img, 0xcc, 0xcc, 0xcc);
		imagefill($img, 0, 0, $img_color);

		$str_color = imagecolorallocate($img, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));

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

		//ob_clean();
		header('content-type:image/png');
		imagepng($img);

		imagedestroy($img);
	}
}