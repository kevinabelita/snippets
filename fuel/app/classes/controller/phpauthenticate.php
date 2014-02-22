<?php

class Controller_PhpAuthenticate extends Controller_Main
{
	public $template = 'template';
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		if(!isset($_SERVER['PHP_AUTH_USER']) || !$_SERVER['PHP_AUTH_USER']) {
			header('WWW-Authenticate: Basic realm="Login "' . date('YmdHis'));
			header('HTTP/1.0 401 Unauthorized');
			
			
			exit;
		} else {
			Response::redirect('phpauthenticate/login');
		}
		
		
	}
	
	public function action_login()
	{
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];
		
		$exists = Model_Users::check_user($username, $password);
		if($exists) {
			Session::set('username', $username);
			Session::set('login', true);
			Response::redirect('phpauthenticate/landing_page');
		} else {
			Response::redirect('phpauthenticate/index');
		}
	}

	public function action_landing_page()
	{
		$data = array();
		$this->template->title = 'Landing Page';
		$this->template->content = View::forge('phpauthenticate/index', $data);
	}
	
	private function check_login()
	{
		$user_id = false;
		$is_logged = Session::get('login', false);
		return $is_logged;
	}
	
	public function action_logout()
	{
		Session::destroy('login');
		Session::destroy('username');
		unset($_SERVER['PHP_AUTH_USER']);
		$_SERVER['PHP_AUTH_USER'] = NULL;
		unset($_SERVER['PHP_AUTH_PW']);
		if(!isset($_SERVER['PHP_AUTH_USER']) || !$_SERVER['PHP_AUTH_USER']) {
			// header('WWW-Authenticate: Basic realm="Login "' . date('YmdHis'));
			// header('HTTP/1.0 401 Unauthorized');
			
			Response::redirect('phpauthenticate/index');
			exit;
		} else {
			Response::redirect('phpauthenticate/login');
		}
		
		exit;
		
	}
}
