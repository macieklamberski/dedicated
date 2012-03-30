<?php defined('SYSPATH') or die('No direct script access.');
echo 'nagusame';
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
 * Initialize Kohana, setting the default options.
 */
switch (Kohana::$environment)
{
	case Kohana::DEVELOPMENT:
	case Kohana::TESTING:
		Kohana::init(array(
			'base_url'   => Kohana::$base_url,
			'index_file' => FALSE,
			'profiling'  => TRUE,
			'caching'    => FALSE,
		));
	break;
	case Kohana::PRODUCTION:
	default:
		Kohana::init(array(
			'base_url'   => Kohana::$base_url,
			'index_file' => FALSE,
			'profiling'  => FALSE,
			'caching'    => TRUE,
		));
	break;
}

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Attach e-mail logging module on testing and production environment.
 */
if (Kohana::$environment != Kohana::DEVELOPMENT)
{
	Kohana::$log->attach(new Log_Watchy(Arr::get($_SERVER['SERVER_NAME']), array('maciej@lamberski.com')), Log::CRITICAL);
}

/**
 * Load routes from external config files.
 */
if ( ! Route::cache())
{
	Kohana::$config->load('routes');

	Route::cache(Kohana::$environment == Kohana::PRODUCTION);
}