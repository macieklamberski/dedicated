<?php defined('SYSPATH') or die('No direct script access.');

class Controller_CMF_Application extends Controller_Template_Twig {

	public function before()
	{
		parent::before();

		$current_uri = Request::detect_uri() ? Request::detect_uri() : Kohana::$base_url;

		$this->template
			->set('current_uri',  $current_uri)
			->set('current_url',  preg_replace('#'.$current_uri.'$#', '', URL::base('http')))
			->set('base_uri',     Kohana::$base_url)
			->set('base_url',     preg_replace('#'.Kohana::$base_url.'$#', '', URL::base('http')))
			->bind('request',     $this->request)
			->bind('environment', $environment)
			->bind('lang',        $lang)
			->bind('langs',       $langs)
			->bind('settings',    $settings);

		// Getting name of current environment
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

		if (Kohana::$config->load('cmf.modules.settings'))
		{
			$settings = Settings::get();

			I18n::lang(Settings::get($this->request->directory().'_default_lang'));
		}

		if (Kohana::$config->load('cmf.modules.multilanguage'))
		{
			$langs = Jelly::query('lang')->select();

			$current_lang = $this->request->param('lang', I18n::lang());

			foreach ($langs as $lang)
			{
				if ($current_lang == $lang->code)
				{
					$this->lang = $lang;

					I18n::lang($lang->code);

					break;
				}
			}

			// If current language is not found in database, show 404 page
			if (empty($this->lang))
			{
				throw new HTTP_Exception_404('Language ":lang" does not exist on list of supported languages.', array(
					':lang' => $current_lang,
				));
			}
		}
	}

	public function after()
	{
		parent::after();

		if (isset($_GET['profile']) && Kohana::$environment != Kohana::PRODUCTION)
		{
			$this->response->body(View::factory('profiler/stats'));
		}
	}

}