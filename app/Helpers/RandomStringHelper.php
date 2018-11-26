<?php

namespace App\Helpers;

/**
 * Created by PhpStorm.
 * User: Panda
 * Date: 16-12-20
 * Time: 14:15
 */

/**
 * 生成随机字符串的类，默认只包含数字、大小写字母
 * 使用方法
 	use App\Helpers\RandomStringHelper;
 	return new RandomStringHelper(12, RandomStringHelper::MIXED, true, '', '');
 */
class RandomStringHelper
{
	/*
	 * 生成的字符串包含的字符设置
	 */

	const NUMERIC_ONLY = 1; //只含有数字
	const LETTER_ONLY = 2; //只含有字母
	const MIXED = 3; //混合数字和字母

	/*
	 * 用户传入变量，分别为字符串长度；包含的字母；是否包含大写字母；前缀；后缀
	 */
	protected $length, $type, $upper, $prefix, $suffix;

	/*
	 * 参数初始化
	 * @param int,$length 字符串长度
	 * @param const,$type 生成字符串的类型
	 * @param boolean,$upper 是否含有大写字母
	 * @param string $prefix 前缀
	 * @param string $suffix 后缀
	 */
	public function __construct($length = 16, $type = self::MIXED, $upper = true, $prefix = '', $suffix = '')
	{
		$this->length = $length - strlen($prefix) - strlen($suffix);
		$this->type = $type;
		$this->upper = $upper;
		$this->prefix = $prefix;
		$this->suffix = $suffix;
	}

	/*
	 * 对象被转化为字符串时调用
	 * @return string
	 */

	public function __toString()
	{
		return $this->pickUpChars();
	}

	/*
	 * 生成随机字符串
	 * @global $type
	 * @return string,$string
	 */
	public function pickUpChars()
	{
		switch ($this->type) {
			case self::NUMERIC_ONLY:
				$raw = '0123456789';
				break;
			case self::LETTER_ONLY:
				$raw = 'qwertyuioplkjhgfdsazxcvbnm' .
					'QWERTYUIOPLKJHGFDSAZXCVBNM';
				break;
			default:
				$raw = 'qwertyuioplkjhgfdsazxcvbnm' .
					'QWERTYUIOPLKJHGFDSAZXCVBNM' .
					'0123456789';
				break;
		}
		$string = '';
		for ($index = 0; $index < $this->length; $index++)
			$string .= substr($raw, mt_rand(0, strlen($raw) - 1), 1);
		if (!$this->upper)
			$string = strtolower($string);

		return $this->prefix. $string. $this->suffix;
	}
}