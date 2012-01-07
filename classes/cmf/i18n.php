<?php defined('SYSPATH') or die('No direct script access.');

class CMF_I18n extends Kohana_I18n {

	protected static $_translations;
	protected static $_loaded;
	protected static $_db_mode = FALSE;

	public static function db_mode($value = NULL)
	{
		if ($value)
		{
			self::$_db_mode = (bool) $value;
		}

		return I18n::$_db_mode;
	}

	public static function get($string, $lang = NULL)
	{
		if ( ! $lang)
		{
			$lang = I18n::$lang;
		}

		// Getting translation in normal way (from file)
		if ( ! I18n::db_mode())
		{
			return parent::get($string, $lang);
		}

		// Caching loaded translations
		if ( ! self::$_loaded)
		{
			self::$_loaded = TRUE;

			$translations = DB::select()
				->from('translations')
				->join('langs', 'LEFT')
				->on('langs.code', '=', 'translations.lang_id')
				->where('langs.code', '=', $lang)
				->as_object()
				->execute();

			foreach ($translations as $translation)
			{
				self::$_translations[$lang][$translation->key] = $translation->value;
			}
		}

		// Return the translated string if it exists
		return isset(self::$_translations[$lang][$string]) ? self::$_translations[$lang][$string] : $string;
	}

}