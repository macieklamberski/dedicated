<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Behavior_Sluggable extends Jelly_Behavior {

	public function model_before_save($model)
	{
		foreach ($model->meta()->fields() as $name => $field)
		{
			switch (get_class($field))
			{
				// Generate slug from field given in "source" parameter
				case 'Jelly_Field_Slug':
					if (isset($field->source))
					{
						$model->{$name} = $model->{$field->source};
					}
				break;
			}
		}
	}

}