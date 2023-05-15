<?php

	define("IMAGE_JPEG_QUALITY","100");
	
	class class_image {
		var $img;
		var $ext;
		var $db;
		
		function take($path, $source_ext, $ext) {

			$this->ext = $ext;
			switch (strtolower($source_ext)) {
				case "gif":
					$this->img = imageCreateFromGif($path);
					break;
				case "jpg":
				case "jpeg":
					$this->img = imageCreateFromJpeg($path);
					break;
				case "png":
					$this->img = imageCreateFromPng($path);
					break;
				default:
					$this->image404();
					break;
			}

			if (!$this->img)
                die("Not found image at all.");
		}
		
		function create($width, $height, $ext) {
			$this->img = imageCreateTrueColor($width, $height);
			$this->ext = $ext;
		}
		
		function send_header($ext = false) {
			switch ($ext ? $ext : $this->ext) {
				case "gif":
					header("Content-Type: image/gif");
					break;
				case "jpg":
				case "jpeg":
					header("Content-Type: image/jpeg");
					break;
				case "png":
					header("Content-Type: image/png");
					break;
				case "js":
					header("Content-Type: text/javascript");
					break;
				default:
					$this->image404();
					break;
			}
		}
		
		function output() {
			if (!$this->img)
				return false;
//			$this->send_header();

			switch ($this->ext) {
				case "gif":
					imageGif ($this->img);
					break;
				case "jpg":
				case "jpeg":
					imageJpeg($this->img, "", IMAGE_JPEG_QUALITY);
					break;
				case "png":
					imagePng($this->img);
					break;
				default:
					$this->image404();
					break;
			}
		}
		
		function resize($width, $height) {
			if (!$this->img)
				return false;
			
			$sz = array("w" => imagesx($this->img), "h" => imagesy($this->img));
			$asp = array("w" => $width / $sz["w"], "h" => $height / $sz["h"]);
			if(($sz['w']<$width)&&($sz['h']<$height))
			{
				return true;
			}
			if ($asp["w"] > $asp["h"]) {
				$nsize["w"] = $width;
				$nsize["h"] = round($asp["h"] * $sz["h"]);
				$nsize["sw"] = $nsize["w"] / $asp["w"];
				$nsize["sh"] = $nsize["h"] / $asp["w"];
				$nsize["x"] = 0;
				$nsize["y"] = round(($sz["h"] - $nsize["sh"]) / 2);
			}else {
				$nsize["w"] = round($asp["w"] * $sz["w"]);
				$nsize["h"] = $height;
				$nsize["sw"] = $nsize["w"] / $asp["h"];
				$nsize["sh"] = $nsize["h"] / $asp["h"];
				$nsize["x"] = round(($sz["w"] - $nsize["sw"]) / 2);
				$nsize["y"] = 0;
			}
			
			$this->fast_resize($this->img, $this->img, 0, 0, $nsize["x"], $nsize["y"], $nsize["w"], $nsize["h"], $nsize["sw"], $nsize["sh"]);
		}
		
				function fast_resize(&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 3) {
					if (empty($src_image) || empty($dst_image) || $quality <= 0) { return false; }
					if ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h)) {
						$temp = imagecreatetruecolor ($dst_w * $quality + 1, $dst_h * $quality + 1);
						$dst_image = imagecreatetruecolor ($dst_w, $dst_h);
						imagecopyresized ($temp, $src_image, 0, 0, $src_x, $src_y, $dst_w * $quality + 1, $dst_h * $quality + 1, $src_w, $src_h);
						imagecopyresampled ($dst_image, $temp, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $dst_w * $quality, $dst_h * $quality);
						imagedestroy ($temp);
					} else {
						$dst_image = imagecreatetruecolor ($dst_w, $dst_h);
						imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
					}
					
					return true;
				}
		
		function image404() {
			header("HTTP/1.0 404 Not Found");
			die("Not found image.");
		}
	}
