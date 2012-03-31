<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Define customized __() function.
 */
function __($string, array $values = NULL, $lang = 'en')
{
	if ($lang !== I18n::$lang)
	{
		$string = I18n::get($string);
	}

	return empty($values) ? $string : strtr($string, $values);
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' env variable has been supplied.
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Setting base_url from RewriteBase directive placed in .htaccess.
 */
Kohana::$base_url = preg_replace('/.*RewriteBase\s([^\n]+).*/s', '$1', file_get_contents('.htaccess'));

/**
 * Set default Kohana options.
 */
switch (Kohana::$environment)
{
	case Kohana::DEVELOPMENT:
	case Kohana::TESTING:
		Kohana::$index_file = FALSE;
		Kohana::$profiling = TRUE;
		Kohana::$caching = FALSE;
	break;
	case Kohana::PRODUCTION:
	default:
		Kohana::$index_file = FALSE;
		Kohana::$profiling = FALSE;
		Kohana::$caching = TRUE;
	break;
}

/**
 * Load routes from external config files.
 */
if ( ! Route::cache())
{
	Kohana::$config->load('routes');

	Route::cache(Kohana::$environment == Kohana::PRODUCTION);
}