<?php

Class Fastcms_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		//Sets the default content type
		$this->output->set_header('Content-Type: text/html; charset=UTF-8');

		//Loads the current language and .mo files
		$section = $this->uri->segment(1);
		$this->lang->check($section == rtrim(ADMIN_PUB_PATH, '/') ? 'admin' : 'website');

		//Loads the framework :)
		$this->load->fastcms();
	}
}