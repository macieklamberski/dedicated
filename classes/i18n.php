<?php defined('SYSPATH') or die('No direct script access.');

class I18n extends Kohana_I18n {

	protected static $_translations;

	public static function get($string, $lang = NULL)
	{
		if ( ! $lang)
		{
			$lang = I18n::$lang;
		}

		// Caching loaded translations
		if (empty(self::$_translations[$lang]))
		{
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