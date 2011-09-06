<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Meta extends Jelly_Core_Meta {

	public function finalize($model)
	{
		// Loading the default Jelly_Builder to include the additional features
		if (empty($this->_behaviors))
		{
			$this->behaviors(array(new Jelly_Behavior));
		}

		parent::finalize($model);
	}

}