<?php
error_reporting(E_ALL);
ini_set('display_errors', 'off');

header('Content-Type: text/css');
require "lessc.inc.php";
$less = new lessc;
$less->setFormatter("compressed");

$less->setVariables(array(
	'mnfSize' => '14', //base font size
	'baseColor' => '#f5f5f5', // base light bg
	'mnColor' => '#292a2f', // base sidebar bg
	'brdColor' => '#b6b6b6', // base border color

	'mnLink' => '#d4dae3',
	'mnIcon' => '#9197a0',

	'grdTopColor' => '#fefefe', // regular button top
	'grdBotColor' => '#dadada',	// regular button bottom

));

echo $less->compileFile("corecss/master.less");
