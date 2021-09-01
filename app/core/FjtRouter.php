<?php 
/*
FJT router.
 */
class FjtRouter
{
	private $_uri = [], $_action = [], $_value;
	protected $par = [];
	public $controller;

	public function go($uri, $action)
	{
		$this->_uri[] = '/'.trim($uri, '/');
		if ($action != null && is_string($action)) {
			$a = explode('@', filter_var($action, FILTER_SANITIZE_URL));
			$this->_action[] = $a;
		}else if(is_callable($action)){
			$this->_action[] = $action;
		}
	}

	public function submit()
	{
		$uriGetParam = isset($_GET['url']) ? '/' .$_GET['url'] : '/';
		
		foreach ($this->_uri as $key => $value) {
			//echo $value."<br>";
			$patt =preg_match("/:[a-z]|[0-9]$/", $value);
			$r=explode('/:', ltrim($value,'/'));$rq=explode('/', trim($uriGetParam, '/'));
			if ($patt != 0 && strcmp($r[0],$rq[0]) == 0) {
				//$pos = str_replace('/:', '/', $value);
				//print_r($rq[0]);
				$rel = strcmp($r[0],$rq[0]);
				if(strcmp($r[0],$rq[0]) == 0) $a= $r[0];
				//print_r($r);
				if(count($rq) == count($r) && $rel == 0){
					if(is_array($this->_action[$key])){
						$useAction = $this->_action[$key];
						unset($rq[0]);
						$app = new App;
						$app->url = $useAction;
						if(file_exists('../app/controllers/'.$app->url[0].'.php')):
							require_once '../app/controllers/' .$app->url[0].'.php';
							$this->controll = $app->url[0];
							$c = explode('/', $this->controll);
							if(count($c) > 1):
								if(method_exists($c[1], $app->url[1]))
									$app->params = $rq ? array_values($rq) : [];
									$app->done();

							else:
								if(method_exists($this->controll, $app->url[1])):
									$app->params = $rq ? array_values($rq) : [];
									$app->done();
								endif;
							endif;
						endif;
					}
				}
				$this->_value = $value;
			}
			/*check if there is a match*/
			if (preg_match("#^$value$#", rtrim($uriGetParam,'/')) || preg_match("#^$value$#", $uriGetParam)) {
				if(is_array($this->_action[$key])){
					$useAction = $this->_action[$key];
					$app = new App;
					$app->url = $useAction;
					$app->done();
				}else{
					call_user_func($this->_action[$key]);
				}
				$this->_value = $value;
			}
		}
		//echo $this->_value;
		$new_uri = str_replace('/:', '/', $this->_value);
		$font = 'Lato Thin';
		$p1 = explode('/', trim($uriGetParam, '/')); //uri from GET method
		$p2 = explode('/', ltrim($new_uri, '/')); //uri define in route
		/*print_r($p1);
		echo $uriGetParam;*/
		if($uriGetParam != '/'):
			if((count($p1) != count($p2)) || strcmp($p1[0],$p2[0])){
				die('<link rel="stylesheet" type="text/css" href="' . SITE_URL . 'font/lato.css"><body style="height: 100%;display: table;margin: 0;padding: 0;font-weight: 100;width: 100%;font-family: '.$font.';"><div style="text-align: center;vertical-align: middle;display: table-cell;font-size: 65px">404... Page Not Found</div></body>');
			}
		endif;
	}
}
?>