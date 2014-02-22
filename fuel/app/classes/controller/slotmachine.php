<?php

class Controller_Slotmachine extends Controller_Main
{
	public $template = 'template';
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$data = array();
		$this->template->title = 'Slot Machine';
		$this->template->content = View::forge('slot_machine/index', $data);
	}
}
