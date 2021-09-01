<?php 
class App
{
	public $controller, $method,$url = [],$params = [];
	private $_params = [];

	public function done()
	{
		try {
			if(file_exists(APP_ROOT . '/controllers/' . $this->url[0] . '.php')):
			$this->controller = $this->url[0];
			$c = explode('/', $this->controller);
			if(count($c) > 1):
			 $this->controller = $c[1]; require_once APP_ROOT . '/controllers/' . $c[0] . '/' . $this->controller . '.php';
			else:
				require_once APP_ROOT . '/controllers/' . $this->controller . '.php';
			endif;
			//require_once APP_ROOT . '/controllers/' .$this->controller.'.php';
			if(!class_exists($this->controller)) throw new Exception("Class controller not found", 1);
			$this->controll = new $this->controller;
				if(isset($this->url[1])):
					if(method_exists($this->controll, $this->url[1])):
						$this->method = $this->url[1];
						unset($this->url[1]);
					else:
						throw new Exception("method not found", 1);
					endif;
				endif;
			else:
				throw new Exception("controller not found", 1);
			endif;
			$this->_params = $this->params ? array_values($this->params) : [];
			call_user_func_array([$this->controll, $this->method], $this->_params);
		} catch (Exception $e) {
			$font = 'Lato Thin';
			die('<link rel="stylesheet" type="text/css" href="'.SITE_URL.'font/lato.css"><body style="height: 100%;display: table;margin: 0;padding: 0;font-weight: 100;width: 100%;font-family: '.$font.';"><div style="text-align: center;vertical-align: middle;display: table-cell;font-size: 65px">Oops... '.$e->getMessage().'</div></div><br>');
		}
	
	}
}
?>