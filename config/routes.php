<?php defined('SYSPATH') or die('No direct script access.');

//-- Admin ---------------------------------------------------------------------

// Index
Route::set('admin-index', 'cms')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'index',
	));

// Backups
Route::set('admin-backups-index', 'cms/backups(/<action>)', array(
		'action' => 'database|files',
	))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'backups',
	));

// Login
Route::set('admin-session-login', 'cms/login')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'session',
		'action'     => 'login',
	));
	
// Logout
Route::set('admin-session-logout', 'cms/logout')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'session',
		'action'     => 'logout',
	));

// Settings
Route::set('admin-settings-index', 'cms/settings')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'settings',
	));

// Translations
Route::set('admin-translations-index', 'cms/translations')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'translations',
	));