<?php
//set errors off when this file is run
ini_set('display_errors', 0);

class Validate
{
	private $_passed = false, $_errors = array(), $_db;
	private static $_instance = null;

	public function __construct()
	{
		$this->_db = DB::getInstance();
	}

	public static function initiate()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new Validate();
		}
		return self::$_instance;
	}

	public function check($source, $items = array())
	{
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				 $value = (isset($_FILES[$item])) ? $_FILES[$item]['name'] : trim($source[$item]);
				$item = escape($item);
				$it = str_replace('_', ' ', $item);
				if ($rule === 'required' && empty($value)) {
					//$it = str_replace('_', ' ', $item);
					$this->addError("{$it} is required");
				}else if(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$it} must be a minimum of {$rule_value} characters");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$it} must be a maximum of {$rule_value} characters");
							}
							break;
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("{$rule_value} must match {$it}");
							}
							break;
						case 'unique':
							$check = $this->_db->table($rule_value)->where($item, '=', $value);
							if ($check->count()) {
								$this->addError("{$it} already exists.");
							}
							break;
						case 'numeric':
							if(!is_numeric($value)) $this->addError("{$it} must be selected");
							break;
					}
				}
			}
		}
		if (empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}

	private function addError($error)
	{
		$this->_errors[] = $error;
	}

	public function errors()
	{
		return $this->_errors;
	}

	public function passed()
	{
		return $this->_passed;
	}
}
?>