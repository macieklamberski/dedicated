<?php defined('SYSPATH') or die('No direct script access.');

class Controller_CMS_Site extends Controller_Application {

	public function before()
	{
		parent::before();

		$current_lang = $this->request->param('lang', Settings::get('site_default_lang'));

		foreach ($this->template->langs as $existing_lang)
		{
			if ($current_lang == $existing_lang->code)
			{
				$this->lang = $existing_lang;
			}
		}

		if (empty($this->lang))
		{
			throw new HTTP_Exception_404;
		}

		I18n::lang($this->lang->code);

		$this->template
			->set('lang', $this->lang);
	}

	public function after()
	{
		$this->template
			->set('flashes', Hint::render());

		parent::after();
	}

}