<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Dedicated_CMS_Manageable extends Controller_CMS {

	protected static $_options;

	public function before(array $options = NULL)
	{
		parent::before();

		$controller_name = strtolower(str_replace('Controller_CMS_', '', get_class($this)));
    $module_name = str_replace('_', '-', $controller_name);

		$default_options = array(
			'index_route' => 'cms-'.$module_name.'-index',
			'model_class' => Inflector::singular($controller_name),
			'model_table' => $controller_name,
			'model_name'  => ucfirst(Inflector::singular($controller_name)),
			'messages'    => array(
				'add'    => __('cms.model.added'),
				'edit'   => __('cms.model.updated'),
				'delete' => __('cms.model.deleted'),
			),
		);

		self::$_options = array_merge($default_options, $options);

		$this->template
			->bind('errors',                                 $this->errors)
			->bind('pagination',                             $this->pagination)
			->bind(self::$_options['model_class'],           $this->record)
			->bind(self::$_options['model_table'],           $this->records)
			->bind(self::$_options['model_table'].'_count', $this->records_count);
	}

	protected $record;
	protected $records;
	protected $records_count;
	protected $errors;
	protected $pagination;

	protected function perform_record_actions()
	{
		if ( ! $this->record)
		{
			$this->record = Jelly::query(self::$_options['model_class'], $this->request->param('id'))->select_one();
		}

		Session::instance()->set('affected_ids', array($this->record->id()));
	}

	protected function redirect_back_or_index()
	{
		$url = Session::instance()->get('back')
			? Session::instance()->get('back')
			: Route::get(Arr::get(self::$_options, 'index_route'))->uri();

		$this->request->redirect($url);
	}

	public function action_index()
	{
		$query = Jelly::query(self::$_options['model_class'])->by_lang($this->request->param('records_lang'));

		$this->pagination = Pagination::factory(array(
			'group' => 'cms',
			'total_items' => $query->count(),
		));

		$this->records = $query->paginate($this->pagination)->select();
		$this->records_count = Jelly::query(self::$_options['model_class'])->count();

		$this->records = Jelly::query(self::$_options['model_class'])
			->by_lang($this->request->param('records_lang'))
			->paginate('cms', $this->pagination)
			->select();

		$this->records_count = Jelly::query(self::$_options['model_class'])->count();
	}

	public function action_sort()
	{
		$positions = Arr::get($_GET, 'positions', array());

		foreach ($positions as $id => $position)
		{
			Jelly::query(self::$_options['model_class'])
				->set(array('position' => $position))
				->where(':primary_key', '=', $id)
				->update();
		}

		die;
	}

	public function action_add()
	{
		$this->record = Jelly::factory(self::$_options['model_class']);

		if ($this->request->method() == Request::POST)
		{
			try
			{
				$this->record
					->set($_POST)
					->set($_FILES)
					->save();

				$this->perform_record_actions();

				Hint::set(Hint::SUCCESS, self::$_options['messages']['add'], array(':model' => self::$_options['model_name']));

				$this->redirect_back_or_index();
			}
			catch (Jelly_Validation_Exception $e)
			{
				$this->errors = $e->errors('model');
			}
		}
	}

	public function action_edit()
	{
		$this->perform_record_actions();

		if ($this->request->method() == Request::POST)
		{
			try
			{
				foreach ($_FILES as $name => $file)
				{
					if (Upload::not_empty($file))
					{
						$this->record->set($name, $file);
					}
				}

				$this->record
					->set($_POST)
					->save();

				Hint::set(Hint::SUCCESS, self::$_options['messages']['edit'], array(':model' => self::$_options['model_name']));

				$this->redirect_back_or_index();
			}
			catch (Jelly_Validation_Exception $e)
			{
				$this->errors = $e->errors('model');
			}
		}
	}

	public function action_delete()
	{
  	$this->perform_record_actions();

		$this->record->delete();

		Hint::set(Hint::SUCCESS, self::$_options['messages']['delete'], array(':model' => self::$_options['model_name']));

		$this->redirect_back_or_index();
	}

}