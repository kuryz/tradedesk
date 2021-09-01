<?php
class Token
{
	private static $_instance = null;
	public static function initiate()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new Token();
		}
		return self::$_instance;
	}

	public static function generate()
	{
		return Session::put(Config::get('session/token_name'), md5(uniqid()));
	}

	public static function check($token='',$api = false)
	{
		$tokenName = Config::get('session/token_name');
		if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
			if($api != true) Session::delete($tokenName);
			return true;
		}
		return false;
	}
}
?>