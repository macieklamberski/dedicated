<?php defined('SYSPATH') or die('No direct script access.');

//-- Admin ---------------------------------------------------------------------

// Padamini's assets (CSS, JS, images)
Route::set('admin-media-show', 'padamini(/<file>)', array('file' => '.+'))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'media',
		'action'     => 'show',
		'file'       => NULL,
	));

/* Index */

Route::set('admin-index', 'cms')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'index',
	));

/* Session */

Route::set('admin-session-login', 'cms/login')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'session',
		'action'     => 'login',
	));

Route::set('admin-session-logout', 'cms/logout')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'session',
		'action'     => 'logout',
	));

/* Settings and Translations */

foreach (array('settings', 'translations') as $module)
{
	Route::set('admin-'.$module.'-index', 'cms/'.$module)
		->defaults(array(
			'directory'  => 'admin',
			'controller' => $module,
		));
}

return array();