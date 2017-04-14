<?php
if ( ! defined('CUSTOM_TRIGGER')) exit('You cannot call the triggers directly');


Class Core_Triggers
{
	public $CI;

	public function __construct()
	{
		$this->CI = & get_instance();
	}

	/**
	 * Trigger/attivatore dimostrativo
	 */
	function demotrigger($record)
	{
		log_message('error', 'Someone called me with the record named ' . $record->get('title'));
	}
}