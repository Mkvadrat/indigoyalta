<?php

Class Dispatcher_default
{
	/**
	 * @var Fastcms instance
	 */
	private $_CI;

	public function __construct()
	{
		$this->_CI = & CI_Controller::get_instance();
		$this->_CI->load->database();

		//Front-end helper
		$this->_CI->load->helper('frontend');
		$this->_CI->load->helper('typography');
	}

	/**
	 * Starts the routing
	 * @param Record $record (optional, for manual routing)
	 */
	public function start($record = '')
	{
		if ($record == '' || !($record instanceof Record))
		{
			//Auto-routing
			$record = $this->get_current_record();

			if (!$record)
			{
				$this->_CI->view->title = _('Page not found');
				$this->_CI->view->render_template('not_found', TRUE, 404);
				return;
			}
		}

		//We get the website pages tree
		$this->_CI->view->set('tree', $this->_CI->tree->get_default());
        $this->_CI->view->set('tree_rent', $this->_CI->tree->get_by_category('rent'));

		//Let's set the meta title, keywords and description
		$this->_CI->view->title = $record->get('meta_title');
		if (!$this->_CI->view->title)
		{
			//If the meta title is not found, let's use the title field
			$this->_CI->view->title = $record->get('title');
		}
		$this->_CI->view->keywords = $record->get('meta_keywords');

		$this->_CI->view->description = strip_tags($record->get('meta_description'));
		if (!$this->_CI->view->description)
		{
			//If the meta description is not found, let's use the content field
			$this->_CI->load->helper('text');
			$this->_CI->view->description = character_limiter(strip_tags($record->get('content')), 150, '...');
		}
		

		//Is this a page?
		if ($record->is_page())
		{
			$page = $record;
//			echo '<!-- ';
//			print_r($page);
//			echo ' -->';
			//We set the language to be the same as the page
			$this->_CI->lang->set_lang($page->get('lang'));

			//We set che cache if the page wants it
			$cache = (int)$page->get('page_cache');
			if ($cache > 0)
			{
				$this->_CI->output->cache($cache);
			}
			
			switch ($page->get('action'))
			{
				case 'list':
					if($page->get('action_list_type') == '11'){
						$page = $this->set_realestatelist($page);
					}else{
						$page = $this->set_recordlist($page);
					}
					break;

				case 'action':
					$this->call_action($page);
					break;

				case 'link':
					$link = $page->get('action_link_url');
					redirect($link, 'location', 301);
			}
		} else {
			//Single record view
			$page = $this->set_singleview($record);
		}

		//Last check before dispatching
		if ($page instanceof Record)
		{
			if ($this->_CI->view->is_feed == 'pdf')
			{
				$this->_CI->load->dispatcher('print', 'dispatcher_print');
				$this->_CI->dispatcher_print->render($page);
			} else {
				//We add a page global variable
				$GLOBALS['page'] = & $page;
				$this->_CI->view->set('page', $page);
				$this->_CI->view->render_template($page->get('view_template'));
			}
		}
	}

	protected function set_singleview($record, $parent_page = '')
	{
		if (!$parent_page)
		{
			$parent_page = $record->get('_parentpage');
			$record->set('_parentpage', NULL);
		}

		//Single record view
		$template = $parent_page->get('view_template');
		
		if (! ($record instanceof Record))
		{
			$this->_CI->view->title = _('Page not found');
			$this->_CI->view->render_template('not_found', TRUE, 404);
		}

		//Action: single record
		$parent_page->set('action', 'single');
		$record->set('action', 'single');

		//Let's check the publish date
		$date_publish = $record->get('_date_publish');
		if ($date_publish && $date_publish > time())
		{
			$this->_CI->view->title = _('Page not found');
			$this->_CI->view->render_template('not_found', TRUE, 404);
			return;
		}

		$this->_CI->tree->breadcrumbs[$record->id] = array(
					'title'	=> $record->get('title'),
					'link'	=> uri_string().'/'
		);

		$parent_page->set('view_template', $template);
		$this->_CI->view->set('record', $record);
		$GLOBALS['record'] = & $record;

		return $parent_page;
	}



	/**
	 * List realestate objects only
	 */
	protected function set_realestatelist($page)
	{

		$categories = $page->get('action_list_categories');
		$get_category = $this->_CI->input->get('category');
		
		//First of all, let's extract the categories (we prepare a select statement)
		$cat_ids = FALSE;
		if ($categories || $get_category) {
			if ($categories)
			{
				$categories = explode(',', $categories);
			}
			if ($get_category)
			{
				$categories[] = $get_category;
			}
			
			$this->_CI->load->categories();
			
			$cat_ids = $this->_CI->categories->name_in($categories)->get_ids();
			if ($cat_ids)
			{
				$cat_sql = $this->_CI->categories->get_records_for_categories($cat_ids, TRUE);
			}
			
		}

		//Now we extract the hierarchies (just a select statement)
		$hierarchies = $page->get('action_list_hierarchies');
		if (is_array($hierarchies) && count($hierarchies))
		{
			$this->_CI->load->hierarchies();
			$hie_sql = $this->_CI->hierarchies->get_records_for_hierarchies($hierarchies, TRUE);
			if (count($hie_sql))
			{
				$this->_CI->records->id_in($hie_sql, FALSE);
			} else {
				$this->_CI->records->where(1, 2);
			}
		}

		//After the query above we can apply the SELECT statement on the category
		if ($cat_ids)
			$this->_CI->records->id_in($cat_sql, FALSE);
		else if ($categories || $get_category)
			$this->_CI->records->where(1, 2);
		
		
		$this->_CI->records->where('frontstate', 'N');

		$tipo = $page->get('action_list_type');
		$type = $this->_CI->content->type($tipo);
		
		
		# Сортировка
		$visitorsort = $this->_CI->input->get('orderby');
		if ($visitorsort === '')
			$visitorsort = false;


        $mr = MoneyRates::getInstance();
        //$this->_CI->records->select('id_record, date_insert, date_update, date_publish, id_type, lang, xml, uri, id_parent, child_count, title, show_in_menu, uah_total, usd_total, euro_total, rub_total, uah_ms, usd_ms, euro_ms, rub_ms, uah_month, usd_month, euro_month, rub_month, uah_day, usd_day, euro_day, rub_day, priority, type');
        $this->_CI->records->select('(case when (rub_total>0) then cast(rub_total AS DECIMAL(10)) when (usd_total>0) then cast(usd_total AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getUsdRate()).' when (euro_total>0) then cast(euro_total AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getEurRate()).' when (uah_total>0) then cast(uah_total AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getUahRate()).' else 0 end) as sort_price_total', false);
        $this->_CI->records->select('(case when (rub_ms>0) then cast(rub_ms AS DECIMAL(10)) when (usd_ms>0) then cast(usd_ms AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getUsdRate()).' when (euro_ms>0) then cast(euro_ms AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getEurRate()).' when (uah_ms>0) then cast(uah_ms AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getUahRate()).' else 0 end) as sort_price_ms', false);
        $this->_CI->records->select('(case when (rub_month>0) then cast(rub_month AS DECIMAL(10)) when (usd_month>0) then cast(usd_month AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getUsdRate()).' when (euro_month>0) then cast(euro_month AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getEurRate()).' when (uah_month>0) then cast(uah_month AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getUahRate()).' else 0 end) as sort_price_month', false);
        $this->_CI->records->select('(case when (rub_day>0) then cast(rub_day AS DECIMAL(10)) when (usd_day>0) then cast(usd_day AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getUsdRate()).' when (euro_day>0) then cast(euro_day AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getEurRate()).' when (uah_day>0) then cast(uah_day AS DECIMAL(10))*'.$this->_CI->records->escape($mr->getUahRate()).' else 0 end) as sort_price_day', false);

        if($visitorsort === 'price_asc') {
            //$this->_CI->records->order_by('sort_price_total, sort_price_ms, sort_price_month, sort_price_day', 'asc');
            $this->_CI->records->order_by('sort_price_total', 'asc');
            $this->_CI->records->order_by('sort_price_ms', 'asc');
            $this->_CI->records->order_by('sort_price_month', 'asc');
            $this->_CI->records->order_by('sort_price_day', 'asc');
        } elseif($visitorsort === 'price_desc') {
            //$this->_CI->records->order_by('sort_price_total, sort_price_ms, sort_price_month, sort_price_day', 'desc');
            $this->_CI->records->order_by('sort_price_total', 'desc');
            $this->_CI->records->order_by('sort_price_ms', 'desc');
            $this->_CI->records->order_by('sort_price_month', 'desc');
            $this->_CI->records->order_by('sort_price_day', 'desc');
        }

		if(!$visitorsort)
			$this->_CI->records->order_by("priority DESC, date_publish DESC");
		elseif($visitorsort === 'latest')
			$this->_CI->records->order_by("date_publish DESC");
		elseif($visitorsort === 'oldest')
			$this->_CI->records->order_by("date_publish ASC");
		elseif($visitorsort === 'sku_asc')
			$this->_CI->records->order_by("id_record ASC");
		elseif($visitorsort === 'sku_desc')
			$this->_CI->records->order_by("id_record DESC");
		
		



		$sql_where = $page->get('action_list_where');
		if ($sql_where) {
			$this->_CI->records->where($sql_where);
		}

		if (isset($type['fields']['date_publish'])) {
			//We can extract only published records
			$this->_CI->records->where('date_publish <= ' . time());
		}

		if ($tipo) {
			$this->_CI->records->type($tipo);

			$search_query = $this->_CI->input->get('search');
			if ($search_query)
			{
				$this->_CI->records->like('title', $search_query);
				$this->_CI->db->bracket('open');
				$this->_CI->records->or_like('content', $search_query);
				$this->_CI->db->bracket('close');
			}
		}
		//Just list fields, not the detail ones
		$this->_CI->records->set_list(TRUE);
		$this->_CI->records->language();



        $records = $this->_CI->records->documents(true)->get();
        //echo $this->_CI->records->last_query();
//        foreach ($records as $record) {
//            echo $record->get('id_record').'<br /.>';
//        }
//        die();


//		if($visitorsort === 'price_asc') {
//			usort($records, function($a, $b) {
//				if ($a->get('usd_total') > $b->get('usd_total'))
//					return 1;
//				elseif ($a->get('usd_total') < $b->get('usd_total'))
//					return -1;
//				return 0;
//			});
//		}
//		elseif($visitorsort === 'price_desc') {
//			usort($records, function($a, $b) {
//				if ($a->get('usd_total') < $b->get('usd_total'))
//					return 1;
//				elseif ($a->get('usd_total') > $b->get('usd_total'))
//					return -1;
//				return 0;
//			});
//		}
		
		
		# Количество объектов на странице
		$onpage = $this->_CI->input->get('onpage');
		if ($onpage != 'all' && ($onpage < 5 || $onpage > 1000))
			$onpage = (int)$page->get('action_list_limit');
		$limit = $onpage == 'all' ? '' : $onpage;

		if ($limit) {
			$current_cursor = $this->_CI->input->get('page');
			$offset = $current_cursor  > 0 ? $current_cursor : 0;

			$slice = array();
			for ($i = 0; isset($records[$i]) && $i < $offset + $onpage; $i ++) {
				if ($i >= $offset)
					$slice[] = $records[$i];
			}
			$records = $slice;
		}
		
		//If there's a limit, we will make a pagination
		if ($limit) {
			if ($tipo) {
				$this->_CI->records->type($tipo);
				if ($search_query) {
					$this->_CI->records->like('title', $search_query);
					$this->_CI->records->or_like('content', $search_query);
				}
			}
			if (isset($type['fields']['date_publish'])) {
				//We can extract only published records
				$this->_CI->records->where('date_publish <= ' . time());
			}
			if ($sql_where) {
				$this->_CI->records->where($sql_where);
			}


			if ($cat_ids) {
				$this->_CI->records->id_in($cat_sql, FALSE);
			}
			$this->_CI->records->where('frontstate', 'N');

//			if (isset($category_record_ids))
//			{
//				$this->_CI->records->id_in($category_record_ids);
//			}

			if (isset($hierarchies_record_ids))
			{
				$this->_CI->records->id_in($hierarchies_record_ids);
			}

			$count = $this->_CI->records->documents(FALSE)->set_list(TRUE)->language()->count();

			
			$url_params = array();
			if ($this->_CI->input->get('onpage') && (int)$page->get('action_list_limit') != $onpage)
				$url_params['onpage'] = $onpage;
			if ($visitorsort !== false)
				$url_params['orderby'] = $visitorsort;
			
			$pagination = array(
	        	'total_rows'			=> $count,
	        	'per_page'				=> $limit,
	        	'base_url'				=> current_url().'?',
	        	'first_link'			=> '&laquo; &laquo; В начало',
	        	'last_link'			=> 'В конец &raquo; &raquo;',
	        	'prev_link'			=> '&laquo; Предыдущая',
	        	'next_link'			=> 'Следующая &raquo;',
	        	'cur_tag_open'			=> '',
	        	'cur_tag_close'			=> '',
	        	'page_query_string'		=> TRUE,
	        	'query_string_segment'	=> 'page',
	        	'first_url'				=> current_url(),
				'url_params' => $url_params
			);

			$this->_CI->view->set('total_records', $pagination['total_rows']);

			$this->_CI->load->library('pagination');
			$this->_CI->pagination->initialize($pagination);
		}

		$this->_CI->db->flush_cache();

		if ($this->_CI->view->is_feed && $this->_CI->view->is_feed != 'pdf')
		{
			$this->_CI->load->frlibrary('feed');

			if ($this->_CI->config->item('type_custom_feeds') && isset($type['name']))
			{
				$this->_CI->output->enable_profiler(FALSE);
				$page->set('records', $records);
				$this->_CI->view->set('page', $page);
				$GLOBALS['page'] = & $page;
				$this->_CI->view->set('records', $records);
				$GLOBALS['records'] = & $records;
				$this->_CI->view->render_type_template($type['name'], 'feed', TRUE);
				return;
			}

			$feed_header = array(
				'title' 		=> $page->get('title'),
				'description'	=> $page->get('content')
			);
			$this->_CI->feed->create_new($feed_header, $this->_CI->view->is_feed);

			if (count($records))
			{
				$url = site_url();
				foreach ($records as $record)
				{
					$date_pub = $record->get('_date_publish');
					if (!$date_pub)
					{
						$date_pub = $record->get('_date_insert');
					}
					$item = array(
						'title'			=> $record->get('title'),
						'link'			=> current_url().'/'.$record->get('uri'),
						'guid'			=> current_url().'/'.$record->get('uri'),
						'pubDate'		=> date(DATE_RFC822, (int)$date_pub),
						'description'	=> str_replace('src="/attach', 'src="'.$url.'attach', $record->get('content'))
					);
					$this->_CI->feed->add_item($item, array('title', 'description'));
				}
			}
			$this->_CI->feed->render();
			return;

		} else if ($page->get('action_list_has_feed') == 'T')
		{
			$this->_CI->view->has_feed = TRUE;
		}

		$page->set('records', $records);
		return $page;
	}






	protected function set_recordlist($page)
	{
		$categories = $page->get('action_list_categories');
		$get_category = $this->_CI->input->get('category');

		//First of all, let's extract the categories (we prepare a select statement)
		$cat_ids = FALSE;
		if ($categories || $get_category) {
			if ($categories)
			{
				$categories = explode(',', $categories);
			}
			if ($get_category)
			{
				$categories[] = $get_category;
			}

			$this->_CI->load->categories();
			$cat_ids = $this->_CI->categories->name_in($categories)->get_ids();
			if ($cat_ids)
			{
				$cat_sql = $this->_CI->categories->get_records_for_categories($cat_ids, TRUE);
			}
			
		}

		//Now we extract the hierarchies (just a select statement)
		$hierarchies = $page->get('action_list_hierarchies');
		if (is_array($hierarchies) && count($hierarchies))
		{
			$this->_CI->load->hierarchies();
			$hie_sql = $this->_CI->hierarchies->get_records_for_hierarchies($hierarchies, TRUE);
			if (count($hie_sql))
			{
				$this->_CI->records->id_in($hie_sql, FALSE);
			} else {
				$this->_CI->records->where(1, 2);
			}
		}

		//After the query above we can apply the SELECT statement on the category
		if ($cat_ids)
		{
			$this->_CI->records->id_in($cat_sql, FALSE);
		} else if ($categories || $get_category) {
			$this->_CI->records->where(1, 2);
		}

		$limit = (int)$page->get('action_list_limit');
		if ($limit) {
			$current_cursor = $this->_CI->input->get('page');
			if (!$current_cursor) {
				$offset = 0;
			} else {
				$offset = $current_cursor;
			}
			$this->_CI->records->limit($limit, $offset);
		}

		$tipo = $page->get('action_list_type');
		$type = $this->_CI->content->type($tipo);

		$order_by = $page->get('action_list_order_by');
		if ($order_by) {
			if ($type)
			{
				$order_by = str_replace('id_record', $type['primary_key'], $order_by);
			}
			$this->_CI->records->order_by($order_by);
		}

		$sql_where = $page->get('action_list_where');
		if ($sql_where) {
			$this->_CI->records->where($sql_where);
		}

		if (isset($type['fields']['date_publish']))
		{
			//We can extract only published records
			$this->_CI->records->where('date_publish <= ' . time());
		}

		if ($tipo)
		{
			$this->_CI->records->type($tipo);

			$search_query = $this->_CI->input->get('search');
			if ($search_query)
			{
				$this->_CI->records->like('title', $search_query);
				$this->_CI->db->bracket('open');
				$this->_CI->records->or_like('content', $search_query);
				$this->_CI->db->bracket('close');
			}
		}
		//Just list fields, not the detail ones
		$this->_CI->records->set_list(TRUE);
		$this->_CI->records->language();

		$records = $this->_CI->records->documents(TRUE)->get();

		//If there's a limit, we will make a pagination
		if ($limit)
		{
			if ($tipo)
			{
				$this->_CI->records->type($tipo);
				if ($search_query)
				{
					$this->_CI->records->like('title', $search_query);
					$this->_CI->records->or_like('content', $search_query);
				}
			}
			if (isset($type['fields']['date_publish']))
			{
				//We can extract only published records
				$this->_CI->records->where('date_publish <= ' . time());
			}
			if ($sql_where) {
				$this->_CI->records->where($sql_where);
			}
			if (isset($category_record_ids))
			{
				$this->_CI->records->id_in($category_record_ids);
			}
			if (isset($hierarchies_record_ids))
			{
				$this->_CI->records->id_in($hierarchies_record_ids);
			}

			$count = $this->_CI->records->documents(FALSE)->set_list(TRUE)->language()->count();

			$pagination = array(
	        	'total_rows'			=> $count,
	        	'per_page'				=> $limit,
	        	'base_url'				=> current_url().'?',
	        	'first_link'			=> '&laquo; &laquo; В начало',
	        	'last_link'			=> 'В конец &raquo; &raquo;',
	        	'prev_link'			=> '&laquo; Предыдущая',
	        	'next_link'			=> 'Следующая &raquo;',
	        	'cur_tag_open'			=> '',
	        	'cur_tag_close'			=> '',
	        	'page_query_string'		=> TRUE,
	        	'query_string_segment'	=> 'page',
	        	'first_url'				=> current_url()
			);

			$this->_CI->view->set('total_records', $pagination['total_rows']);

			$this->_CI->load->library('pagination');
			$this->_CI->pagination->initialize($pagination);
		}

		$this->_CI->db->flush_cache();

		if ($this->_CI->view->is_feed && $this->_CI->view->is_feed != 'pdf')
		{
			$this->_CI->load->frlibrary('feed');

			if ($this->_CI->config->item('type_custom_feeds') && isset($type['name']))
			{
				$this->_CI->output->enable_profiler(FALSE);
				$page->set('records', $records);
				$this->_CI->view->set('page', $page);
				$GLOBALS['page'] = & $page;
				$this->_CI->view->set('records', $records);
				$GLOBALS['records'] = & $records;
				$this->_CI->view->render_type_template($type['name'], 'feed', TRUE);
				return;
			}

			$feed_header = array(
				'title' 		=> $page->get('title'),
				'description'	=> $page->get('content')
			);
			$this->_CI->feed->create_new($feed_header, $this->_CI->view->is_feed);

			if (count($records))
			{
				$url = site_url();
				foreach ($records as $record)
				{
					$date_pub = $record->get('_date_publish');
					if (!$date_pub)
					{
						$date_pub = $record->get('_date_insert');
					}
					$item = array(
						'title'			=> $record->get('title'),
						'link'			=> current_url().'/'.$record->get('uri'),
						'guid'			=> current_url().'/'.$record->get('uri'),
						'pubDate'		=> date(DATE_RFC822, (int)$date_pub),
						'description'	=> str_replace('src="/attach', 'src="'.$url.'attach', $record->get('content'))
					);
					$this->_CI->feed->add_item($item, array('title', 'description'));
				}
			}
			$this->_CI->feed->render();
			return;

		} else if ($page->get('action_list_has_feed') == 'T')
		{
			$this->_CI->view->has_feed = TRUE;
		}

		$page->set('records', $records);
		return $page;
	}

	/**
	 * Calls the action of a page
	 * Works only if the action_custom_name is set
	 * @param Record $page
	 */
	protected function call_action($page)
	{
		$folder = $this->_CI->config->item('custom_controllers_folder');
		define('CUSTOM_ACTION', TRUE);
		$custom_actions_controller = $folder . 'actions.php';
		require_once($custom_actions_controller);
		$actions = new Actions();
		$action_name = $page->get('action_custom_name');

		if (is_callable(array($actions, $action_name)))
		{
			$render_type = $page->get('action_custom_mode');
			if ($render_type == 'C')
			{
				$page->set('action', 'action_render');
				$page->set('_action_class', $actions);
			} else {
				$actions->$action_name('dispatcher');
				return;
			}
		} else {
			show_error('The custom action named "'.$action_name.'()" has not been found in '.$custom_actions_controller);
		}
	}

	/**
	 * Auto-routing method
	 * Based on the current URI
	 * @return Record|FALSE
	 */
	protected function get_current_record()
	{
		$found = FALSE;

		if (isset($this->_CI->tree))
		{
			//The current page/record segment
			$current_page = $this->_CI->tree->current_page_uri;
		}

		$current_request = $this->_CI->uri->uri_string();

		$result = array();
		if (isset($this->_CI->records))
		{
			//We extract a page based on the full request url
			$result = $this->_CI->records->set_type()
										 ->set_list(FALSE)
										 ->full_uri($current_request)
										 ->documents(FALSE)
										 ->where('lang', $this->_CI->lang->current_language)
										 ->limit(1)->get();
		}

		if (!count($result))
		{
			//If not found, let's search for the parent page
			$parent_page_uri = str_replace('/'.$current_page, '', $current_request);
			$result_pages = $this->_CI->records->full_uri($parent_page_uri)->documents(FALSE)->limit(1)->get();

			if (count($result_pages))
			{
				$page = $result_pages[0];

				//Page found! Now we need to find the child record
				if (in_array($page->get('action'), array('list', 'single')))
				{
					$child_type = $page->get('action_list_type');
					$result_childs = $this->_CI->records->type($child_type)->where('uri', $current_page)->documents(FALSE)->limit(1)->get();

					if (count($result_childs))
					{
						$record = $result_childs[0];
						$record->set('_parentpage', $page);
						return $record;
					}
				}
			}
		} else {
			//We get the first record
			return $result[0];
		}
		return FALSE;
	}
}