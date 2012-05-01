<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dedicated_CMS_Password extends Controller_CMS {

	public function before()
	{
		if (Auth::instance()->logged_in('admin'))
		{
			$this->request->redirect(Route::get('cms-index')->uri());
		}

		parent::before();
	}

	public function action_forgot()
	{
		if ($this->request->method() == Request::POST)
		{
			$user = Jelly::query('user')->by_username(Arr::get($_POST, 'username'))->select_one(FALSE);

			if ($user->loaded())
			{
				$hash = Text::random();
				$_POST['link']     = Route::get('cms-password-change')->uri(array('hash' => $hash));
				$_POST['user']     = $user;
				$_POST['settings'] = $this->template->settings;
				$_POST['base_url'] = $this->template->base_url;

				Jelly::factory('forgot')
					->set(array(
						'user' => $user,
						'hash' => $hash,
					))
					->save();

				Email::factory()
					->from('no-reply@'.Arr::get($_SERVER, 'SERVER_NAME'))
					->to($user->email)
					->subject(Settings::get('project_name').' CMS: '.__('cms.password.link_subject'))
					->message(Twig::factory('mails/password/forgot', $_POST))
					->send();

				Hint::set(Hint::SUCCESS, __('cms.password.link_sent'));

				$this->request->redirect(Route::get('cms-password-sent')->uri());
			}
		}
	}

	public function action_sent() {}

	public function action_change()
	{
		$this->template
			->bind('errors', $errors)
			->bind('user', $user)
			->bind('forgot', $forgot);

		$forgot = Jelly::query('forgot')
			->by_hash($this->request->param('hash'))
			->select_one(FALSE);

		$user = Jelly::query('user')
			->by_id($forgot->user->id())
			->select_one(FALSE);

		if ( ! $forgot->expired() && $user->loaded() && $this->request->method() == Request::POST)
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

				Jelly::query('forgot')->by_user_id($user->id())->delete();

				Hint::set(Hint::SUCCESS, __('cms.password.changed'));

				$this->request->redirect(Route::get('cms-session-login')->uri());
			}
			else
			{
				$errors = $validator->errors('model');
			}
		}
	}

}