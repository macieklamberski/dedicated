<?php defined('SYSPATH') or die('No direct script access.');

//-- Admin ---------------------------------------------------------------------

/* Assets */

Route::set('admin-media-padamni', 'padamini(/<file>)', array('file' => '.+'))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'media',
		'action'     => 'show',
		'path'       => 'vendor/padamini/www',
		'file'       => NULL,
	));

Route::set('admin-media-cms', 'cms/scripts/cms.js', array('file' => '.+'))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'media',
		'action'     => 'show',
		'path'       => NULL,
		'file'       => '/scripts/cms.js',
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