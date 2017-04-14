<?php
/**
 * Package Interface Class
 *
 * You must implement this class to make a package
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

interface Fastcms_Package
{
	/**
	 * @var string Return the package version
	 */
	public function title();

	/**
	 * @var string Return the package version
	 */
	public function version();

	/**
	 * @var string Return the package author
	 */
	public function author();

	/**
	 * Additional operations to perform after the install
	 * @optional public function install();
	 */

	/**
	 * Additional operations to perform before the uninstall
	 * @optional public function uninstall();
	 */
}