<?php
/**
 *
 * Usage:
 * echo module('contact_form')->render();
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

Class testmonialform_Module extends Fastcms_Module
{
	/**
	 * @var string Form action
	 */
	protected $action	= 'addtestmonial';

	/**
	 * @var string From > Email
	 */
	protected $from = 'fastimus@fastimus.ru';

	/**
	 * @var string From name > Email
	 */
	protected $from_name = 'FastCMS Module';

	/**
	 * @var string To > Email
	 */
	protected $to	= '';

	/**
	 * @var string Email subject
	 */
	protected $subject = 'Contact form request';

	/**
	 * Sends (or renders) the form
	 */
	public function render()
	{
		$B =& get_instance();
    $B->load->database();

		$B->load->library('form_validation');

		$act = $B->input->post('_testmonialform');
		$B->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$B->form_validation->set_message('required', 'Обязательное поле');
		$B->form_validation->set_message('min_length', 'Сообщение слишком короткое. Не менее 10 символов.');
		
		$B->form_validation->set_rules('author', 'Имя', 'required|xss_clean');
		$B->form_validation->set_rules('message', 'Город', 'required|xss_clean|min_length[10]');
		$B->form_validation->set_rules('email', 'Город', 'required|xss_clean|valid_email');
	
		if ($B->form_validation->run() == FALSE)
		{
			return parent::render('view');
		}
		else
		{
		$act = $B->input->post('_testmonialform');
		if ($act)
		{
			$data = $B->input->post();
			
	//		print_r($data);
			
			switch ($this->action)
			{
				case 'addtestmonial':
				
				
				    $client  = @$_SERVER['HTTP_CLIENT_IP'];
						$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
						$remote  = $_SERVER['REMOTE_ADDR'];
				
						if(filter_var($client, FILTER_VALIDATE_IP))
						{
								$ip = $client;
						}
						elseif(filter_var($forward, FILTER_VALIDATE_IP))
						{
								$ip = $forward;
						}
						else
						{
								$ip = $remote;
						}
				
						 $ip;
				
				
				
					
					$testmonial = new Record('testmonials');
					$testmonial->set('title', $B->input->post('author'))
							->set('email', $B->input->post('email'))
							->set('type', 't')
							->set('date_publish', time())
							->set('status', 'n')
							->set('iploc', $ip)
							->set('comefrom', $B->input->post('comefrom'))
							->set('jobposition', $B->input->post('jobposition'))
//							->set('link', $B->input->post('link'))
							->set('content', $B->input->post('message'));
			
					$testmonial_id = $B->records->save($testmonial);
					

					break;
				default:
					show_error('Хакер что-ли?');
			}
			if ($testmonial_id)
			{
				return parent::render('view_success');
			}
		}
		}
		return parent::render();
	}

}