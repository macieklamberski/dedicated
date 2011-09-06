<?php defined('SYSPATH') or die('No direct script access.');

class Model_Setting extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'key' => Jelly::field('string'),
			'value' => Jelly::field('text'),
			'default' => Jelly::field('text'),
		));
	}

}