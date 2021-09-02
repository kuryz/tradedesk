<?php 

class AdminController extends Controller 
{
	public function __construct()
	{
		$this->_db = DB::getInstance();
		$this->_input = Input::initiate();
		$this->_redirect = Redirect::initiate();
		$this->_session = Session::initiate();
		$this->_validate = Validate::initiate();
		$this->_token = Token::initiate();
		$this->_user = $this->model('User');
	}
	public function index()
	{
		$user = $this->_user->data();
		$totalusers = $this->_db->table('users')->where('groupp', '<>', 1)->count();
		$activeusers = $this->_db->table('users')->where('groupp', '<>', 1)->where('status', 1)->count();
		$blockusers = $this->_db->table('users')->where('groupp', '<>', 1)->where('status', 0)->count();
		$pending_deposit = $this->_db->table('deposits')->select('SUM(amount) AS pending_amt')->where('status', 0)->getFirst();
		$total_deposit = $this->_db->table('deposits')->select('SUM(amount) AS total_amt')->getFirst();
		//print_r($total_deposit);
		$this->view('admin.dashboard', compact('user', 'totalusers', 'activeusers', 'blockusers', 'pending_deposit', 'total_deposit'));
	}

	public function mdeposits()
	{
		$user = $this->_user->data();
		$this->view('admin.deposit.index', compact('user'));
	}

	public function mwithdraws()
	{
		$user = $this->_user->data();
		$this->view('admin.withdraw.index', compact('user'));
	}

	public function minvestment()
	{
		$user = $this->_user->data();
		$plans = $this->_db->table('plans')->get();
		$this->view('admin.plans.index', compact('user','plans'));
	}

	public function postinvestment()
	{
		if($this->_input->exists()){
			$validation = $this->_validate->check($_POST, [
				'title' => array(
                  'required' => true,
                  'unique' => 'plans',
                ),
                'amount' => array(
                  'required' => true,
                ),
                'max_amount' => array(
                  'required' => true,
                ),
                'return_of_investment' => array(
                  'required' => true,
                )
			]);
		}
		try {
			if(!$this->_token->check($this->_input->get('token'))) throw new Exception('Token mismatch', 1);
        	if(!$validation->passed()) throw new Exception(json_encode($validation->errors()), 1);
        	$insert = $this->_db->insert('plans', [
        		'title' => $this->_input->get('title'),
        		'amount' => $this->_input->get('amount'),
        		'max_price' => $this->_input->get('max_amount'),
        		'roi' => $this->_input->get('return_of_investment'),
        		'status' => 1,
        	]);
        	if ($insert) {
        		$this->_session->flash('status', 'created successfully!');
				$this->_redirect->to('investments');
        	}
		} catch (Exception $e) {
			$this->_session->flash('error', $e->getMessage());
			$this->_redirect->to('investments');
		}
	}
	
	public function setting($value='')
	{
		$user = $this->_user->data();
		$setting = $this->_db->table('settings')->getFirst();
		$this->view('admin.settings', compact('user', 'setting'));
	}

	public function postsetting()
	{
		if($this->_input->exists()){
			$validation = $this->_validate->check($_POST, [
				'currency' => array(
                  'required' => true,
                  // 'unique' => 'settings',
                ),
                'min_withdraw_amount' => array(
                  'required' => true,
                ),
			]);
		}
		try {
			if(!$this->_token->check($this->_input->get('token'))) throw new Exception('Token mismatch', 1);
        	if(!$validation->passed()) throw new Exception(json_encode($validation->errors()), 1);
        	$insert = $this->_db->update('settings', [
        		'currency' => $this->_input->get('currency'),
        		'mini_withdraw_amt' => $this->_input->get('min_withdraw_amount'),
        	])->where(1)->exec();
			if ($insert) {
				$this->_session->flash('status', 'created successfully!');
				$this->_redirect->to('settings');
			}
		} catch (Exception $e) {
			$this->_session->flash('error', $e->getMessage());
			$this->_redirect->to('settings');
		}
	}
	
}

?>