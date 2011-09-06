<?php defined('SYSPATH') or die('No direct script access.');

class Controller_CMS_Admin_Translations extends Controller_Admin {

	public function action_index()
	{
		$this->template
			->bind('translations', $translations);

		$records = Jelly::query('translation')->by_editable(TRUE)->select();

		$translations = array();

		foreach ($records as $record)
		{
			$translations[$record->key][$record->lang->code] = $record;
		}

		if ($this->request->method() == Request::POST)
		{
			unset($_POST['lang']);

			foreach ($_POST as $key => $translations)
			{
				foreach ($translations as $lang => $translation)
				{
					Jelly::query('translation')
						->by_key(str_replace('_', ' ', $key))
						->by_lang($lang)
						->set(array('value' => $translation))
						->update();
				}
			}

			Hint::set(Hint::SUCCESS, __('Tłumaczenia zostały zapisane.'));

			$this->request->redirect(Route::get('admin-translations-index')->uri());
		}
	}

}