<?php
/**
 * Frontend Helper
 *
 * Some utilities for the website front-end
 * The following functions are well-documented on the official
 * documenation available here: http://docs.getfastcms.com
 * ----------------------------------------
 * Please do not change the functions below.
 * Instead, feel free to copy and rename them.
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

require_once 'MoneyRates.php';
require_once 'Price.php';


function render($who)
{
	global $B;
	$B->load->view($who);
}

function template()
{
	global $B;
	$B->load->view($B->view->get('_template_file'));
}

function settings($name)
{
	global $B;
	return $B->settings->get($name);
}

function type($type_name)
{
	global $B;
	return $B->content->type($type_name);
}

function content_render()
{
	global $B;
	$B->load->view('content_render');
}

function load_helper($name='')
{
	global $B;
	$B->load->helper($name);
}

function page($what='')
{
	global $page;
	if (!isset($page)) return FALSE;
	if ($what == '') return $page;
	return $page->get($what);
}


function tree($which='') {
	
	global $B;

	if (is_numeric($which))
		return $B->tree->get_default_branch($which);

	switch($which) {
		case '':
		case 'default':
			$tree = $B->view->get('tree');
			if (!$tree) {
				return $B->tree->get_default();
			}
			return $tree;
        case 'rent':
            $tree = $B->view->get('tree_rent');
            if (!$tree) {
                return $B->tree->get_by_category('rent');
            }
            return $tree;
		case 'current':
			return $B->tree->get_current_branch();
		
		case 'breadcrumbs':
			return $B->tree->breadcrumbs;
	}
}

function record($what='')
{
	global $record;
	if (!isset($record)) return FALSE;
	if ($what == '') return $record;
	return $record->get($what);
}

function records()
{
	global $page;
	if (!isset($page)) return FALSE;
	$records = & $page->get('records');
	return is_array($records) && count($records) ? $records : FALSE;
}

function have_records()
{
	global $page;
	if (!isset($page)) return FALSE;
	$records = & $page->get('records');
	return is_array($records) && count($records);
}

function page_feed()
{
	global $B;
	if ($B->view->has_feed)
    {
      echo link_tag(current_url().'/feed.xml', 'alternate', 'application/rss+xml', page('title') . ' - Feed');
    }
}

function page_css()
{
	$css = page('view_css');
	if ($css)
	{
		echo '<style type="text/css">' . $css . '</style>';
	}
}

function page_js()
{
	$js = page('view_js');
   	if ($js)
   	{
   		echo '<script type="text/javascript">' . $js . '</script>';
   	}
}

function title($sep = ' - ')
{
	global $B;
//	if (!(count($this->uri->segments))){
//		return $B->view->title;
//	}else {
	return $B->view->title ? $B->view->title . $sep : settings('website_global_title');
//	}
}

function module($name, $config = array())
{
	global $B;
	return $B->load->module($name, $config);
}

function find($type = '')
{
	global $B;
	return $type =! '' ? $B->records->type($type) : $B->records;
}


/**
 * 
 * @global WebSite $B
 * @param int $type
 * @return Model_categories
 */
function categories($type = '') {
	global $B;
	if (!isset($B->categories))
		$B->load->categories();
	
	if ($type != '')
		return $B->categories->type($type);
	
	return $B->categories;
}


