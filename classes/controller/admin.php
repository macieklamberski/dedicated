<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Application {

	public function before()
	{
		// Make sure that the user is logged in
		if ($this->request->route() != Route::get('admin-session-login') && ! Auth::instance()->logged_in())
		{
			$this->request->redirect(Route::get('admin-session-login')->uri());
		}

		// Remember last visited page
		if ($this->request->method() == Request::GET && Session::instance()->get('back') != $this->request->referrer())
		{
			Session::instance()->set('back', $this->request->referrer());
		}

		// Set default number of records per page
		if (isset($_GET['per_page']))
		{
			Session::instance()->set('per_page', $_GET['per_page'] == 'all' ? 2147483647 : $_GET['per_page']);

			$this->request->redirect(Request::detect_uri());
		}

		parent::before();
	}

	public function after()
	{
		parent::after();

		$this->template
			->set('flashes', Hint::get());
	}

}