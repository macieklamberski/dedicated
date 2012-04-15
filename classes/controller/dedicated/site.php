<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dedicated_Site extends Controller_Application {

	public function before()
	{
		parent::before();

		if (Kohana::$config->load('dedicated.modules.i18n'))
		{
			I18n::source('db');
		}
	}

	public function after()
	{
		$this->template
			->set('flashes', Hint::render(NULL, TRUE, 'hint/site'));

		parent::after();
	}

}