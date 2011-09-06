<?php defined('SYSPATH') or die('No direct script access.');

abstract class Model_Resource extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'created_at' => Jelly::field('timestamp', array(
				'format' => 'Y-m-d H:i:s',
				'auto_now_create' => TRUE,
			)),
			'updated_at' => Jelly::field('timestamp', array(
				'format' => 'Y-m-d H:i:s',
				'auto_now_update' => TRUE,
			)),
		));
	}

}