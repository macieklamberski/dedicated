<?php defined('SYSPATH') or die('No direct script access.');

class Twig_Extension_Dedicated_Application extends Twig_Extension {

	public function getFilters()
	{
		return array(
			'fversion'   => new Twig_Filter_Function('twig_fversion'),
			'replace'    => new Twig_Filter_Function('twig_replace'),
			'route_name' => new Twig_Filter_Function('twig_route_name'),
			'has_string' => new Twig_Filter_Function('twig_has_string'),
		);
	}

	public function getName()
	{
		return 'twig_application';
	}

}

function twig_fversion($filename)
{
	if ( ! file_exists($filename))
	{
		return $filename;
	}

	return $filename.'?'.filemtime($filename);
}

function twig_replace($string, $from = '', $to = '')
{
	return str_replace($from, $to, $string);
}

function twig_route_name($route)
{
	return Route::name($route);
}

function twig_has_string($string, $searched)
{
	return (strpos($string, $searched) !== FALSE);
}