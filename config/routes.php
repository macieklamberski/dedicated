<?php defined('SYSPATH') or die('No direct script access.');

//-- CMS -----------------------------------------------------------------------

if (Kohana::$config->load('dedicated.modules.cms'))
{
	// Static file serving (CSS, JS, images)
	Route::set('cms-media-index', 'padamini(/<file>)', array('file' => '.+'))
		->defaults(array(
			'directory'  => 'cms',
			'controller' => 'media',
		));

	// Index
	Route::set('cms-index', 'cms')
		->defaults(array(
			'directory'  => 'cms',
			'controller' => 'index',
		));

	// Backups
	Route::set('cms-backups-index', 'cms/backups(/<action>)', array(
			'action' => 'database|files',
		))
		->defaults(array(
			'directory'  => 'cms',
			'controller' => 'backups',
		));

	// Forgot Password
	Route::set('cms-password-forgot', 'cms/password/forgot')
		->defaults(array(
			'directory'  => 'cms',
			'controller' => 'password',
			'action'     => 'forgot',
		));

	// Change Password Link Sent
	Route::set('cms-password-sent', 'cms/password/sent')
		->defaults(array(
			'directory'  => 'cms',
			'controller' => 'password',
			'action'     => 'sent',
		));

	// Change Forgot Password
	Route::set('cms-password-change', 'cms/password/change/<hash>', array(
			'hash' => '[a-zA-Z0-9]+',
		))
		->defaults(array(
			'directory'  => 'cms',
			'controller' => 'password',
			'action'     => 'change',
		));

	// Login
	Route::set('cms-session-login', 'cms/login')
		->defaults(array(
			'directory'  => 'cms',
			'controller' => 'session',
			'action'     => 'login',
		));

	// Logout
	Route::set('cms-session-logout', 'cms/logout')
		->defaults(array(
			'directory'  => 'cms',
			'controller' => 'session',
			'action'     => 'logout',
		));

	// Settings
	Route::set('cms-settings-index', 'cms/settings')
		->defaults(array(
			'directory'  => 'cms',
			'controller' => 'settings',
		));

	// Translations
	Route::set('cms-translations-index', 'cms/translations')
		->defaults(array(
			'directory'  => 'cms',
			'controller' => 'translations',
		));
}