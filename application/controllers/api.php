<?php
/**
 * Example Controller
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

Class Api extends Bancha_Controller
{
	public function __construct()
	{
		   parent::__construct();
           $this->load->library('email');
           $this->load->helper('url');
           $this->load->helper('form');
           $this->load->helper('frontend');
           $this->load->helper('website');
//           $this->load->library('validation');
	}

	public function index()
	{
		echo 'Hello world';
	}
	
	public function submitorder()
	{

           $info = array (
                'nome'  => $this->input->post('nome'),
                'mail'  => $this->input->post('email'),
                'motivo'    => $this->input->post('motivo'),
                'mensagem'  => $this->input->post('mensagem'),
                'anexo' => $this->input->post('upload'),
           );

 //          $this->load->library('email');
           $this->email->set_newline('\r\n');

           $this->email->clear();
           $this->email->from($info['mail'], $info['nome']);
           $this->email->to('davidslv@gmail.com');
           $this->email->subject($info['motivo']);
           $this->email->message($info['mensagem']);
           $this->email->attach($info['anexo']);


			$this->library->load('upload');
			
			if($_FILES['upload']['size'] > 0) { // upload is the name of the file field in the form
			
			$aConfig['upload_path']      = '/someUploadDir/';
			$aConfig['allowed_types']    = 'doc|docx|pdf|jpg|png';
			$aConfig['max_size']     = '3000';
			$aConfig['max_width']        = '1280';
			$aConfig['max_height']       = '1024';
			
			$this->upload->initialize($aConfig);
			
			  if($this->upload->do_upload('upload'))
			  {
				$ret = $this->upload->data();
			  } else {
			  }
			
			  $pathToUploadedFile = $ret['full_path'];
  				$this->email->attach($pathToUploadedFile);
 
			}
 
           if ($this->email->send() ) {
                echo 'sent';
           }

           else {
            //$this->load->view('formulario');
     show_error( $this->email->print_debugger() );
           }
		   
	}
	
	public function getestatelinks()
	{
		$this->load->database();
		$realestates = $this->records->type('realestate')->get();
		$counter = 1;
		foreach ($realestates as $realestate){
			$realestateid = $realestate->get('id_record');
			$realestatetypo = $realestate->get('id_type');
			$realestateturi = $realestate->get('uri');
			$realestatecats = recordCategoriesIds($realestate->get('id_record'));
			echo $counter.' - '.semantic_category_url($realestate, $realestatecats, $realestatetypo,$realestateturi)."\n;";
			$counter++;
		}
					
					
					
	}
	
	
}