<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'default' => array(
		'environment' => array(
			'cache' => APPPATH.'cache',
		),
		'loader' => array(
			'extension' => 'twig',
		),
		'extensions' => array(
			'Twig_Extension_Application',
		),
	),
);