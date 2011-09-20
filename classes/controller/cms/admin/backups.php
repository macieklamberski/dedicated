<?php defined('SYSPATH') or die('No direct script access.');

class Controller_CMS_Admin_Backups extends Controller_Admin {

	protected $prefix;

	public function before()
	{
		parent::before();

		require Kohana::find_file('vendor', 'Archive/Tar');

		$this->prefix = URL::title(Settings::get('project_name')).'-';

		// Deleting old backup files
		$backups = array_merge(
			glob(APPPATH.'cache/'.$this->prefix.'files-*'),
			glob(APPPATH.'cache/'.$this->prefix.'database-*')
		);

		foreach ($backups as $backup)
		{
			@unlink($backup);
		}
	}

	public function action_index() {}

	public function action_database()
	{
		$tables = DB::query(Database::SELECT, 'SHOW TABLES')->execute()->as_array();

		// Create CSV file from each table data
		foreach ($tables as $table)
		{
			$table = reset($table);
			$file = APPPATH.'cache/'.$table.'.csv';
			$files[] = $file;

			$file = fopen($file, 'w');

			$table_content = DB::query(Database::SELECT, 'SELECT * FROM '.$table)->execute()->as_array();

			foreach ($table_content as $record)
			{
				fputcsv($file, $record);
			}

			unset($table_content);
			fclose($file);
		}

		// Create archive file from all CSV files
		$archive_file = APPPATH.'cache/'.$this->prefix.'database-'.date('Y-m-d-H.i.s').'.tar.gz';
		$archive = new Archive_Tar($archive_file, 'gz');
		$archive->create($files);

		// Delete CSV files
		foreach ($files as $file)
		{
			@unlink($file);
		}

		// Send file to download
		$this->response->send_file($archive_file);
	}

	public function action_files()
	{
		// Scan all files
		$files = self::array_flatten(Kohana::list_files('', array(DOCROOT)));

		$archive_file = APPPATH.'cache/'.$this->prefix.'files-'.date('Y-m-d-H.i.s').'.tar.gz';
		$archive = new Archive_Tar($archive_file, 'gz');
		$archive->create($files);

		// Send file to download
		$this->response->send_file($archive_file);
	}

	protected function array_flatten($array, $return = array())
	{
		foreach ($array as $value)
		{
			if (is_array($value))
			{
				$return = self::array_flatten($value, $return);
			}
			else
			{
				$return[] = $value;
			}
		}

		return $return;
	}

}