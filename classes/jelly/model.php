<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Model extends Jelly_Core_Model {

	public function load_values($values)
	{
		parent::load_values($values);

		$this->load_translations();

		// Setting original value for translated Image/File fields
		foreach ($this->meta()->fields() as $name => $field)
		{
			if ( ! $field->in_db && ! isset($this->_original[$name]))
			{
				$this->_original[$name] = $this->get($name);
			}
		}

		return $this;
	}

	public function save($validation = NULL)
	{
		$this->clear_translated_fields();

		foreach ($this->meta()->fields() as $name => $field)
		{
			if ( ! $field->in_db && $field instanceof Jelly_Field_File)
			{
				if (isset($this->_changed[$name]) && is_string($this->_changed[$name]))
				{
					unset($this->_changed[$name]);
				}
			}
		}

		return parent::save($validation);
	}

}