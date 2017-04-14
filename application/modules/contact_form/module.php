<?php
/**
 * Contact form Module
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

Class Contact_form_Module extends Fastcms_Module
{
	/**
	 * @var string Form action
	 */
	protected $action	= 'email';

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
	    $B->load->requests();

		$B->load->library('form_validation');

		$act = $B->input->post('_requestform');
		$B->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$B->form_validation->set_message('required', 'Обязательное поле');
		$B->form_validation->set_message('min_length', 'Сообщение слишком короткое. Не менее 10 символов.');
		
		$B->form_validation->set_rules('firstname', 'Имя', 'required|xss_clean');
		$B->form_validation->set_rules('message', 'Город', 'required|xss_clean|min_length[10]');
//		$B->form_validation->set_rules('phone', 'Город', 'required|xss_clean');
	
		if ($B->form_validation->run() == FALSE)
		{
			return parent::render('view');
		}
		else
		{
		$act = $B->input->post('_contactform');
		if ($act)
		{
			$data = $B->input->post();
			
	//		print_r($data);
			
			switch ($this->action)
			{
				case 'email':
					//$B->load->library('email', array('mailtype' => 'html','protocol' => 'sendmail'));
                    $B->load->library('email', array('mailtype' => 'html'));
					$B->load->library('parser');
					
					$B->email->from($this->from, $this->from_name);
					$B->email->to($this->to);
					$B->email->subject($this->subject);

					$msg = parent::render('template_email');
					

					$type_definition = $B->xml->parse_scheme($B->config->item('xml_folder') . 'Requests.xml');
					$request = new Record();
					$request->set_type($type_definition);
					$request->set('author', $B->input->post('firstname'))
							->set('email', $B->input->post('email'))
							->set('message', $B->input->post('message'))
							->set('estate_type', '-')
							->set('type', 'n')
							->set('objectid', '-')
							->set('city', $B->input->post('city'))
							->set('attachments', 'na')
							->set('phone', 'не указан')
							->set('status', 'n')
							->set('section', 'fdb');
			
					$request_id = $B->records->save($request);
					
					$selfcopy = $B->input->post('selfcopy');
					
					if(isset($selfcopy)){
						$B->email->cc($B->input->post('email'));	
					}
					$parsed_msg = $B->parser->parse_string($msg, array(
						'website_name_ru'	=> settings('website_name_ru'),
						'firstname'	=> $B->input->post('firstname'),
						'city'	=> $B->input->post('city'),
						'email'		=> $B->input->post('email'),
						'message'	=> $B->input->post('message'),
						'request_id'	=> $request_id
					), TRUE);

					$B->email->message($parsed_msg);	
					$done = $B->email->send();

					break;
				default:
					show_error('Хакер что-ли?');
			}
			if ($done && $request_id)
			{
				return parent::render('view_success');
			}
		}
		}
		return parent::render();
	}

}