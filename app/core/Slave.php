<?php 
class Slave
{
	public static function section($division='',$t = '',$secure = false,$permission = null)
	{
		ob_start();
		$user = new User;
		$title = ($t != '')? $t : 'TradeWell';
		if($secure != false){
			if(!is_null($permission)){
				if (!$user->isLoggedIn() || !$user->hasPermission($permission)){ die(print('<script>window.location.assign("'.SITE_URL.'")</script>'));}
			}
			if (!$user->isLoggedIn()){ die(print('<script>window.location.assign("'.SITE_URL.'")</script>'));}
		}
		return require_once APP_ROOT.'/views/'.str_replace('.', '/', $division).'.php';
		ob_end_flush();
	}
}

?>