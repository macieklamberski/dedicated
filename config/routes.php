<?php defined('SYSPATH') or die('No direct script access.');

//-- CMS -----------------------------------------------------------------------

if (Kohana::$config->load('cmf.modules.cms'))
{
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