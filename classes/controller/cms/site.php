<?php defined('SYSPATH') or die('No direct script access.');

class Controller_CMS_Site extends Controller_Application {

	public function after()
	{
		$this->template
			->set('flashes', Hint::render());

		parent::after();
	}

}