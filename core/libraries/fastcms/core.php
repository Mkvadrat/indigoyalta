<?php
Class Core
{
	function __get($key)
	{
		$B =& CI_Controller::get_instance();
		return $B->$key;		
	}
}