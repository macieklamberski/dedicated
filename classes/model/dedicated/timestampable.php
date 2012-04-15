<?php defined('SYSPATH') or die('No direct script access.');

abstract class Model_Dedicated_Timestampable extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'created_at' => Jelly::field('datetime', array(
				'auto_now_create' => TRUE,
			)),
			'updated_at' => Jelly::field('datetime', array(
				'auto_now_update' => TRUE,
			)),
		));
	}

}