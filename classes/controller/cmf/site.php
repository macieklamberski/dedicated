<?php defined('SYSPATH') or die('No direct script access.');

class Controller_CMF_Site extends Controller_Application {

	public function before()
	{
		parent::before();

		I18n::source('db');
	}

	public function after()
	{
		$this->template
			->set('flashes', Hint::render(NULL, TRUE, 'hint/site'));

		parent::after();
	}

}