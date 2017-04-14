<?php
/**
 * Auth Controller
 *
 * Login/Logout (admin)
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Core_Auth extends Fastcms_Controller
{
	public function __construct()
	{
	    parent::__construct();
	    $this->load->database();
	    $this->view->base = 'admin/';
	}

	function index()
	{
		$this->login();
	}

	function login()
	{
		if ($this->auth->is_logged())
		{
			redirect(ADMIN_PUB_PATH.'dashboard');
		}

		if ($this->input->post('username'))
		{
			$logged = $this->auth->login(
				$this->input->post('username', TRUE),
				$this->input->post('password', TRUE)
			);

			if ($logged)
			{
				$this->load->events();
				$this->events->log('login');

				$redirect = $this->input->get('continue');
				if ($redirect)
				{
					redirect(urldecode($redirect));
				}
				redirect(ADMIN_PUB_PATH.'dashboard');
				
			} else {
				$this->view->set('message', _('Username/password wrong.'));
			}
		}

		$this->view->render_layout('auth/login', FALSE);
	}

	function logout()
	{
		$this->auth->logout();

		$this->load->events();
		$this->events->log('logout');

		redirect('/');
	}
}