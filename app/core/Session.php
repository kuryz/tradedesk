<?php 
class Session
{
	private static $_instance = null;
	
	public static function initiate()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new Session();
		}
		return self::$_instance;
	}

	public static function exists($name)
	{
		return (isset($_SESSION[$name])) ? true : false;
	}

	public static function put($name, $value='')
	{
		return $_SESSION[$name] = $value;
	}

	public static function get($name)
	{
		return $_SESSION[$name];
	}

	public static function delete($name)
	{
		if(self::exists($name)){
			unset($_SESSION[$name]);
		}
	}

	public static function flash($name, $string = '', $type = 'info',$bootstrap = 4)
	{
		if (self::exists($name)) {
			$session = self::get($name);
			self::delete($name);
			$style = '
			<style>
				.fj-frame{width:100%;}
				@media only screen and (max-width: 420px) {
					.fj-frame {width: 100%;}
				}
				</style>
			';
			if($bootstrap == 3){
				return '
				<style>
				.fj-frame{width:100%;}
				@media only screen and (max-width: 420px) {
					.fj-frame {width: 100%;}
				}
				</style>
				<div class="fj-frame">
					<div class="alert alert-'.$type.' alert-dismissible" role="alert" style="z-index:1999">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
						</button>
			  			<strong>'.ucwords($session).'</strong>
					</div>
				</div>';
			}
			elseif ($bootstrap == 1) {
				return $style . '

				<div class="fj-frame">
					<div class="alert alert-'.$type.' alert-dismissible" role="alert" style="z-index:1999">
						<span class="closebtn" data-dismiss="alert" aria-label="Close">&times;</span>
			  			<strong>'.ucwords($session).'</strong>
					</div>
				</div>
				';
			}
			return '
			<style>
			.fj-frame{width:100%;}
			@media only screen and (max-width: 420px) {
				.fj-frame {width: 100%;}
			}
			</style>
			<div class="fj-frame">
				<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert" style="z-index:1999">
		  			<strong>'.ucwords($session).'</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>';
		}else{
			self::put($name, $string);
		}
	}
}
?>