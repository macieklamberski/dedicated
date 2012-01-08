<?php defined('SYSPATH') or die('No direct script access.');

class Controller_CMF_Admin_Settings extends Controller_Admin {

	public function action_index()
	{
		$this->template
			->set('settings', Settings::get());

		if ($this->request->method() == Request::POST)
		{
			// Setting new password to panel
			if ( ! empty($_POST['admin_password']))
			{
				Jelly::query('setting')
					->by_key('admin_password')
					->set(array('value' => Auth::instance()->hash_password($_POST['admin_password'])))
					->update();
			}

			unset($_POST['admin_password']);

			// Updating values of all other defined settings
			foreach ($_POST as $key => $value)
			{
				Jelly::query('setting')
					->by_key($key)
					->set(array('value' => $value))
					->update();
			}

			Hint::set(Hint::SUCCESS, __('admin.settings.updated'));

			$this->request->redirect(Route::get('admin-settings-index')->uri());
		}
	}

}