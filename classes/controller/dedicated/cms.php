<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dedicated_CMS extends Controller_Application {

	public function before()
	{
		// Make sure that the user is logged in
		if ($this->request->route() != Route::get('cms-session-login') && ! Auth::instance()->logged_in())
		{
			$this->request->redirect(Route::get('cms-session-login')->uri());
		}

		// Remember last visited page
		if ($this->request->method() == Request::GET && Session::instance()->get('back') != $this->request->referrer())
		{
			Session::instance()->set('back', $this->request->referrer());
		}

		// Set default number of records per page
		if (isset($_GET['per_page']))
		{
			Session::instance()->set('per_page', $this->request->query('per_page') == 'all' ? 2147483647 : $this->request->query('per_page'));

			$this->request->redirect(Request::detect_uri());
		}

		parent::before();

		$this->template
			->set('affected_ids', Session::instance()->get('affected_ids'));
	}

	public function after()
	{
		Session::instance()->set('affected_ids', array());

		$this->template
			->set('flashes', Hint::render(NULL, TRUE, 'hint/cms'));

		parent::after();
	}

}