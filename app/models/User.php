<?php 
class User
{
	private $_db, $_data, $_sessionName, $_cookieName, $_isLoggedIn;
	private static $_instance = null;

	function __construct($user = null)
	{
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				}else{
					// process logout
				}
			}
		}else{
			return $this->find($user);
		}
	}

	public static function initiate()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new User();
		}
		return self::$_instance;
	}

	public function update($fields = array(), $id = null)
	{
		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->user_id;
		}
		if (!$this->_db->update('users', $fields,['id',$id])) {
			throw new Exception("Error Processing Request", 1);
			
		}
	}

	public function create($fields = array())
	{
		if (!$this->_db->insert('users', $fields)) {
			throw new Exception("There was a problem creating an account.", 1);
			
		}
	}

	public function find($user = null)
	{
		if ($user) {
			$field = (is_numeric($user)) ? 'user_id' : 'username';
			$data = $this->_db->table('users')->where($field, '=', $user);
			if ($data->count() > 0) {
				//print_r($data);
				$this->_data = $data->getFirst();
				return true;
			}
		}
		return false;
	}

	public function login($username = null, $password = null, $remember = false)
	{
		
		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->user_id);
		} else {
			$user = $this->find($username);
		
			if ($user) {
				if(Hash::match($password, $this->data()->password)){
				//if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
					Session::put($this->_sessionName, $this->data()->user_id);

					if ($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->table('user_sessions')->where('user_id', $this->data()->user_id);
						if($hashCheck != null)
							if (!$hashCheck->count()) {
								$this->_db->insert('user_sessions', [
									'user_id' => $this->data()->user_id,
									'hash' => $hash,
								]);
							}else{
								$hash = $hashCheck->getFirst()->hash;
							}

							Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}
					return true;
				}
			}
		}

		return false;
	}

	public function hasPermission($key)
	{
		$group = $this->_db->table('groups')->where('id', '=', $this->data()->groupp);
		if ($group->count()) {
			$permissions = json_decode($group->getFirst()->permissions, true);
			
			if (array_key_exists($key, $permissions) && $permissions[$key] == true) {
				return true;
			}
		}
		return false;
	}

	public function exists()
	{
		return (!empty($this->_data)) ? true : false;
	}

	public function logout()
	{
		$this->_db->delete('user_sessions', ['user_id', '=', $this->data()->user_id]);
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}

	public function data(){
		return $this->_data;
	}

	public function isLoggedIn()
	{
		return $this->_isLoggedIn;
	}
}
