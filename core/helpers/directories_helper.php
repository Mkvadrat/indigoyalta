<?php
/**
 * Directories helper
 *
 * Some functions to work with directories
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */


/**
 * Completely deletes a directory and its files
 * @param string $dir The directory to remove
 */
if (!function_exists('delete_directory'))
{
	function delete_directory($dir)
	{
	    $dir = str_replace('//', '/', $dir);
	    if (!file_exists($dir)) return true;
	    if (!is_dir($dir) || is_link($dir)) return @unlink($dir);
	    foreach (scandir($dir) as $item) {
	    	if ($item == '.' || $item == '..') continue;
	    	if (!delete_directory($dir . "/" . $item)) {
	    		@chmod($dir . "/" . $item, 0777);
	        	if (!delete_directory($dir . "/" . $item)) return false;
	    	};
	    }
	    return rmdir($dir);
	}
}