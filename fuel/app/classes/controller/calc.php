<?php

class Controller_Calc extends Controller_Main
{
	public $template = 'template';
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$data = array();
		$this->template->title = 'Calculator';
		$this->template->content = View::forge('calc/index', $data);
	}
}
