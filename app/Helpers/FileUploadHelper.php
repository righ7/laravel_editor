<?php

namespace App\Helpers;

use App\Application\Alibc\Sdk\AlibcMediaHelper;

/**
 * file: fileupload.class.php 文件上传类FileUpload
 * 本类的实例对象用于处理上传文件，可以上传一个文件，也可同时处理多个文件上传
 *
 * ========================================================================
 * 注意：要检查public文件夹的权限，有读写的权限
 * ========================================================================
 * 使用方法：
	use App\Helpers\FileUploadHelper;
 *
	//设置属性(上传文件类型【IMAGE、MEDIA】， 名称是否要随机生成)
	$up = new FileUploadHelper(FileUploadHelper::IMAGE, true);
		//使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
	if($up -> upload("pic", "Article")) {
		//获取上传后文件名子
		$fileName = $up->getFileName();
		$filePath = $up->getFilePath();
		$width = $up->getImageWidth();		//获取图片宽度【仅支持单个图片文件上传】
		$height = $up->getImageHeight();	//获取图片高度【仅支持单个图片文件上传】
		$scale = $up->getImageScale();		//获取图片比例【仅支持单个图片文件上传】
	} else {
		//获取上传失败以后的错误提示
		$error = $up->getErrorMsg();
	}
 * ========================================================================
 * 以上是本地上传图片
 * 以下是下载网络图片
 * ========================================================================
 *
	//设置属性(上传文件类型【IMAGE、MEDIA】， 名称是否要随机生成)
	$up = new FileUploadHelper(FileUploadHelper::IMAGE, true);
	//使用对象中的downNetworkPicture方法， 就可以上传文件， 方法需要传图片的Url，即：$nPictureUrl, 如果成功返回true, 失败返回false
	if($up -> downNetworkPicture($nPictureUrl, "Article")) {
		//获取上传后文件名子
		$fileName = $up->getFileName();
		$filePath = $up->getFilePath();
		$width = $up->getImageWidth();		//获取图片宽度【仅支持单个图片文件上传】
		$height = $up->getImageHeight();	//获取图片高度【仅支持单个图片文件上传】
		$scale = $up->getImageScale();		//获取图片比例【仅支持单个图片文件上传】
	} else {
		//获取上传失败以后的错误提示
		$error = $up->getErrorMsg();
	}
 * ========================================================================
 */
class FileUploadHelper
{
	/*
	 * 上传文件的类型
	 */
	const MEDIA = 1; //视频
	const IMAGE = 2; //图片
    const Excel = 3; //视频
    const Word = 4; //图片

	private $path = "uploads/";          //上传文件保存的路径，会自动到根目录的public文件夹下
	private $allowType = array('jpg', 'gif', 'png', 'jpeg'); //设置限制上传文件的类型
	private $maxsize = 1000000;           //限制文件上传大小（字节）
	private $isRandName = true;           //设置是否随机重命名文件， false不随机

	private $originName;              //源文件名
	private $tmpFileName;              //临时文件名
	private $fileType;               //文件类型(文件后缀)
	private $fileSize;               //文件大小
	private $newFileName;              //新文件名
	private $errorNum = 0;             //错误号
	private $errorMess = "";             //错误报告消息
	private $width;              		//图片宽
	private $height;              		//图片高

	private $fileField;					//上传的文件控件的id
	private $UploadType;				//上传文件类型

	/**
	 * 上传图片函数
	 * @param int $pUploadType 	上传类型，数组
	 * @param boolean $pIsRandName 	文件名称是否随机生成
	 */
	public function __construct($pUploadType = self::IMAGE, $pIsRandName = true)
	{
		$this->isRandName = $pIsRandName;
		$this->UploadType = $pUploadType;
		switch ($pUploadType)
		{
			case self::MEDIA://视频
				$this->allowType = array('mp4');
				$this->maxsize = 41943040; //视频控制在40M以内
				break;
			case self::IMAGE://图片
				$this->allowType = array('jpg', 'gif', 'png', 'jpeg');
				$this->maxsize = 2097152; //图片控制在2M以内
				break;
		}
	}

