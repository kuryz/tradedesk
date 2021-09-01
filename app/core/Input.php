<?php 
class Input
{
	private static $_instance = null;
	public static function initiate()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new Input();
		}
		return self::$_instance;
	}
	public static function exists($type='post')
	{
		switch ($type) {
			case 'post':
				return (!empty($_POST)) ? true : false;
				break;
			case 'get':
				return (!empty($_GET)) ? true : false;
				break;
			
			default:
				return false;
				break;
		}
	}

	public static function get($item, $param = false)
	{
		if (isset($_POST[$item])) {
			if($param == true) return $_POST[$item];
			return strtolower($_POST[$item]);
		}elseif (isset($_GET[$item])) {
			return $_GET[$item];
		}
		return '';
	}

	public static function hasFile($file)
	{
		if (isset($_FILES[$file])) {
			return $_FILES[$file];
		}
	}
}
?>