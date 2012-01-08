<?php defined('SYSPATH') or die('No direct script access.');

$route_prefix = trim(Kohana::$config->load('cmf.route_prefix'), '/');

//-- Admin ---------------------------------------------------------------------

// Media
Route::set('admin-media-padamni', 'padamini(/<file>)', array('file' => '.+'))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'media',
		'action'     => 'show',
		'path'       => 'vendor/padamini/www',
		'file'       => NULL,
	));

Route::set('admin-media-cms', $route_prefix.'/scripts/cms.js', array('file' => '.+'))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'media',
		'action'     => 'show',
		'path'       => NULL,
		'file'       => '/scripts/cms.js',
	));

// Index
Route::set('admin-index', $route_prefix)
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'index',
	));

// Backups
Route::set('admin-backups', $route_prefix.'/backups(/<action>)', array(
		'action' => 'database|files',
	))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'backups',
	));

// Session
Route::set('admin-session-login', $route_prefix.'/login')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'session',
		'action'     => 'login',
	));

Route::set('admin-session-logout', $route_prefix.'/logout')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'session',
		'action'     => 'logout',
	));

// Settings and Translations
foreach (array('settings', 'translations') as $module)
{
	Route::set('admin-'.$module.'-index', $route_prefix.'/'.$module)
		->defaults(array(
			'directory'  => 'admin',
			'controller' => $module,
		));
}

return array();