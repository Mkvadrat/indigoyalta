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

Class Core_Navigation extends Fastcms_Controller
{
    private $_section;

  	public function __construct()
  	{
	    parent::__construct();
        $this->load->database();

	    $this->content->set_stage(TRUE);
	    $this->view->base = 'admin/';
	    $this->auth->needs_login();
	    $this->load->navigation();

  	}

	public function index()
	{
		$this->listgroups();
	}

	public function listgroups()
	{

		$navigations = $this->navigation->get();

		$this->view->set('navigations', $navigations);

		$this->view->render_layout('navigation/groups');
	}

	public function editgroup($id_menu = '')
	{

		$fromwhere = implode(",",$this->records->get_types());
    $naviitems = $this->records->type($fromwhere)->where('show_in_menu','T')->get();
    $this->view->set('naviitems', $naviitems);
		$this->db->flush_cache();

			
		$type_definition = $this->xml->parse_scheme($this->config->item('xml_folder') . 'Menus.xml');
		$menu = new Record();
		$menu->set_type($type_definition);

	
		if ($this->input->post())
		{
			$menu->set_data($this->input->post());



			$menuname = $this->input->post('menuname');
			if ($id_menu != '' && !strlen($menuname)) {
				//We don't need to update the password
				$navigations = $this->records->set_type($type_definition)->limit(1)->where('id_navigation', $id_menu)->get();

				if ($navigations) {
					$tmp_navigation = $navigations[0];
					$user->set('menuname', $tmp_navigation->get('menuname'));
				}

			} else {

			}
			
			if ($id_menu != '') {
				//User can't edit groups
				if (!isset($navigations)) {
					$navigations = $this->records->set_type($type_definition)->limit(1)->where('id_navigation', $id_menu)->get();
				}
				
				if ($navigations) {
					$tmp_navigation = $navigations[0];
				}	
			}

			$done = $this->records->save($menu);

			if ($done)
			{
				$msg = 'Меню успешно обновлено';
				if ($this->input->post('_bt_save_list')){
        	$this->session->set_flashdata('message', $msg);
        	redirect('admin/navigation');
        } else {
        	$this->view->message('success', $msg);
        }
			}
		}
		if ($id_menu != '')
		{
			if ($menu->id) {
				//We already have the user
			} else {
				//We search for this user
				$menus = $this->records->set_type($type_definition)->limit(1)->where('id_navigation', $id_menu)->get();
				
				
				
				if (!$menus)
				{
					show_error(_('User not found'));
				} else {
					$menu = $menus[0];
				}
			}	
		} else {
			//New user
			$this->view->set('navgroup', FALSE);
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
		$this->view->set('_section', 'navigations');
		$this->view->set('action', 'admin/navigation/editgroup/' . $menu->id);
		$this->view->set('record', $menu);

	
				
		$this->view->render_layout('navigation/edit');
	}

	public function delete($id_menu = '')
	{
		$done = $this->navigation->delete($id_menu);
		if ($done)
		{
			echo 'true';
//			echo json_encode(array('status'=>'Меню удалено'));
//			$this->session->set_flashdata('message', _('The user has been deleted.'));
//      redirect('admin/users/allusers');
		}
	}


}