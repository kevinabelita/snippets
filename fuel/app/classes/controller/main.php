<?php

class Controller_Main extends Controller_Template
{
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		echo '<a href="' . Uri::create('maze/index') . '">Maze</a>';
		echo '<br/>';
		echo '<a href="' . Uri::create('calc/index') . '">Calculator</a>';
		echo '<br/>';
		echo '<a href="' . Uri::create('captcha/index') . '">Captcha Test</a>';
		die;
	}
}