<?php
/**
 * Module Class
 *
 * Abstract class to implement a Module
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

abstract class Fastcms_Module
{
	/**
	 * @var mixed Reference to the view class
	 */
	public $view;

	/**
	 * @var string The path of the files for this module
	 */
	public $module_filespath;

	/**
	 * @var string The name of the current module
	 */
	public $module_name;

	private $_view_path_added = FALSE;

	public function __construct()
	{
		$CI = & get_instance();
		$this->view = & $CI->view;
	}

	/**
	 * Sets a variable as a class property
	 * @param string $key
	 * @param mixed $val
	 */
	public function _set_var($key, $val)
	{
		$this->$key = $val;
	}

	/**
	 * Renders a module, using the default view
	 * @param string $view The view template to use (default = 'view')
	 */
	public function render($view = 'view')
	{
		$CI = & get_instance();
		$module_name = strtolower(str_replace('_Module', '', get_class($this)));
		if (!$this->_view_path_added)
		{
			$this->_view_path_added = TRUE;
			$CI->load->add_view_path(USERPATH . 'modules' . DIRECTORY_SEPARATOR);
		}
		return $CI->load->view($module_name.DIRECTORY_SEPARATOR.$view, $CI->view->get_data(), TRUE);
	}

	/**
	 * Loads a single class inside this module
	 * @param string $module_file The name of the class to load
	 */
	public function load($classname)
	{
		$lower_name = strtolower($classname);

		$file_name = $lower_name . '.php';
		require_once $this->module_filespath . $file_name;

		$compiled_name = $this->module_name . '_' . ucfirst($classname);
		$this->$lower_name = new $compiled_name();
	}
}