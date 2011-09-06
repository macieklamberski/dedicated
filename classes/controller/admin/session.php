<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Session extends Controller_Admin {

	public function action_login()
	{
		if (Auth::instance()->logged_in())
		{
			$this->request->redirect(Route::get('admin-index')->uri());
		}

		$this->template
			->bind('form', $_POST);

		if ($this->request->method() == Request::POST)
		{
			if (Auth::instance()->login('admin', Arr::get($_POST, 'password')))
			{
				$this->request->redirect(Route::get('admin-index')->uri());
			}
		}
	}

	public function action_logout()
	{
		if (Auth::instance()->logged_in())
		{
			Auth::instance()->logout();
		}

		$this->request->redirect(Route::get('admin-index')->uri());
	}

}