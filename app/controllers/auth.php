
<?php

class Auth extends Controller
{
	public function __construct()
	{
		$this->_user = $this->model('User');
		$this->file = $this->model('File');
		$this->_input = Input::initiate();
		$this->_redirect = Redirect::initiate();
		$this->_session = Session::initiate();
		$this->_validate = Validate::initiate();
		$this->_token = Token::initiate();
		$this->_db = DB::getInstance();
	}
	public function register($name = '')
	{
		return $this->view('user/register');
	}

	public function postregister()
	{
		
		if($this->_input->exists()){
			$validation = $this->_validate->check($_POST, [
				'email' => array(
                  'required' => true,
                  'unique' => 'users',
                ),
                'password' => array(
                  'required' => true,
                  'min' => 6
                ),
                'confirm_password' => array(
                  'required' => true,
                  'matches' => 'password'
                ),
                'username' => array(
                  'required' => true,
                  'unique' => 'users',
                )
			]);
		}
		try {
			if(!$this->_token->check($this->_input->get('token'))) throw new Exception('Token mismatch', 1);
        	if(!$validation->passed()) throw new Exception(json_encode($validation->errors()), 1);
        	$user = new User();
			$user->create(array(
				'email' => $this->_input->get('email'),
				'password' => Hash::make($this->_input->get('password')),
				'username' => $this->_input->get('username'),
				'status' => 1,
				'groupp' => 2,
			));

			$this->_session->flash('login', 'You have been registered and can now log in!');
			$this->_redirect->to('login');
		} catch (Exception $e) {
			
			$this->_session->flash('error', $e->getMessage());
			$this->_redirect->to('signup');
		}
		//return $this->view('user/register');
	}
	public function trainerRegister()
	{
		$this->view('user/apply');
	}
	public function postTrainerRegister()
	{
		$file = $this->_input->hasFile('resume');
		$ext = $this->file->fileExt($file);
		try {
			if($ext == 'application/pdf' || $ext == 'application/msword'){
				$path = 'uploads/gallery/'.date("Y"). '/' . date("m").'/';
				$resume = $this->file->move_to($file,$path);
				$this->_db->insert('users',array(
					'email' => $this->_input->get('email'),
					'first_name' => $this->_input->get('first_name'),
					'last_name' => $this->_input->get('last_name'),
					'groupp' => 5,
					'apply' => 1,
					'resume' => $path.$resume,
				));

				Session::flash('home', 'Sent! You will receive an email on invitation.');
				Redirect::to('./');
			}
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function login()
	{
		return $this->view('user.login');
	}

	public function postLogin()
	{
		//$user = new User();
      	$remember = ($this->_input->get('remember') === 'on') ? true : false;
      	$login = $this->_user->login($this->_input->get('username'), $this->_input->get('password'), $remember);
      	//print_r($login);
       	if ($login) {
       		$user = $this->_user->data();
       		if($user->groupp != 1) $this->_redirect->to('user-dashboard');
       		else $this->_redirect->to('admin-dashboard');;
        	
		}else{
			Session::flash('login', 'An error occured');
			Redirect::to('login');
		}
	}

	public function logout()
	{
		if($this->_user->data()) $this->_user->logout();
		Redirect::to(SITE_URL);
	}
}
?>