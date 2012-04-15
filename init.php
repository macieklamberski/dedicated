<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Define customized __() function.
 */
if ( ! function_exists('__'))
{
	function __($string, array $values = NULL, $lang = 'en')
	{
		if ($lang !== I18n::$lang)
		{
			$string = I18n::get($string);
		}

		return empty($values) ? $string : strtr($string, $values);
	}
}