<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Behavior_Translatable extends Jelly_Behavior {

	protected static $_langs = array();
	public $_fields = array();

	public function meta_before_finalize($meta)
	{
		// Find and gather all translatable fields in model
		foreach ($meta->fields() as $name => $field)
		{
			if (isset($field->translatable) && $field->translatable)
			{
				// Remember translatable fields
				$this->_fields[] = $name;
			}
		}

		// Load and remember all languages if model is translatable
		if ( ! empty($this->_fields) && empty(self::$_langs))
		{
			$langs = Jelly::query('lang')->select();

			foreach ($langs as $lang)
			{
				self::$_langs[$lang->code] = $lang->name;
			}
		}

		// Cerate temporary translatable field
		foreach ($meta->fields() as $name => $field)
		{
			if (in_array($name, self::$_langs))
			{
				// Setting main translation field as not in database
				$field->in_db = FALSE;

				// Creating mock fields for each lang
				foreach (self::$_langs as $lang => $lang_name)
				{
					$new_field = clone $field;
					$new_field->label .= ' ('.$lang_name.')';

					$meta->fields(array(
						$name.'_'.$lang => $new_field,
					));
				}

				// Clearing rules for main field
				$field->rules = array();
			}
		}
	}

	public function model_call_clear_translated_fields($model)
	{
		foreach ($model->meta()->fields() as $name => $field)
		{
			if (in_array($name, $this->_fields))
			{
				// Clearing rules for main field added after before_finalize (File/Image field)
				$field->rules = array();
			}
		}
	}

	public function model_call_load_translations($model)
	{
		// Stop if in model there's no translatable fields
		if (empty($this->_fields))
		{
			return FALSE;
		}

		$translations = DB::select()
			->from($model->meta()->table().'_translations')
			->where('record_id', '=', $model->id())
			->as_object()
			->execute();

		foreach ($translations as $translation)
		{
			foreach ($this->_fields as $field)
			{
				$model->{$field.'_'.$translation->lang_id} = $translation->{$field};

				if ($translation->lang_id == I18n::lang())
				{
					$model->{$field} = $translation->{$field};
				}
			}
		}
	}

	public function model_after_save($model)
	{
		$updated_translations = array();

		foreach ($this->_fields as $field)
		{
			foreach (self::$_langs as $lang => $lang_name)
			{
				if ($model->meta()->field($field) instanceof Jelly_Field_File)
				{
					$updated_translations[$lang][$field] = $model->meta()->field($field.'_'.$lang)->save($model, $model->{$field.'_'.$lang}, $model->id());
				}
				else
				{
					$updated_translations[$lang][$field] = $model->{$field.'_'.$lang};
				}
			}
		}

		foreach ($updated_translations as $lang => $pairs)
		{
			$exists = (bool) DB::select()
				->from($model->meta()->table().'_translations')
				->where('lang_id', '=', $lang)
				->where('record_id', '=', $model->id())
				->execute()
				->count();

			if ($exists)
			{
				DB::update($model->meta()->table().'_translations')
					->where('lang_id', '=', $lang)
					->where('record_id', '=', $model->id())
					->set($pairs)
					->execute();
			}
			else
			{
				$values = array_merge(
					array('lang_id' => $lang, 'record_id' => $model->id()),
					$updated_translations[$lang]
				);

				DB::insert($model->meta()->table().'_translations', array_keys($values))
					->values($values)
					->execute();
			}
		}
	}

	public function model_before_delete($model)
	{
		parent::model_before_delete($model);

		DB::delete($model->meta()->table().'_translations')
			->where('record_id', '=', $model->id())
			->execute();
	}

}