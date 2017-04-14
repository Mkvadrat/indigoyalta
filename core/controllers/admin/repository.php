<?php
/**
 * Repository Controller
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Core_Repository extends Fastcms_Controller
{
	public function __construct() {
	    parent::__construct();
	    $this->load->database();
	    $this->view->base = 'admin/';

	    //We are always in staging here
	    $this->content->set_stage(TRUE);

	    $this->auth->needs_login();
	}

	public function index()
	{
		$this->load->documents();

		if (count($_FILES))
		{
			$this->documents->jsonupload_to_repository($_FILES);
		}

		$repository = $this->documents->table('repository')
									  ->field('document')
									  ->limit(30)
									  ->order_by('id_document', 'DESC')
									  ->get();
		//Image presets
		$this->load->config('image_presets');
		$presets = $this->config->item('presets');

		$tmp = array('' => 'Размер');
		foreach ($presets as $key => $val)
		{
			$tmp[$key] = ucfirst($key);
		}

		$this->view->set('presets', $tmp);

		$this->view->set('repository_files', $repository);

		$this->view->render_layout('repository/list');
	}
}