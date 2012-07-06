<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dedicated_CMS_Account extends Controller_CMS {

	public function action_index()
	{
		$this->template
			->bind('errors', $errors)
			->bind('user', $user)
			->bind('forgot', $forgot);

		$user = Auth::instance()->get_user();

		if ($this->request->method() == Request::POST)
		{
			$validator = Validation::factory($_POST)
				->labels(array(
					'password'         => __('cms.label.password'),
					'password_confirm' => __('cms.label.password_confirm'),
				))
  			->rule('password', 'not_empty')
  			->rule('password', 'min_length', array(':value', 3))
  			->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));

			if ($validator->check())
			{
				$user
					->set(array(
						'password' => Arr::get($_POST, 'password'),
					))
					->save();

				Hint::set(Hint::SUCCESS, __('cms.password.changed'));

				$this->request->redirect(Route::get('cms-account-index')->uri());
			}
			else
			{
				$errors = $validator->errors('model');
			}
		}
	}

}