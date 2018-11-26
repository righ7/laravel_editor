<?php

namespace App\Helpers;

use Validator;
use App\Application\Alibc\Sdk\AlibcMediaHelper;

/**
 * 通用功能
 * 使用方法
 * use App\Helpers\FunctionsHelper;
 * RandomStringHelper::Validator('');
 */
class FunctionsHelper
{
	/***
	 * 通过laravel验证规则进行验证
	 * @param $request
	 * @param $rules
	 * @return boolean 返回是否通过验证
	 */
	public static function Validator($request, $rules)
	{
		$ruleArray = array();
		if (is_array($rules)) {
			$ruleArray = $rules;
		} else {
			$ruleArray[] = $rules;
		}

		//验证规则
		$validator = Validator::make($request->all(), $ruleArray);
		if ($validator->fails()) {
			return false;
		}
		return true;
	}
	/// <summary>
	/// 获取参数值
	/// </summary>
	public static function GetParamsValue($key)
	{
		if (!isset($_POST[$key])) {
			if (!isset($_GET[$key]))
				return '';
			else
				return self::unicode2utf8($_GET[$key]);
//				return base64_decode($_GET[$key]);
		}
				return self::unicode2utf8($_POST[$key]);
//		return base64_decode($_POST[$key]);
	}

	/**
	 * 将UNICODE编码后的内容进行解码
	 * @param string $str
	 * @return string 中文内容
	 */
	static function unicode2utf8($str)
	{
		if (!$str) return $str;
		$decode = json_decode($str);
		if ($decode) return $decode;
		$str = '["' . $str . '"]';
		$decode = json_decode($str);
		if (count($decode) == 1) {
			return $decode[0];
		}
		return $str;
	}

	/**
	 * 获取IP
	 */
	static function GetIP()
	{
		if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
			$cip = $_SERVER["HTTP_CLIENT_IP"];
		} elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif (!empty($_SERVER["REMOTE_ADDR"])) {
			$cip = $_SERVER["REMOTE_ADDR"];
		} else {
			$cip = "0.0.0.0";
		}
		return $cip;
	}

	/**
	 * 将上传的base64字符串转换成图片报错
	 * @param string $base64Str
	 * @param string $pApplicationName   如：User    或者  User/Avatar
	 * @return boolean|array filename文件名称, path不带文件名的路径/结尾, width宽, height高, scale比例
	*/
	static function UploadImageByBase64($base64Str, $pApplicationName)
	{
		$base64Str = str_replace(" ","+",$base64Str);
		/*
	$path = "uploads/" . rtrim($pApplicationName, '/') . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';          //上传文件保存的路径，会自动到根目录的public文件夹下
	self::createFolders($path);
	$fileName = date('YmdHis') . "_" . rand(100, 999) . '.jpg';

	if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64Str, $result)) {
		$type = $result[2];
		if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))) {
			$length = file_put_contents($path . $fileName, base64_decode(str_replace($result[1], '', $base64Str))); // 返回的是字节数
			if ($length > 0) {
				//获取图像的基本信息
				$width = 0;
				$height = 0;
				list($width, $height) = getimagesize($path . $fileName);

				//上传到百川多媒体
				new AlibcMediaHelper($path, $fileName, 1);

				$scale = round($width / ($width * 1.00), 2);

				return array('filename' => $fileName, 'path' => $path, 'width' => $width, 'height' => $height, 'scale' => $scale);
			}
		}else {
			//文件类型错误
			return false;
		}
		}
		return false;
		*/

			$path = "uploads/" . rtrim($pApplicationName, '/') . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';          //上传文件保存的路径，会自动到根目录的public文件夹下
			self::createFolders($path);
			$fileName = date('YmdHis') . "_" . rand(100, 999) . '.jpg';
			//3、保存图像至物理路径中(article中物理路径,仅包含uploadfile下的头像）
			$img = base64_decode($base64Str);
			$length = file_put_contents($path . $fileName, $img); // 返回的是字节数
			//		return array('filename' => $fileName, 'path' => $path, 'width' => 1, 'height' => 1, 'scale' => 0.6);
			if ($length > 0) {
				//获取图像的基本信息
				$width = 0;
				$height = 0;
				list($width, $height) = getimagesize($path . $fileName);

				//上传到百川多媒体
				new AlibcMediaHelper($path, $fileName, 1);

				$scale = round($width / ($width * 1.00), 2);

				return array('filename' => $fileName, 'path' => $path, 'width' => $width, 'height' => $height, 'scale' => $scale);
			}
			return false;

	}

	/**
	 * 创建文件夹
	 * @param String $path 文件夹路径
	 * @return boolean
	 */
	static function createFolders($path)
	{
		// 递归创建
		if (!file_exists($path)) {
			self::createFolders(dirname($path));
			// 取得最后一个文件夹的全路径返回开始的地方
			//mkdir($this->path, 0777);
			if (!@mkdir($path, 0755)) {
				self::setOption('errorNum', -4);
				return false;
			}
		}
		return true;
	}
}