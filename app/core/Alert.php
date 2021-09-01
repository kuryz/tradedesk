<?php 
class Alert
{
	public static function message($message,$bootstrap = 4,$type = 'danger')
	{
		if($bootstrap == 3){
			return '
			<div class="alert alert-'.$type.' alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<strong>'.ucwords($message).'</strong>
			</div>';
		}
		if($bootstrap == 1) {
			return '<div class="alert alert-'.$type.'">
			<span class="closebtn" >&times;</span>'.ucwords($message).'
			</div>';		
		}
		return '
		<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
  			<strong>'.ucwords($message).'</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
			</button>
		</div>';
		
	}
}

?>