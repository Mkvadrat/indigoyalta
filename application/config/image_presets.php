<?php defined('FASTCMS') or exit;

/*
|--------------------------------------------------------------------------
| Application Image Presets
|--------------------------------------------------------------------------
|
*/

//I'm just a demo preset
$config['presets']['user_profile'] = array(
	array(
		'operation' => 'resize',
		'size' => '150x150',
		'fixed' => TRUE,
		'quality' => 100,
		'ratio' => TRUE
	),
	array(
		'operation' => 'crop',
		'size' => '125x125',
		'quality' => 80,
		'x' => 25,
		'y' => 25
	)
);

$config['presets']['thumbnail'] = array(
	array(
		'operation' => 'resize',
		'size' => '170x120',
		'fixed' => TRUE,
		'quality' => 100,
		'ratio' => TRUE
	),
	array(
		'operation' => 'crop',
		'size' => '170x120',
		'quality' => 100,
	)
);

$config['presets']['og_thumbnail'] = array(
	array(
		'operation' => 'resize',
		'size' => '600x?',
		'fixed' => TRUE,
		'quality' => 100,
		'ratio' => TRUE
	),
);

$config['presets']['thumbnail'] = array(
	array(
		'operation' => 'resize',
		'size' => '170x120',
		'fixed' => TRUE,
		'quality' => 100,
		'ratio' => TRUE
	),
	array(
		'operation' => 'crop',
		'size' => '170x120',
		'quality' => 100,
	)
);


$config['presets']['testmonial'] = array(
	array(
		'operation' => 'resize',
		'size' => '650x?',
		'fixed' => TRUE,
		'quality' => 100,
		'ratio' => TRUE
	),
	array(
		'operation' => 'crop',
		'size' => '650x280',
		'quality' => 100,
		'x' => 0,
		'y' => 0
	)
);

$config['presets']['similar'] = array(
	array(
		'operation' => 'resize',
		'size' => '90x64',
		'fixed' => TRUE,
		'quality' => 100,
		'ratio' => TRUE
	),
	array(
		'operation' => 'crop',
		'size' => '90x64',
		'quality' => 100,
	)
);

$config['presets']['photo'] = array(
	array(
		'operation' => 'resize',
		'size' => '?x120',
		'fixed' => TRUE,
		'quality' => 100,
		'ratio' => TRUE
	),
);


