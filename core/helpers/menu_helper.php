<?php
/**
 * Menu helper
 *
 * The website menu helpers
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */


/**
 * Prints a tree as an HTML (UL>LI>A tags)
 * @param array $tree The tree that we print
 * @param int $max_depth Max depth
 * @param int $level Starting level
 * @param string $show_in_menu The only value of the column "show_in_menu" to accept
 * @param string $str A private string for internal use
 * @return xhtml
 */


function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}


function wbsmenu(&$tree, $max_depth=99, $level=1, $show_in_menu='T', &$str=''){
	if (is_array($tree) && count($tree) && $level <= $max_depth ) {
//		if ($level == 1) {
//			$str .= '<ul>';
//		}

		print_r($tree);

		aasort($tree,"priority");

		foreach ($tree as $page) {
			if ($page['show_in_menu'] == $show_in_menu)
			{
				
				
				$str .= '<li>';
				$str .= '<a href="#wbs-'.$page['link'].'">'.$page['title'].'</a>';
//				if (isset($page['sons']))
//				{
//					$str .= '<ul>';
//					$str .= menu($page['sons'], $max_depth, $level+1, $show_in_menu='T');
//					$str .= '</ul>';
//				}
				$str .= '</li>';
			}
		}
//		if ($level == 1) {
//			$str .= '</ul>';
//		}
	}
	return $str;
}

function menu(&$tree, $max_depth=99, $level=1, $show_in_menu='T', &$str=''){
	if (is_array($tree) && count($tree) && $level <= $max_depth ) {
		if ($level == 1) {
			$str .= '<ul>';
		}
		aasort($tree,"priority");

		foreach ($tree as $page) {
			if ($page['show_in_menu'] == $show_in_menu)
			{
				
				
				$str .= '<li class="'.($page['open'] ? 'open' : '').($page['selected'] ? ' current' : '').'">';
				$str .= '<a href="'.site_url($page['link']).'">'.$page['title'].'</a>';
				if (isset($page['sons']))
				{
					$str .= '<ul>';
					$str .= menu($page['sons'], $max_depth, $level+1, $show_in_menu='T');
					$str .= '</ul>';
				}
				$str .= '</li>';
			}
		}
		if ($level == 1) {
			$str .= '</ul>';
		}
	}
	return $str;
}

function leftmenu(&$tree, $max_depth=99, $level=1, $show_in_menu='T', &$str='', $dropmenu_rent=null){
	if (is_array($tree) && count($tree) && $level <= $max_depth ) {
		if ($level == 1) {
//			$str .= '<ul>';
		}
		aasort($tree,"priority");
		$str .= '<li><a href="'.site_url().'" title="Главная">Главная</a> </li>';
        $str .= '<li><a href="javascript:void(0)" class="title_m">Продажа</a></li>';
		foreach ($tree as $page) {
			if ($page['show_in_menu'] == $show_in_menu) {
				if (trim($page['link'], '/') == 'stroitelstvo-i-dizajn') {
					$str .= '</ul><div class="binder-fx-6"></div><div class="corner-tl"></div><div class="corner-tr"></div><div class="corner-bl"></div><div class="corner-br"></div></div>';
                    $str .= '<div class="sidebar-menu"><div class="title_mm">перейти в раздел:</div><a href="/rent" class="title-dark">Аренда</a><div class="prug"></div><div class="corner-tl"></div><div class="corner-tr"></div><div class="corner-bl"></div><div class="corner-br"></div>';

                    if (false) {
                    $str .= '<div class="sidebar-menu hovered">';

                    if($dropmenu_rent && count($dropmenu_rent)){
                        $str .= '<ul class="menu">';
                        $str .= '<li><a href="javascript:void(0)" class="title_m">Аренда</a></li>';
                        foreach ($dropmenu_rent as $dropitem){
                            $str .= '<li><a href="'.semantic_url($dropitem).'" title="'.$dropitem->get('title').'">'.$dropitem->get('title').'</a></li>';
                        }
                        $str .= '<div class="niz"></div><div class="corner-tl"></div><div class="corner-tr"></div><div class="corner-bl"></div><div class="corner-br"></div>';
                        $str .= '</ul>';
                    }

                    $str .= '</div>';
                    }
                    $str .= '</div>';
					$str .= '<div class="sidebar-menu"><ul class="menu">';
				}
				$str .= '<li class="'.($page['open'] ? 'open' : '').($page['selected'] ? ' selected' : '').'"><a href="'.site_url($page['link']).'">'.$page['title'].'</a></li>';
			}
		}
		if ($level == 1) {
//			$str .= '</ul>';
		}
	}
	return $str;
}

function render_leftmenu ($max_depth=99, $level=1, $show_in_menu='T', &$str='', $dropmenu_rent=null){
    return leftmenu(tree(), $max_depth, $level, $show_in_menu, $str, $dropmenu_rent);
}

