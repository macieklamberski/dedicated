<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Behavior_Positionable extends Jelly_Behavior {

	protected $_conditions = array();
	protected $_min_position = array();

	public function __construct($options = array())
	{
		parent::__construct($options);

		$this->_conditions = Arr::get($options, 'conditions');
		$this->_min_position = Arr::get($options, 'min_position', 1);
	}

	public function model_before_save($model)
	{
		if ( ! $model->loaded())
		{
			$query = DB::select(DB::expr('MAX(position) + 1'))
				->from($model->meta()->table());

			if ( ! empty($this->_conditions))
			{
				foreach ($this->_conditions as $condition)
				{
					$query->where($condition[0], $condition[1], $condition[2]);
				}
			}

			$position = $query
				->execute()
				->get('MAX(position) + 1');

			$model->position = max($this->_min_position, $position);
		}
	}

}