<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Core_Unit_tests extends Fastcms_Controller
{

	public function __construct()
	{
	    parent::__construct();
	    $this->load->database();

	    $this->content->set_stage(TRUE);

	    //All actions needs user login
	    $this->auth->needs_login();

	    $this->view->base = 'admin/';

	    return;
	}

	public function index()
	{
		$this->view->render_layout('unit_tests/intro');
	}

	/*
	 * This action makes the automatic tests and displays the results
	 */
	public function make_tests() {
		$this->load->library('unit_test');

		//We tests saving a new record
		$default_types = $this->config->item('default_tree_types');
		$record = new Record($default_types[0]);
		$msg = 'A sample text';
		$record->set('title', $msg);
		$id = $this->records->save($record);

		$this->unit->run($id, 'is_numeric', 'Insert new record', 'We tried to insert a new record of type "'.$default_types[0].'".');

		$record = $this->records->get($id);

		$this->unit->run($record, 'is_object', 'Search for a single record', 'We tried to search the record with id ['.$record->id.'].');
		$this->unit->run($record->get('title'), $msg, 'Tests a single field', 'We tests if the title of the record is "'.$msg.'".');
		$this->unit->run($this->records->delete_by_id($id), TRUE, 'Delete a record', 'We tried to delete the record with id ['.$id.'].');

		//Now we tests the XML parser on the users
		$parser = $this->xml->parse_scheme($this->config->item('xml_folder') . 'Users.xml');
		$this->unit->run($parser, 'is_array', 'Parsing an XML file to a content type', 'We tried to parse the Users.xml scheme.');


		$this->view->set('tests', $this->unit->report());
		$this->view->render_layout('unit_tests/results');
	}
}
