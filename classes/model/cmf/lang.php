<?php defined('SYSPATH') or die('No direct script access.');

class Model_CMF_Lang extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'name' => Jelly::field('string'),
			'code' => Jelly::field('string'),
			'order' => Jelly::field('integer', array(
				'unique' => TRUE,
				'orderable' => TRUE,
			)),
		));

		$meta->primary_key('code');

		$meta->sorting(array('order' => 'DESC'));
	}

}