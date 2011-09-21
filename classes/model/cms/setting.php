<?php defined('SYSPATH') or die('No direct script access.');

class Model_CMS_Setting extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'key' => Jelly::field('string'),
			'value' => Jelly::field('text'),
			'default' => Jelly::field('text'),
			'editable' => Jelly::field('boolean', array(
				'default' => TRUE,
			)),
		));

		$meta->primary_key('key');
	}

}