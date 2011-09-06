<?php defined('SYSPATH') or die('No direct script access.');

class Model_Translation extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'lang' => Jelly::field('belongsto'),
			'editable' => Jelly::field('boolean'),
			'key' => Jelly::field('string'),
			'value' => Jelly::field('text'),
		));

		$meta->load_with(array('lang'));
	}

}