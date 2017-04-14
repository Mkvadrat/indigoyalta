<?php
/**
 * Breadcrumbs helper
 *
 * Helper functions for the breadcrumbs
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

if (!function_exists('breadcrumbs'))
{
	/**
	 * Prints the view breadcrumbs
	 * @param array $breadcrumbs_array
	 * @param string $separator
	 */
	function breadcrumbs($breadcrumbs_array = array(), $separator = ' &raquo; ')
	{
		$tmp = '';
		$current_uri = uri_string().'/';
		$site_url = site_url();
        $tmp .= '<span itemscope itemtype="http://schema.org/BreadcrumbList">';
	    
		if (count($breadcrumbs_array))
		{   $tmp .= '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
			$tmp .= '<a itemprop="item" href="'.$site_url.'"><span itemprop="name">Главная</span></a>'.$separator;
			$tmp .= '</span>';
            $record = record();
            if (!empty($record) && ($record instanceof Record) && $record->get('deal_type') == 'A') {
				$tmp .= '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
                $tmp .= '<a itemprop="item" href="'.$site_url.'rent"><span itemprop="name">Аренда</span></a>'.$separator;
				$tmp .= '</span>';
            } else if (!empty($record) && ($record instanceof Record) && $record->get('deal_type') == 'S') {
				$tmp .= '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
                $tmp .= '<a itemprop="item" href="'.$site_url.'sale"><span itemprop="name">Продажа</span></a>'.$separator;
				$tmp .= '</span>';
            }

			$i = 0;
			foreach ($breadcrumbs_array as $key => $breadcrumb)
			{
				if ($i > 0) $tmp.= $separator;

				if ($current_uri == $breadcrumb['link'])
				{ 
					$url = $breadcrumb['link'];
                    $url_curent = substr($url,0,strlen($url)-1);
                    $tmp .= '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
					$tmp.= $breadcrumb['title'];
					$tmp.= '<a class="invisible" itemprop="item" href="'. $site_url . $url_curent . '">'.'<span itemprop="name">'.$breadcrumb['title'].'</span>'.'</a>';
					$tmp .= '</span>';
					break;
				} else {
                    /*Текущее состояние(оригинал), убрать комментарий, если необходимо отключить слеш*/
					//$tmp.= '<a href="'.$site_url.$breadcrumb['link'].'">'.$breadcrumb['title'].'</a>';
					/*Текущее состояние(оригинал), убрать комментарий, если необходимо отключить слеш*/
					
				    /*Правки для отключения слеша*/
					$url = $breadcrumb['link'];
                    $url_curent = substr($url,0,strlen($url)-1);
                    $tmp .= '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
					$tmp.= '<a itemprop="item" href="'. $site_url . $url_curent . '">'.$breadcrumb['title'].'</a>';  
					$tmp .= '</span>';
					/*Правки для отключения слеша*/
				}
				$i++;
			}

		}
		
		$tmp .= '</span>';
		
		return $tmp;
	}
}