<?php defined('SYSPATH') or die('No direct script access.');

//-- Admin ---------------------------------------------------------------------

// Padamini's assets (CSS, JS, images)
Route::set('admin-media-show', 'admin(/<file>)', array('file' => '.+'))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'media',
		'action'     => 'show',
		'file'       => NULL,
	));

/* Index */

Route::set('admin-index', 'administration')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'index',
	));

/* Session */

Route::set('admin-session-login', 'administration/login')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'session',
		'action'     => 'login',
	));

Route::set('admin-session-logout', 'administration/logout')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'session',
		'action'     => 'logout',
	));

/* Settings and Translations */

foreach (array('settings', 'translations') as $module)
{
	Route::set('admin-'.$module.'-index', 'administration/'.$module)
		->defaults(array(
			'directory'  => 'admin',
			'controller' => $module,
		));
}

return array();