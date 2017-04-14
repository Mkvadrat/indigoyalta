<?php defined('FASTCMS') or exit;
/**
 * Extensions Controller
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

Class Core_Extensions extends Fastcms_Controller
{
	public function __construct()
	{
	    parent::__construct();
	    $this->load->database();
	    $this->content->set_stage(TRUE);
	    $this->view->base = 'admin/';

	    $this->auth->needs_login();
	}

	public function package($name = '', $controller = '', $action = 'index')
	{
		$package_path = USERPATH . 'modules' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'extend' . DIRECTORY_SEPARATOR;

		if ($controller == '') {
			$controller = $name;
		}

		$path = $package_path . 'controllers/' . $controller . '.php';
		if (!file_exists($path)) {
			show_error("The controller has not been found here: $path");
		}
		require_once($path);

		$classname = ucfirst($controller) . '_Controller';
		if (!class_exists($classname)) {
			show_error("The class $classname has not been implemented inside the file $path");
		}
		
		$c = new $classname();
		if (!method_exists($c, $action)) {
			show_error("The controller $classname does not implement the $action method.");
		}
		$c->$action();
	}
}