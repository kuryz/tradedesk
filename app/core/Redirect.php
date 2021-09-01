<?php 
class Redirect
{
	private static $_instance = null;

	public static function initiate()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new Redirect();
		}
		return self::$_instance;
	}

	public static function to($location = null)
	{
		if ($location) {
			if (is_numeric($location)) {
				switch ($location) {
					case 404:
						header('HTTP/1.0 404 Not Found');
						include 'includes/errors/404.php';
						exit();
						break;
					
				}
			}
			($location == SITE_URL) ? header('location: ' . $location) : header('location: ' . SITE_URL . $location);
			exit();
		}
	}

	public static function back()
	{
		// header('Location: ' . $_SERVER['HTTP_REFERER']);
		header("location:javascript://history.go(-1)");
		exit;
	}
}
?>