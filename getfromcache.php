<?php
// PHP Voxygen 1.0
// Forked by TiBounise (http://tibounise.com) based on the inital code of mGeek (http://mgeek.fr)

$path = 'cache/'.$_GET['id'];

if (file_exists($path)) {
	header('Content-disposition: attachment; filename='.$_GET['id']);
	header('Content-Type: application/force-download');
	header('Content-Transfer-Encoding: application/octet-stream\n');
	header('Content-Length: '.filesize($path));
	header('Pragma: no-cache');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0, public');
	header('Expires: 0');
	readfile($path);
} else {
	die('The entered ID is incorrect !');
}

?>