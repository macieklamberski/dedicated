<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Exception extends Kohana_Kohana_Exception {

	public static function text(Exception $e)
	{
		$url = URL::site(Request::detect_uri(), 'http', FALSE);

		return parent::text($e).' ( '.$url.' )';
	}

	public static function handler(Exception $e)
	{
		if (Kohana::$environment == Kohana::DEVELOPMENT)
		{
			parent::handler($e);
		}
		else
		{
			if ($e instanceof HTTP_Exception)
			{
				try
				{
					Kohana::$log->add(Log::ERROR, Kohana_Exception::text($e));

					echo Request::factory(I18n::lang().'/404')
						->execute()
						->status($e->getCode())
						->send_headers()
						->body();
				}
				catch (Exception $e)
				{
					self::handle_fatal($e);
				}
			}
			else
			{
				self::handle_fatal($e);
			}
		}
	}

	protected static function handle_fatal(Exception $e)
	{
		Kohana::$log->add(Log::CRITICAL, Kohana_Exception::text($e));

		echo Response::factory()
			->status(500)
			->body(View::factory('errors/fatal', array('exception' => $e)))
			->send_headers()
			->body();
	}

}