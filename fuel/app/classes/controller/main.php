<?php

class Controller_Main extends Controller_Template
{
	public $template = 'template';

	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$data = array();
		$this->template->title = 'Main';
		$this->template->content = View::forge('main/index', $data);
	}

	public function action_check()
	{
		if(Input::post()) {
			$username = Input::post('username');
			$password = Input::post('password');
			if($username && $password) {
				$exists = Model_Users::check_user($username, $password);
				if($exists) {
					echo 'EXISTS';
				} else {
					echo 'NOT EXISTS';
				}

				die;
			}

		} else Response::redirect('main/index');
	}
}