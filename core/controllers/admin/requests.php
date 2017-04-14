<?php
/**
 * Contents Controller
 *
 * This controller manage, creates and deletes any type of content
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Core_Requests extends Fastcms_Controller
{

    /**
     * @var string Current section
     */
    private $_section;

  	public function __construct()
  	{
	    parent::__construct();
        $this->load->database();
	    $this->content->set_stage(TRUE);
	    $this->view->base = 'admin/';
	    $this->auth->needs_login();
	    $this->load->requests();

  	}

	public function index()
	{
		$this->listrequests();
	}

	public function listrequests()
	{
		$requests = $this->requests->get();

		$this->view->set('requests', $requests);

		$this->view->render_layout('requests/list');
	}

	public function editrequest($id_request = '')
	{

		$type_definition = $this->xml->parse_scheme($this->config->item('xml_folder') . 'Requests.xml');
		$request = new Record();
		$request->set_type($type_definition);

	
		if ($this->input->post())
		{
			$request->set_data($this->input->post());



			if ($id_request != '') {
				//We don't need to update the password
				$requests = $this->records->set_type($type_definition)->limit(1)->where('id_request', $id_request)->get();

			} else {

			}
			
			if ($id_request != '') {
				//User can't edit groups
				if (!isset($requests)) {
					$requests = $this->records->set_type($type_definition)->limit(1)->where('id_request', $id_request)->get();
				}
				
				if ($requests) {
					$tmp_navigation = $requests[0];
				}	
			}

			$done = $this->records->save($request);

			if ($done)
			{
				$msg = 'Меню успешно обновлено';
				if ($this->input->post('_bt_save_list')){
        	$this->session->set_flashdata('message', $msg);
        	redirect('admin/requests');
        } else {
        	$this->view->message('success', $msg);
        }
			}
		}
		if ($id_request != '')
		{
			if ($request->id) {
				//We already have the user
			} else {
				//We search for this user
				$requests = $this->records->set_type($type_definition)->limit(1)->where('id_request', $id_request)->get();
				
				
				
				if (!$requests)
				{
					show_error('Запрос не найден');
				} else {
					$request = $requests[0];
				}
			}	
		} else {
			//New user
			$this->view->set('request', FALSE);
		}

		//Additional set-ups before the page rendering
        foreach ($type_definition['fields'] as $field_name => $field_value)
        {
        	if (isset($field_value['extract']))
            {
                //We extract the custom options
    			$type_definition['fields'][$field_name]['options'] = $this->records->get_field_options($field_value);
        	}
        }
			$i = 0;
			foreach ($type_definition['fieldsets'] as $fieldset) {
				$i++;
			}
		$this->view->set('tipo', $type_definition);
		$this->view->set('_section', 'requests');
		$this->view->set('action', 'admin/requests/editrequest/' . $request->id);
		$this->view->set('record', $request);

	
				

		$this->view->render_layout('requests/edit');
	}


}