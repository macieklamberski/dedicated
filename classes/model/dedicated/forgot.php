<?php defined('SYSPATH') or die('No direct script access.');

class Model_Dedicated_Forgot extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'user' => Jelly::field('belongsto'),
			'hash' => Jelly::field('string'),
			'expired_at' => Jelly::field('timestamp'),
		));
	}

	public function save($validation = NULL)
	{
		$this->expired_at = time() + 6400;

		return parent::save($validation);
	}

	public function expired()
	{
		return $this->expired_at < time();
	}

}