	/**
	 * 用于设置成员属性（$path, $allowtype,$maxsize, $israndname）
	 * 可以通过连贯操作一次设置多个属性值
	 *@param  string $key  成员属性名(不区分大小写)
	 *@param  mixed  $val  为成员属性设置的值
	 *@return  object     返回自己对象$this，可以用于连贯操作
	 */
//	function set($key, $val){
//		$key = strtolower($key);
//		if( array_key_exists( $key, get_class_vars(get_class($this) ) ) ){
//			$this->setOption($key, $val);
//		}
//		return $this;
//	}

	/**
	 *  调用该方法上传文件
	 * @param $pFileField 		上传文件的表单名称 如$_FILES['photo']的photo
	 * @param $pDir				上传到目录【功能名称】 如 user、Article
	 *  @return bool        	如果上传成功返回数true
	 */
	function upload($pFileField, $pDir)
	{
		//放在这边设置这两个参数是为了灵活使用，比如：同时多个图片上传
		$this->fileField = $pFileField;
		$this->path .= $pDir;

		$return = true;
		/* 检查文件路径是滞合法 */
		if (!$this->checkFilePath()) {
			$this->errorMess = $this->getError();
			return false;
		}
		/* 将文件上传的信息取出赋给变量 */
		$name = $_FILES[$this->fileField]['name'];
		$tmp_name = $_FILES[$this->fileField]['tmp_name'];
		$size = $_FILES[$this->fileField]['size'];
		$error = $_FILES[$this->fileField]['error'];

		/* 如果是多个文件上传则$file["name"]会是一个数组 */
		if (is_Array($name)) {
			$errors = array();
			/*多个文件上传则循环处理 ， 这个循环只有检查上传文件的作用，并没有真正上传 */
			for ($i = 0; $i < count($name); $i++) {
				/*设置文件信息 */
				if ($this->setFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i])) {
					if (!$this->checkFileSize() || !$this->checkFileType()) {
						$errors[] = $this->getError();
						$return = false;
					}
				} else {
					$errors[] = $this->getError();
					$return = false;
				}
				/* 如果有问题，则重新初使化属性 */
				if (!$return)
					$this->setFiles();
			}

