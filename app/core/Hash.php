<?php 
class Hash
{
	private static $_instance = null;

	public static function initiate()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new Hash();
		}
		return self::$_instance;
	}

	public static function make($string, $salt = '')
	{
		return password_hash($string, PASSWORD_BCRYPT);
	}

	public static function salt($length)
	{
		return mcrypt_create_iv($length);//been deprecated PHP > 7
	}

	public static function match($string, $hash)
	{
		return password_verify($string, $hash);
	}

	public static function unique()
	{
		return self::make(uniqid());
	}
}
?>