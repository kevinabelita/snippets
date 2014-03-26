<?php

class Controller_Captcha extends Controller_Main
{
	public $template = 'template';
	private $font = '';

	public function before()
	{
		parent::before();
		$this->font = DOCROOT . 'assets/fonts/PlAGuEdEaTH.ttf';
	}

	public function action_index()
	{
		$data = array();
		$this->template->title = 'Captcha Test';
		$this->template->content = View::forge('captcha/index', $data);
	}

	public function action_generate()
	{
		// create random characters
		$characters = substr(md5(microtime()),rand(0,26),5);

		// save
		Session::set('cs', $characters);

		// create image
		$image = imagecreatetruecolor(120, 50);
		$color = imagecolorallocate($image, 113, 193, 217);
		$white = imagecolorallocate($image, 255, 255, 255);
		imagefilledrectangle($image,0,0,399,99,$white);
		imagettftext($image, 30, 0, 10, 40, $color, $this->font, $characters);

		$response = new Response();
		$response->set_header('Content-Type', 'image/png');
		$response->set_header('Content-Disposition', 'attachment; filename="image.png"');
		imagepng($image);
		imagedestroy($image);

		return $response;
	}

	public function action_process_form()
	{
		if(Input::post())
		{
			$name = Input::post('name');
			$uc = Input::post('uc');
			$code = Session::get('cs', false);

			if($uc !== $code) {
				Session::set_flash('wrong_captcha', 'Please retype the image shown.');
				Response::redirect('captcha/index');
			}

			// if correct captcha input continue code
			echo '<b>OK</b>';
			echo '<br/><a href="' . Uri::create('captcha/index') . '">Back</a>';
			die;
		}
		else
		{
			Response::redirect('captcha/index');
		}
	}
}
