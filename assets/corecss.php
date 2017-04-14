<?php

header('Content-Type: text/css');
require "lessc.inc.php";

$less = new lessc;
$less->setFormatter("compressed");

$less->setVariables(array(
	// Font
	'@baseFontFamily' => "Georgia, \"Times New Roman\", Times, serif",
	'@headingsFontFamily' => "Georgia, \"Times New Roman\", Times, serif",
	'@inputFontFamily' => "Georgia, \"Times New Roman\", Times, serif",
	'@buttonFontFamily' => "Georgia, \"Times New Roman\", Times, serif",
	'@codeFontFamily' => "Consolas, Monaco, monospace, sans-serif",
	
	// Base color
	'@colorBody' => "#333",
	'@colorHeadings' => "#222",
	
	// Type
	'@baseFontSize' => "16",
	'@baseLineHeight' => "1.65",
	'@baseLine' => "18",
	
	// Grid
	'@gridWidth' => "1000",
	'@gridGutterWidth' => "30",
	
	// Misc sizes
	'@listsLeft' => "2em",
	'@columnarWidth' => "150px",
	'@columnarMargin' => "20px",
	
	// Font sizes
	'@bigFontSize' => "1.2em",
	'@smallFontSize' => "0.85em",
	'@superSmallFontSize' => "0.7em",
	
	// FloatingImages
	'@floatingMargin' => "1em",
	'@floatingBackgroundColor' => "#fff",
	'@floatingPadding' => "0",
	'@floatingBorder' => "none",
	
	// LinkColor
	'@colorLink' => "#369",
	'@colorLinkHover' => "#ef6465",
	
	// Colors
	'@colorBlack' => "#000",
	'@colorGrayDark' => "#555",
	'@colorGray' => "#777",
	'@colorGrayLight' => "#999",
	'@colorWhite' => "#fff",
	'@colorRed' => "#ef6465",
	'@colorOrange' => "#f48a30",
	'@colorGreen' => "#90af45",
	'@colorBlue' => "#1c7ab4",
	'@colorYellow' => "#f3c835",
	
	// BackgroundColor
	'@markBackgroundColor' => "#fe5",
	'@codeBackgroundColor' => "#f5f5f5",
	'@tfootBackgroundColor' => "#f2f2f2",
	'@colorStripedTable' => "#f5f5f5",
	'@colorHoveredTable' => "#f6f6f6",
	
	// Borders
	'@cellBorder' => "1px solid #eee",
	'@cellBorderDark' => "1px solid #ddd",
	'@fieldsetBorder' => "1px solid #e3e3e3",
	
	// Util
	'@em' => "@baseFontSize*1em",	// outputting ems, e.g. 14/'@em

));

echo $less->compileFile("less/master.less");

