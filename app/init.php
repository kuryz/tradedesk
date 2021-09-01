<?php
/*
|--------------------------------------------------------------
| FjFrame Application Init file
|--------------------------------------------------
|
|
*/
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../config.php";
$GLOBALS['config'] = array(
	'mysql' => array(
		'host'     => HOST,
		'username' => USERNAME,
		'password' => PASSWORD,
		'db'       => DATABASE,
	),
	'remember' => array(
		'cookie_name'   => 'hash',
		'cookie_expiry' => 604800,
	),
	'session' => array(
		'session_name' => 'user',
		'token_name'   => 'token',
	)
);
require_once __DIR__."/config.php";
spl_autoload_register(function($class){
	(file_exists(APP_ROOT.'/core/'.$class.'.php')) ? require_once 'core/'.$class.'.php' : require_once 'models/'.$class.'.php';
	/*else require_once "third_party/phpqrcode/qrlib.php"*/;
});


if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->table('user_sessions')->where('hash', '=', $hash);
	if($hashCheck != null) {
		if ($hashCheck->count()) {
			$u = $hashCheck->getFirst();
			$user = new User($u->user_id);
			$user->login();
		}
	}
}
$route = new FjtRouter;
require_once 'function/general.php';
require_once 'route.php';