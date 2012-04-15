<?php defined('SYSPATH') or die('No direct script access.');

class Controller_CMF_Admin_Translations extends Controller_Admin {

	public function action_index()
	{
		$this->template
			->bind('translations', $translations);

		$records = Jelly::query('translation')->by_editable(TRUE)->select();

		$translations = array();

		foreach ($records as $record)
		{
			$translations[base64_encode($record->key)][$record->lang->code] = $record;
		}

		if ($this->request->method() == Request::POST)
		{
			unset($_POST['lang']);

			foreach ($_POST as $key => $translations)
			{
				$key = base64_decode($key);

				foreach ($translations as $lang => $translation)
				{
					Jelly::query('translation')
						->by_key($key)
						->by_lang($lang)
						->set(array('value' => $translation))
						->update();
				}
			}

			Hint::set(Hint::SUCCESS, __('admin.translations.updated'));

			$this->request->redirect(Route::get('admin-translations-index')->uri());
		}
	}

}