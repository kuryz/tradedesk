<?php 
/*set application root --- Define constants here*/

$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];

$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

$url = str_replace('public/', '', $root);


define('SITE_URL', $url);
define('HOST', 'localhost');		//define host machine
define('USERNAME', 'root'); 		//define username
define('PASSWORD', '');				//define password
define('DATABASE', 'traderdesk');		//define database name
define('HASHKEY', 'hash');			//define hash key word eg. hash


/*define('SDK', __DIR__.'\app\controllers\firebase-adminsdk-e4o1m-21ccdaf993.json'); //firebase SDK location
define('FDB', 'https://fire_db.firebaseio.com/'); //firebase database*/

?>