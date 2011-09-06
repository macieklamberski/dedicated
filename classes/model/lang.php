<?php defined('SYSPATH') or die('No direct script access.');

class Model_Lang extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->behaviors(array(
			Jelly::behavior('positionable'),
		));

		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'code' => Jelly::field('string'),
			'position' => Jelly::field('integer'),
		));

		$meta->sorting(array('position' => 'DESC', 'id' => 'DESC'));
	}

}