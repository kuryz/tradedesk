<?php  
ini_set('display_errors', 0);
class controller
{
	public function model($model)
	{
		require_once APP_ROOT . '/models/' . $model . '.php';
		return new $model();
	}
	public function view($view, $data = [])
	{
		$user = new User;
		$error = (object) error_get_last();
		if(!empty($error) && isset($error->message) && $error->message != '') require_once APP_ROOT . '/views/errors/error_page.php';
		 if(file_exists(APP_ROOT . '/views/' . str_replace('.', '/', $view) . '.php')){
			$data = json_decode(json_encode($data), FALSE);
			require_once APP_ROOT . '/views/' . str_replace('.', '/', $view) . '.php';
		}else require_once APP_ROOT . '/views/errors/404.php';
	}
	public function json($data = [])
	{
		echo json_encode($data);
	}
}

?>