			if ($return) {
				/* 存放所有上传后文件名的变量数组 */
				$fileNames = array();
				/* 如果上传的多个文件都是合法的，则通过销魂循环向服务器上传文件 */
				for ($i = 0; $i < count($name); $i++) {
					if ($this->setFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i])) {
						$this->setNewFileName();
						if (!$this->copyFile()) {
							$errors[] = $this->getError();
							$return = false;
						}
						$fileNames[] = $this->newFileName;
					}
				}
				$this->newFileName = $fileNames;
			}
			$this->errorMess = $errors;
			return $return;
			/*上传单个文件处理方法*/
		} else {
			/* 设置文件信息 */
			if ($this->setFiles($name, $tmp_name, $size, $error)) {
				/* 上传之前先检查一下大小和类型 */
				if ($this->checkFileSize() && $this->checkFileType()) {
					/* 为上传文件设置新文件名 */
					$this->setNewFileName();
					/* 上传文件  返回0为成功， 小于0都为错误 */
					if ($this->copyFile()) {
						return true;
					} else {
						$return = false;
					}
				} else {
					$return = false;
				}
			} else {
				$return = false;
			}
			//如果$return为false, 则出错，将错误信息保存在属性errorMess中
			if (!$return)
				$this->errorMess = $this->getError();

			return $return;
		}
	}

	/**
	 * 获取上传后的文件名称
	 * @param  void   没有参数
	 * @return string 上传后，新文件的名称， 如果是多文件上传返回数组
	 */
	public function getFileName()
	{
		return $this->newFileName;
	}

	/**
	 * 获取上传后的文件名称
	 * @param  void   没有参数
	 * @return string 上传后，新文件的名称， 如果是多文件上传返回数组
	 */
	public function getFilePath()
	{
        /**
         * 如果是多文件的话，那么路径地址返回的也是数组
         */
        if(is_array($this->newFileName)){
            foreach($this->newFileName as $key=>$value){
                $arrPath[$key]=rtrim($this->path, '/') . '/'.$value;
            }
            return $arrPath;
        }else{
            return rtrim($this->path, '/') . '/'.$this->newFileName;
        }

	}
	/**
	 * 获取图片的宽高比例，只支持单个图片上传
	 * @param  void   没有参数
	 * @return int  返回图片宽
	 */
	public function getImageWidth()
	{
		return $this->width;
	}
	/**
	 * 获取图片的宽高比例，只支持单个图片上传
	 * @param  void   没有参数
	 * @return int  返回图片的高
	 */
	public function getImageHeight()
	{
		return $this->height;
	}

	/**
	 * 获取图片的宽高比例，只支持单个图片上传
	 * @param  void   没有参数
	 * @return decimal  返回图片的宽高比例
	 */
	public function getImageScale()
	{
		$scale=round($this->height / ($this->width * 1.00), 2);
		return $scale;
	}

	/**
	 * 上传失败后，调用该方法则返回，上传出错信息
	 * @param  void   没有参数
	 * @return string  返回上传文件出错的信息报告，如果是多文件上传返回数组
	 */
	public function getErrorMsg()
	{
		return $this->errorMess;
	}

	/* 设置上传出错信息 */
	private function getError()
	{
//		$str = "上传文件<font color='red'>{$this->originName}</font>时出错 : ";
		$str = "上传文件{$this->originName}时出错 : ";
		switch ($this->errorNum) {
			case 4:
				$str .= "没有文件被上传";
				break;
			case 3:
				$str .= "文件只有部分被上传";
				break;
			case 2:
				$str .= "上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值";
				break;
			case 1:
				$str .= "上传的文件超过了php.ini中upload_max_filesize选项限制的值";
				break;
			case -1:
				$str .= "未允许类型";
				break;
			case -2:
				$str .= "文件过大,上传的文件不能超过{$this->maxsize}个字节";
				break;
			case -3:
				$str .= "上传失败";
				break;
			case -4:
				$str .= "建立存放上传文件目录失败，请重新指定上传目录：".$this->path;
				break;
			case -5:
				$str .= "必须指定上传文件的路径";
				break;
			default:
				$str .= "未知错误";
		}
		return $str;
	}

	/* 设置和$_FILES有关的内容 */
	private function setFiles($name = "", $tmp_name = "", $size = 0, $error = 0)
	{
		$this->setOption('errorNum', $error);
		if ($error)
			return false;
		$this->setOption('originName', $name);
		$this->setOption('tmpFileName', $tmp_name);
		$aryStr = explode(".", $name);
		$this->setOption('fileType', strtolower($aryStr[count($aryStr) - 1]));
		$this->setOption('fileSize', $size);
		return true;
	}

	/* 为单个成员属性设置值 */
	private function setOption($key, $val)
	{
		$this->$key = $val;
	}

	/* 设置上传后的文件名称 */
	private function setNewFileName()
	{
		if ($this->isRandName) {
			$this->setOption('newFileName', $this->proRandName());
		} else {
			$this->setOption('newFileName', $this->originName);
		}
	}

	/* 检查上传的文件是否是合法的类型 */
	private function checkFileType()
	{
		if (in_array(strtolower($this->fileType), $this->allowType)) {
			return true;
		} else {
			$this->setOption('errorNum', -1);
			return false;
		}
	}

	/* 检查上传的文件是否是允许的大小 */
	private function checkFileSize()
	{
		if ($this->fileSize > $this->maxsize) {
			$this->setOption('errorNum', -2);
			return false;
		} else {
			return true;
		}
	}

	/* 检查是否有存放上传文件的目录 */
	private function checkFilePath()
	{
		//对文件夹路径进行设置，按照年月日进行分配
		$this->path = rtrim($this->path, '/') . '/'. date('Y') . '/'. date('m') . '/'. date('d');

		if (empty($this->path)) {
			$this->setOption('errorNum', -5);
			return false;
		}
		/*
		if (!file_exists($this->path) || !is_writable($this->path)) {
			if (!@mkdir($this->path, 0755)) {
				$this->setOption('errorNum', -4);
				return false;
			}
		}
		*/
		return $this->createFolders($this->path);
		return true;
	}

	/**
	 * 创建文件夹
	 * @param String $path 文件夹路径
	 * @return boolean
	 */
	public  function createFolders($path)
	{
		// 递归创建
		if (!file_exists($path)) {
			$this->createFolders(dirname($path));
			// 取得最后一个文件夹的全路径返回开始的地方
			//mkdir($this->path, 0777);
			if (!@mkdir($path, 0755)) {
				$this->setOption('errorNum', -4);
				return false;
			}
		}
		return true;
	}

	/* 设置随机文件名 */
	private function proRandName()
	{
		$fileName = date('YmdHis') . "_" . rand(100, 999);
		return $fileName . '.' . $this->fileType;
	}

	/* 复制上传文件到指定的位置 */
	private function copyFile()
	{
		if (!$this->errorNum) {
			$path = rtrim($this->path, '/') . '/';
			//move_uploaded_file($this->files['tmp_name'], mb_convert_encoding($dest, "gb2312", "UTF-8"));
			if (@move_uploaded_file($this->tmpFileName, $path .$this->newFileName)) {
				if ($this->UploadType == self::IMAGE)
					list($this->width,$this->height)=getimagesize($path .$this->newFileName);
				else
				{
					$this->width = 0;
					$this->height = 0;
				}
				//上传到百川多媒体
				new AlibcMediaHelper($path, $this->newFileName, 1);
				return true;
			} else {
				$this->setOption('errorNum', -3);
				return false;
			}
		} else {
			return false;
		}
	}

	/*
	* 功能：php完美实现下载远程图片保存到本地
	* 参数：文件url,保存文件目录,保存文件名称，使用的下载方式
	* 当保存文件名称为空时则使用远程文件原来的名称
	*/
	/**
	 *  调用该方法上传文件
	 * @param String $url 		上传文件的表单名称 如$_FILES['photo']的photo
	 * @param String $pDir		上传到目录【功能名称】 如 user、Article
	 * @param int $type			上传模式，默认0
	 * @return bool   			如果上传成功返回数true
	 */
	function downNetworkPicture($url, $pDir='', $type=0){
		$this->path .= $pDir;
		if(trim($url)==''){
			$this->setOption('errorNum', 4);
			return false;
		}
		$this->setOption('fileType', 'jpg');
		$this->setNewFileName();
		/* 检查文件路径是滞合法 */
		if (!$this->checkFilePath()) {
			$this->errorMess = $this->getError();
			return false;
		}
		$path = rtrim($this->path, '/') . '/';

		//获取远程文件所采用的方法
		if($type){
			$ch=curl_init();
			$timeout=5;
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			$img=curl_exec($ch);
			curl_close($ch);
		}else{
			ob_start();
			readfile($url);
			$img=ob_get_contents();
			ob_end_clean();
		}
		//文件大小
		$fp2=@fopen($path.$this->newFileName,'a');
		fwrite($fp2,$img);
		fclose($fp2);
		unset($img,$url);

		try
		{
			if ($this->UploadType == self::IMAGE)
				list($this->width,$this->height)=getimagesize($path .$this->newFileName);
			else
			{
				$this->width = 0;
				$this->height = 0;
			}
			//上传到百川多媒体
			new AlibcMediaHelper($path, $this->newFileName, 1);
		}
		catch(Exception $e)
		{
			echo 'Message: ' .$e->getMessage();
		}
		return true;
	}
}