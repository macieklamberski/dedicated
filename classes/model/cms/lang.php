<?php defined('SYSPATH') or die('No direct script access.');

class Model_CMS_Lang extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->behaviors(array(
			Jelly::behavior('positionable'),
		));

		$meta->fields(array(
			'name' => Jelly::field('string'),
			'code' => Jelly::field('string'),
			'position' => Jelly::field('integer', array(
				'unique' => TRUE,
			)),
		));

		$meta->primary_key('code');

		$meta->sorting(array('position' => 'DESC'));
	}

}