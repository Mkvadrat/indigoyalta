<?php define('WEBSITE_CONTROLLER_EXISTS', TRUE);
/**
 * Website Main Controller
 *
 * The base front-end controller of the website
 * Check the core/controllers/website.php for available methods
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

require_once(APPPATH . 'controllers/website.php');

Class Website extends Core_Website
{
	public function __construct()
	{
		parent::__construct();
	}
}