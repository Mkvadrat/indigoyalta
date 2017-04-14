<?php
require_once(APPPATH . 'controllers/custom/triggers.php');

/**
 * Website custom Triggers
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

Class Triggers extends Core_Triggers
{
	public $CI;

	public function __construct()
	{
		$this->CI = & get_instance();
	}

	/**
	 * A dummy trigger
	 */
	function demotrigger($record)
	{
		log_message('error', 'Someone called me with the record named ' . $record->get('title'));
	}
}