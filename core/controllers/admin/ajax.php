<?php
/**
 * Ajax Controller
 *
 * (amministrazione)
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Core_Ajax extends Fastcms_Controller
{

	public function __construct()
	{
	    parent::__construct();
	    $this->load->database();

	    $this->content->set_stage(TRUE);

	    $this->view->base = 'admin/';

	    $this->auth->needs_login();

	}

	public function can_use_uri()
	{

		$uri = $this->input->post('uri', '');
		$type = $this->input->post('id_type', '');
		$uri = $this->records->get_safe_uri($uri);
		$edit_record_id = $this->input->post('id_record', '');

		if ($uri && $uri != '')
		{
			$record = $this->records->uri_is_used($uri);
			if ($record)
			{
				$err = 'Данная ссылка уже используется в [<a class="color-red" href="'.admin_url('contents/edit_record/'.$record->tipo.'/'.$record->id).'">'.$record->get('title').'</a>]';
				if ($edit_record_id)
				{
					if ($edit_record_id != $record->id)
					{
						echo $err;
						return;
					}
				} else {
					echo $err;
					return;
				}
			}
		}
		return;
	}

	public function delete_document()
	{
		$id = $this->input->post('document_id');
		if ($id != '')
		{
			$this->load->documents();
			echo $this->documents->delete_by_id($id) ? 1 : 0;
		}
	}

	public function finder($id_record='undefined', $type='')
	{
		$this->load->documents();

		if ($id_record != 'undefined')
		{
			if ($type != '')
			{
				$tipo = $this->content->type($type);
				$table = $tipo['table'];
			} else {
				$table = 'records';
			}

			$documents = $this->documents->table($table)
										 ->id($id_record)
										 ->get();

			$this->view->set('documents', $documents);
		}

		if (count($_FILES))
		{
			$this->documents->upload_to_repository($_FILES);
		}

		$repository = $this->documents->table('repository')
									  ->field('document')
									  ->limit(30)
									  ->order_by('id_document', 'DESC')
									  ->get();
		
		//Image presets
		$this->load->config('image_presets');
		$presets = $this->config->item('presets');

		$tmp = array('' => '');
		foreach ($presets as $key => $val)
		{
			$tmp[$key] = ucfirst($key);
		}

		$this->view->set('presets', $tmp);

		$this->view->set('repository_files', $repository);

		$this->view->render_layout('repository/ajax-finder', FALSE);
	}

	public function get_relation()
	{
		$name = $this->input->post('name');
		$id = $this->input->post('id');
		$type = $this->input->post('type');

		if ($name && $id && $type)
		{
			$record = $this->records->type($type)->get($id);
			$this->view->set('objects', $record->related($name));

			$this->view->render($this->view->base . 'relations/single', $this->view->get_data());
		}
	}

}