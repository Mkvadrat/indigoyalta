<?php
/**
 * Contact form Module
 *
 * Usage:
 * echo module('requestform')->render();
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

Class addform_Module extends Fastcms_Module
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
		
		$B->form_validation->set_rules('firstname', 'Имя', 'required|xss_clean');
		$B->form_validation->set_rules('city', 'Город', 'required|xss_clean');
		$B->form_validation->set_rules('phone', 'Город', 'required|xss_clean');
		$B->form_validation->set_rules('dealtype', 'Тип сделки', 'required');
	
		if ($B->form_validation->run() == FALSE)
		{
			return parent::render('view');
		}
		else
		{

		if ($act)
		{
			$data = $B->input->post();

			switch ($this->action)
			{
				case 'email':
					$B->load->library('email', array('mailtype' => 'html'));
					$B->load->library('parser');
					
					
					
					$B->email->from($this->from, $this->from_name);
					$B->email->to($this->to);
					$B->email->subject($this->subject);

					
					$msg = parent::render('template_email');
					$dealtypes = array(
						'b' => 'Купить',
						's' => 'Продать',
						'e' => 'Обменять',
						'r' => 'Снять',
						'o' => 'Сдать',
					);
					
					$estatetypes = array(
						'-' => 'не указано',
						'flat' => 'Квартира',
						'land' => 'Земельный участок',
						'comestate' => 'Коммерческая недвижимость',
						'other' => 'Другая недвижимость',
					);

					if($B->input->post('attachments')){
						
						$attachmentspath = $_SERVER['DOCUMENT_ROOT'].'/request/uploads/';
						
						$attachments = $B->input->post('attachments');
						foreach($attachments as $attachment){
                            if (!file_exists($attachmentspath . $attachment)) continue;
							$B->email->attach($attachmentspath . $attachment);
						}
					
					}

					$type_definition = $B->xml->parse_scheme($B->config->item('xml_folder') . 'Requests.xml');
					$request = new Record();
					$request->set_type($type_definition);
					$request->set('author', $B->input->post('firstname'))
							->set('email', $B->input->post('email'))
							->set('message', $B->input->post('message'))
							->set('estate_type', $B->input->post('type'))
							->set('type', $B->input->post('dealtype'))
							->set('city', $B->input->post('city'))
							->set('attachments', $B->input->post('attachments'))
							->set('phone', $B->input->post('phone'))
							->set('status', 'n')
							->set('section', 'aeo');
			
					$request_id = $B->records->save($request);
					


					$parsed_msg = $B->parser->parse_string($msg, array(
						'firstname'	=> $B->input->post('firstname'),
						'city'	=> $B->input->post('city'),
						'phone'	=> $B->input->post('phone'),
						'dealtype'	=> $dealtypes[$B->input->post('dealtype')],
						'type'	=> $B->input->post('type'),
						'email'		=> $B->input->post('email'),
						'message'	=> $B->input->post('message'),
						'request_id'	=> $request_id,
					), TRUE);

					$B->email->message($parsed_msg);
					
//					$B->email->print_debugger();
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