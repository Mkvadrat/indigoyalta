<?php
/**
 * Example Controller
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

Class Example extends Bancha_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		echo 'Hello world';
	}
}