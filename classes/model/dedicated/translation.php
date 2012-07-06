<?php defined('SYSPATH') or die('No direct script access.');

class Model_Dedicated_Translation extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'lang' => Jelly::field('belongsto', array(
				'column' => 'lang_code',
			)),
			'editable' => Jelly::field('boolean'),
			'textarea' => Jelly::field('boolean'),
			'label' => Jelly::field('string'),
			'category' => Jelly::field('string'),
			'key' => Jelly::field('string'),
			'value' => Jelly::field('text'),
		));

		$meta->table('i18n');

		$meta->load_with(array('lang'));
	}

}