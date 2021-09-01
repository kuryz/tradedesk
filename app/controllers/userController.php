<?php 

class UserController extends Controller 
{
	public function __construct()
	{
		$this->_db = DB::getInstance();
		$this->_user = $this->model('User');
	}
	public function index()
	{
		$user = $this->_user->data();
		$this->view('client.dashboard', compact('user'));
	}

	public function deposit()
	{
		$user = $this->_user->data();
		$this->view('client.deposit.index', compact('user'));
	}

	
	
}

?>