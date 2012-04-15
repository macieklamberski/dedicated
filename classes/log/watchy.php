<?php defined('SYSPATH') or die('No direct access allowed.');

class Log_Watchy extends Kohana_Log_Watchy {

	public function write(array $messages)
	{
		$this->email_content = '<h2>'.$messages[0]['body'].'</h2>';

		unset($messages[0]);

		$messages['server'] = $_SERVER;
		$messages['post']   = $_POST;
		$messages['get']    = $_GET;

		foreach ($messages as $name => $message)
		{
			$this->email_content .= '<hr>';
			$this->email_content .= '<h3>$_'.strtoupper($name).'</h3>';
			$this->email_content .= '<dl>';

			foreach ($message as $title => $value)
			{
				$this->email_content .= '<dt><strong>'.ucfirst($title).'</strong></dt>';

				if (is_array($value))
				{
					$this->email_content .= '<dd><pre>'.print_r($value, true).'</pre></dd>';
				}
				else
				{
					$this->email_content .= '<dd>'.$value.'</dd>';
				}
			}

			$this->email_content .= '</dl>';
		}
	}

}