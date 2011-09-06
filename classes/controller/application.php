<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Application extends Controller_Template_Twig {

	public function before()
	{
		parent::before();

		$this->template
			->set('current_uri',  Request::detect_uri() ? Request::detect_uri() : Kohana::$base_url)
			->set('current_url',  preg_replace('#'.Request::detect_uri().'$#', '', URL::base('http')))
			->set('base_uri',     Kohana::$base_url)
			->set('base_url',     preg_replace('#'.Kohana::$base_url.'$#', '', URL::base('http')))
			->set('settings',     Settings::get())
			->bind('request',     $this->request)
			->bind('environment', $environment)
			->bind('langs',       $langs);

		switch (Kohana::$environment)
		{
			case Kohana::PRODUCTION:
				$environment = 'production';
			break;
			case Kohana::STAGING:
				$environment = 'staging';
			break;
			case Kohana::TESTING:
				$environment = 'testing';
			break;
			case Kohana::DEVELOPMENT:
				$environment = 'development';
			break;
		}

		$langs = Jelly::query('lang')->select();
	}

}