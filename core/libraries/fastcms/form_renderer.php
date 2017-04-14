<?php
/**
 * Form Renderer Class
 *
 * A helper for the administration forms
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

Class Form_renderer
{
  	/**
  	 * Prints the sidebar of a content type (fieldsets list)
  	 * @param array $tipo Content type
  	 * @return xhtml
  	 */
  	public function get_sidebar($tipo)
  	{
  		$xhtml = '';
  		$first = true;
  		foreach ($tipo['fieldsets'] as $fieldset) {
			$xhtml.= '<li><a href="#sb-' .$this->translitName($fieldset['name']). '" '. ($first ? ' class="active"':'') . '>';
  		$first = false;
			if (isset($fieldset['icon'])) {
				$xhtml.= '<i class="fa fa-'.$fieldset['icon'].' fa-fw"></i> ';
			}
			$xhtml.= _($fieldset['name']) . '</a></li>';
		}
		if ($tipo['has_categories']) {
			$xhtml.= '<li><a href="#sb_category"><i class="fa fa-list-ul fa-fw"></i> Категории</a>';
		}
		if ($tipo['has_hierarchies']) {
			$xhtml.= '<li><a href="#sb_hierarchies"><i class="fa fa-random fa-fw"></i> Связки</a>';
		}
		if (isset($tipo['relations'])) {
			$xhtml.= '<li><a href="#sb_relations"><i class="fa fa-code-fork fa-rotate-90 fa-fw"></i> Дочерние</a>';
		}
		return $xhtml;
  	}
	
	public function translitName($str)
	{
		$tr = array(
			"А" => "A",
			"Б" => "B",
			"В" => "V",
			"Г" => "G",
			"Д" => "D",
			"Е" => "E",
			"Ж" => "J",
			"З" => "Z",
			"И" => "I",
			"Й" => "Y",
			"К" => "K",
			"Л" => "L",
			"М" => "M",
			"Н" => "N",
			"О" => "O",
			"П" => "P",
			"Р" => "R",
			"С" => "S",
			"Т" => "T",
			"У" => "U",
			"Ф" => "F",
			"Х" => "H",
			"Ц" => "TS",
			"Ч" => "CH",
			"Ш" => "SH",
			"Щ" => "SCH",
			"Ъ" => "",
			"Ы" => "YI",
			"Ь" => "",
			"Э" => "E",
			"Ю" => "YU",
			"Я" => "YA",
			"а" => "a",
			"б" => "b",
			"в" => "v",
			"г" => "g",
			"д" => "d",
			"е" => "e",
			"ж" => "j",
			"з" => "z",
			"и" => "i",
			"й" => "y",
			"к" => "k",
			"л" => "l",
			"м" => "m",
			"н" => "n",
			"о" => "o",
			"п" => "p",
			"р" => "r",
			"с" => "s",
			"т" => "t",
			"у" => "u",
			"ф" => "f",
			"х" => "h",
			"ц" => "ts",
			"ч" => "ch",
			"ш" => "sh",
			"щ" => "sch",
			"ъ" => "y",
			"ы" => "yi",
			"ь" => "",
			"э" => "e",
			"ю" => "yu",
			"я" => "ya",
			'!' => "",
			'*' => "",
			"'" => "",
			"(" => "",
			")" => "",
			";" => "",
			":" => "",
			"@" => "",
			"&" => "and",
			"=" => "",
			"+" => "plus",
			"$" => "",
			"," => "",
			"/" => "",
			"?" => "",
			"%" => "percent",
			"#" => "",
			"[" => "",
			"]" => "",
			"«" => "",
			"»" => ""
		);
		
		$readyname = strtolower(strtr($str, $tr));
		return preg_replace('/\s+/', '', $readyname);
	}

}