function leftmenu_rent(&$tree, $max_depth=99, $level=1, $show_in_menu_rent='T', &$str='', $dropmenu_rent=null){
    if (is_array($tree) && count($tree) && $level <= $max_depth ) {
        if ($level == 1) {
//			$str .= '<ul>';
        }
        aasort($tree,"priority");
        $str .= '<li><a href="'.site_url().'" title="Главная">Главная</a> </li>';
        $str .= '<li><a href="javascript:void(0)" class="title_m">Аренда</a></li>';
        foreach ($tree as $page) {
            if ($page['show_in_menu_rent'] == $show_in_menu_rent) {
                if (trim($page['link'], '/') == 'stroitelstvo-i-dizajn') {
                    $str .= '</ul><div class="binder-fx-6"></div><div class="corner-tl"></div><div class="corner-tr"></div><div class="corner-bl"></div><div class="corner-br"></div></div>';
                    $str .= '<div class="sidebar-menu"><div class="title_mm">перейти в раздел:</div><a href="/sale" class="title-dark">Продажа</a><div class="prug"></div><div class="corner-tl"></div><div class="corner-tr"></div><div class="corner-bl"></div><div class="corner-br"></div>';

                    if (false) {
                    $str .= '<div class="sidebar-menu hovered">';

                    if($dropmenu_rent && count($dropmenu_rent)){
                        $str .= '<ul class="menu">';
                        $str .= '<li><a href="javascript:void(0)" class="title_m">Продажа</a></li>';
                        foreach ($dropmenu_rent as $dropitem){
                            $str .= '<li><a href="'.semantic_url($dropitem).'" title="'.$dropitem->get('title').'">'.$dropitem->get('title').'</a></li>';
                        }
                        $str .= '<div class="niz"></div><div class="corner-tl"></div><div class="corner-tr"></div><div class="corner-bl"></div><div class="corner-br"></div>';
                        $str .= '</ul>';
                    }

                    $str .= '</div>';
                    }
                    $str .= '</div>';
                    $str .= '<div class="sidebar-menu"><ul class="menu">';
                }
                $str .= '<li class="'.($page['open'] ? 'open' : '').($page['selected'] ? ' selected' : '').'"><a href="'.site_url($page['link']).'">'.$page['title'].'</a></li>';
            }
        }
        if ($level == 1) {
//			$str .= '</ul>';
        }
    }
    return $str;
}

function render_leftmenu_rent($max_depth=99, $level=1, $show_in_menu_rent='T', &$str='', $dropmenu_rent=null) {
    return leftmenu_rent(tree('rent'), $max_depth, $level, $show_in_menu_rent, $str, $dropmenu_rent);
}

function render_left_menu_by_category($category, $dropmenu, $dropmenu_rent) {

    $leftmenu_str = '';

    $rent_urls = array(
        'rent',
        '1kom-kvartiry-posutochno',
        '2k-kvartiry-posutochno',
        '3-k-kv-i-bolee-posutochno',
        'elitnye-apartamenty-posutochno',
        'mini-oteli-posutochno',
        'doma-posutochno'
    );

    $record = record();

    if (!empty($record) && ($record instanceof Record) && $record->get('deal_type') == 'A') {
        return render_leftmenu_rent(1, 1, 'T', $leftmenu_str, $dropmenu);
    } else if (in_array($category, $rent_urls)) {
        return render_leftmenu_rent(1, 1, 'T', $leftmenu_str, $dropmenu);
    } else {
        return render_leftmenu(1, 1, 'T', $leftmenu_str, $dropmenu_rent);
    }
}

function get_menu_category() {
    $CI =& get_instance();
    return $CI->uri->uri_string();
}

function mainmenu(&$tree, $max_depth=99, $level=1, $show_in_menu='T', &$str=''){
	global $B;

	if (is_array($tree) && count($tree) && $level <= $max_depth ) {
//		if ($level == 1) {
//			$str .= '<ul>';
//		}
		aasort($tree,"priority");
		if($B->lang->current_language == 'ru'){
//			$str .= '<li class="'.($page['open'] ? 'open' : '').($page['selected'] ? ' selected' : '').'"><a href="/">Главная</a></li>';
			$str .= '<li><a href="/">Главная</a></li>';
		}elseif($B->lang->current_language == 'en') {
//			$str .= '<li class="'.($page['open'] ? 'open' : '').($page['selected'] ? ' selected' : '').'"><a href="/">Home</a></li>';
			$str .= '<li><a href="/">Home</a></li>';
		}
		foreach ($tree as $page) {
			if ($page['show_in_menu'] == $show_in_menu)
			{
				$str .= '<li class="'.($page['open'] ? 'open' : '').($page['selected'] ? ' selected' : '').'">';
				$str .= '<a href="'.site_url($page['link']).'">'.$page['title'].'</a>';
				$str .= '</li>';
			}
		}
//		if ($level == 1) {
//			$str .= '</ul>';
//		}
	}
	return $str;
}



