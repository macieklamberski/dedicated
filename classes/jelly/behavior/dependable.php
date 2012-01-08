<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Behavior_Dependable extends Jelly_Behavior {

	public function builder_before_delete($builder)
	{
		$records = $builder->select();

		foreach ($records as $record)
		{
			$record->delete();
		}
	}

	public function model_before_delete($model)
	{
		foreach ($model->meta()->fields() as $name => $field)
		{
			switch (get_class($field))
			{
				// Delete all image files associated with field
				case 'Jelly_Field_Image':
					if (isset($field->dependent) && $field->dependent)
					{
						$filename = $model->{$name};
						$images = array_merge($field->thumbnails, array($field));

						foreach ($images as $image)
						{
							$filepath = $image['path'].(isset($image['prefix']) ? $image['prefix'].$filename : $filename);

							if (file_exists($filepath) && is_file($filepath))
							{
								@unlink($filepath);
							}
						}
					}
				break;

				// Delete file associated with field
				case 'Jelly_Field_File':
					if (isset($field->dependent) && $field->dependent)
					{
						$filepath = $field->path.$model->{$name};

						if (file_exists($filepath) && is_file($filepath))
						{
							@unlink($filepath);
						}
					}
				break;

				// Delete dependent HasOne association
				case 'Jelly_Field_HasOne':
					if (isset($field->dependent) && $field->dependent)
					{
						$model->{$name}->delete();
					}
				break;

				// Delete dependent HasMany association
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