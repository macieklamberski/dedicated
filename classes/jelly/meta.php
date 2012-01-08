<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Meta extends Jelly_Core_Meta {

	public function finalize($model)
	{
		// Include all special behaviors
		$this->behaviors(array(
			Jelly::behavior('dependable'),
			Jelly::behavior('orderable'),
			Jelly::behavior('sluggable'),
			Jelly::behavior('translatable'),
		));

		parent::finalize($model);
	}

}