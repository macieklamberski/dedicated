<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Behavior_Orderable extends Jelly_Behavior {

	protected $_fields = array();

	public function meta_before_finalize($meta)
	{
		foreach ($meta->fields() as $name => $field)
		{
			if (property_exists($field, 'orderable'))
			{
				// Remember orderable fields
				$this->_fields[] = $name;

				$field->orderable = array(
					'min_value' => Arr::get($field->orderable, 'min_value', 1),
					'max_value' => Arr::get($field->orderable, 'max_value', 2147483647),
				);
			}
		}
	}

	public function model_before_save($model)
	{
		foreach ($this->_fields as $field)
		{
			if ( ! $model->loaded())
			{
				$query = DB::select(DB::expr('MAX('.$field.') + 1'))
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
					->get('MAX('.$field.') + 1');

				$model->{$field} = max($this->_min_position, $position);
			}
		}
	}

}