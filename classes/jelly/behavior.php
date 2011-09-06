<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Behavior extends Jelly_Core_Behavior {

	public function builder_before_delete($builder)
	{
		$records = $builder->select();

		foreach ($records as $record)
		{
			$record->delete();
		}
	}

	public function model_before_save($model)
	{
		foreach ($model->meta()->fields() as $name => $field)
		{
			switch (get_class($field))
			{
				case 'Jelly_Field_Slug':
					if (isset($field->source))
					{
						$model->{$name} = $model->{$field->source};
					}
				break;
			}
		}
	}

	public function model_before_delete($model)
	{
		foreach ($model->meta()->fields() as $name => $field)
		{
			switch (get_class($field))
			{
				case 'Jelly_Field_Image':
					$file = $model->{$name};
					$field->thumbnails[] = (array) $field;

					foreach ($field->thumbnails as $thumbnail)
					{
						$path = $thumbnail['path'].(isset($thumbnail['prefix']) ? $thumbnail['prefix'].$file : $file);

						if (file_exists($path) && is_file($path))
						{
							unlink($path);
						}
					}
				break;
				case 'Jelly_Field_File':
					$path = $field->path.$model->{$name};

					if (file_exists($path) && is_file($path))
					{
						unlink($path);
					}
				break;
				case 'Jelly_Field_HasOne':
					if (isset($field->dependent) && $field->dependent)
					{
						$model->{$name}->delete();
					}
				break;
				case 'Jelly_Field_HasMany':
					if (isset($field->dependent) && $field->dependent)
					{
						foreach ($model->{$name} as $dependent)
						{
							$dependent->delete();
						}
					}
				break;
			}
		}
	}

}