function recordsimilar($record, $limit = 5) {
	
	global $B;
	$B->load->categories();
//	$B->load->content();
	
	$recordID = $record->get('id_record');
	
	$record_type = $B->content->type($recordID);

	$record_categories = $B->categories->get_record_categories($recordID);
	$records_ids = categories()->get_records_for_categories($record_categories);

	$ids_to_extract = array();
	foreach ($records_ids as $record_id) {
		if ($record_id != $recordID)
			$ids_to_extract[] = $record_id;
	}
	if (!count($ids_to_extract)) return array();
	
	
	$currency = settings('website_pricecurrency'); 
	$field = '';
	if ($record->get('deal_type') == 'S') {
		$price = (int)$record->get($currency.'_total');
		if ($price <= 0)
			return array();
		$field = $currency.'_total';
	}
	elseif ($record->get($currency.'_month') > 0) {
		$price = (int)$record->get($currency.'_month');
		$field = $currency.'_month';
	}
	elseif ($record->get($currency.'_day') > 0) {
		$price = (int)$record->get($currency.'_day');
		$field = $currency.'_day';
	}
	else
		return array();
	
	if ($field != '' && $price == 0)
		return array();
	
	$relatedlist = find('realestate')->documents(TRUE)
		->where('frontstate', 'N')
		->id_in($ids_to_extract)->get();
	
	$num = 0;
	$result = array();
	$minprice = floor($price * 0.75);
	$maxprice = ceil($price * 1.25);
	foreach ($relatedlist as $related_record) {
		
		if ($field == 'usd_total' && $price >= 300000) {
			if ($related_record->get('deal_type') != 'S')
				continue;
			if ($related_record->get('usd_total') < 300000)
				continue;
		}
		elseif ($field != '') {
			$rprice = (int)$related_record->get($field);
			if ($rprice < $minprice || $rprice > $maxprice)
				continue;
		}
		
		$result[] = $related_record;
		$num++;
		if ($num >= $limit)
			break;
	}

	return $result;

}

function recordCategoriesIds($record)
{
	global $B;
	$B->load->categories();

	$ids = $B->categories->get_record_categories($record);
	return $ids[0];

}





function related_records($record, $limit = 5)
{
	if (! $record instanceof Record) return array();
	

	$record_categories = $record->categories();

	$records_ids = categories()->get_records_for_categories($record_categories);

	$ids_to_extract = array();
	foreach ($records_ids as $record_id) {
		if ($record_id != $record->id && count($ids_to_extract) <= $limit) {
			$ids_to_extract[] = $record_id;
		}
	}
	if (!count($ids_to_extract)) return array();

	return find($record->_tipo)->id_in($ids_to_extract)->limit($limit)->get();
}

function page_author()
{
	global $B;
	return $B->view->author;
}

function page_keywords()
{
	global $B;
	return $B->view->keywords;
}

function page_description()
{
	global $B;
	return $B->view->description;
}

function pagination()
{
	global $B;
	if (isset($B->pagination))
	{
		return $B->pagination->create_links();
	}
}

function languages($sep = '&nbsp;')
{
	global $B;
	$langs = $B->settings->get('website_active_languages');
	$all_langs = & $B->lang->languages;
	if (is_array($langs) && count($langs))
	{
		foreach ($langs as $lang)
		{
			if (isset($all_langs[$lang])) {
				echo '<a href="'.site_url('change-language/'.$lang, FALSE).'">'.$all_langs[$lang]['description'].'</a>' . $sep;
			}
		}
	}
}

function languageicons()
{
	global $B;
	$langs = $B->settings->get('website_active_languages');
	$all_langs = & $B->lang->languages;
	if (is_array($langs) && count($langs))
	{
		foreach ($langs as $lang)
		{
			if (isset($all_langs[$lang])) {
				echo '<a class="lang-'.$lang.'" href="'.site_url('change-language/'.$lang, FALSE).'"></a>';
			}
		}
	}
}

function language()
{
	global $B;
	return $B->lang->current_language;
}


function fromsettingspage($page_id)
{
	$requested = find('Menu')->limit(1)->where('id_record', $page_id)->get();
	$link = index_page().semantic_url($requested[0]);
	
	return $link;
}

function truncate($str, $length, $breakWords = TRUE, $append = '…') {
  $strLength = mb_strlen($str);

  if ($strLength <= $length) {
     return $str;
  }

  if ( ! $breakWords) {
       while ($length < $strLength AND preg_match('/^\pL$/', mb_substr($str, $length, 1))) {
           $length++;
       }
  }

  return mb_substr($str, 0, $length) . $append;
}
					function getFn($sort) {
						return function($a, $b) use($sort) {
							if($a->$sort > $b->$sort) return 1;
							if($a->$sort < $b->$sort) return -1;
							return 0;
						};
					}
