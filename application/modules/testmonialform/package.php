<?php
/**
 * Googleplus Module - Package class
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

Class Contact_form_Package implements Bancha_Package
{
	public function name()
	{
		return 'contact_form';
	}

	public function title()
	{
		return 'Обратная связь';
	}

	public function author()
	{
		return 'Fastimus';
	}

	public function version()
	{
		return '1.1';
	}

	public function install()
	{
		//Nothing to do
	}

	public function uninstall()
	{
		//Nothing to do
	}
}