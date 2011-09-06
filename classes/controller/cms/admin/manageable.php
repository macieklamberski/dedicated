<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_CMS_Admin_Manageable extends Controller_Admin {

	protected static $_model_name;
	protected static $_model_class;
	protected static $_messages;

	public function before()
	{
		parent::before();

		self::$_messages = array(
			'add'    => __(':model został pomyślnie dodany.'),
			'edit'   => __(':model został pomyślnie zaktualizowany.'),
			'delete' => __(':model został pomyślnie usunięty.'),
		);

    // Trying to generate model name based on controller's name
    self::$_model_class = Inflector::singular(str_replace('Controller_Admin_', '', get_class($this)));
    self::$_model_name = ucfirst(self::$_model_name);
	}

	public function action_index()
	{
		$plural_model_class = Inflector::plural(self::$_model_class);

		$this->template
			->bind('pagination', $pagination)
			->bind($plural_model_class, $records)
			->bind($plural_model_class.'_count', $records_count);

		$query = Jelly::query(self::$_model_class)->by_lang($this->request->param('lang'));

		$pagination = Pagination::factory(array(
			'group' => 'admin',
			'total_items' => $query->count(),
		));

		$records = $query->paginate($pagination)->select();
		$records_count = Jelly::query(self::$_model_class)->count();
	}

	public function action_position()
	{
		$positions = Arr::get($_GET, 'positions', array());

		foreach ($positions as $id => $position)
		{
			Jelly::query(self::$_model_class)
				->set(array('position' => $position))
				->where(':primary_key', '=', $id)
				->update();
		}

		die;
	}

	public function action_add()
	{
		$this->template
			->bind('errors', $errors)
			->bind(self::$_model_class, $record);

		$record = Jelly::factory(self::$_model_class);

		if ($this->request->method() == Request::POST)
		{
			try
			{
				$record
					->set($_POST)
					->set($_FILES)
					->save();

				Hint::set(Hint::SUCCESS, self::$_messages['add'], array(':model' => self::$_model_name));

				$this->request->redirect(Session::instance()->get('back'));
			}
			catch (Jelly_Validation_Exception $e)
			{
				$errors = $e->errors();
			}
		}
	}

	public function action_edit()
	{
		$this->template
			->bind('errors', $errors)
			->bind(self::$_model, $record);

		$record = Jelly::query(self::$_model, $this->request->param('id'))->find();

		if ($this->request->method() == Request::POST)
		{
			try
			{
				$record
					->set($_POST)
					->set($_FILES)
					->save();

				Hint::set(Hint::SUCCESS, self::$_messages['edit'], array(':model' => self::$_model_name));

				$this->request->redirect(Session::instance()->get('back'));
			}
			catch (Jelly_Validation_Exception $e)
			{
				$errors = $e->errors();
			}
		}
	}

	public function action_delete()
	{
		Jelly::query(self::$_model, $this->request->param('id'))
			->find()
			->delete();

		Hint::set(Hint::SUCCESS, self::$_messages['delete'], array(':model' => self::$_model_name));

		$this->request->redirect(Session::instance()->get('back'));
	}

}