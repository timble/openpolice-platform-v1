#!/usr/bin/php
<?php
/** $Id$ */

$config = array(
	'site_path'	=> '/var/www'
);

$action	= trim(substr($_SERVER["argv"][1], 9));
$site	= trim(substr($_SERVER["argv"][2], 7));

switch($action)
{
	case 'validate':
		echo is_dir($config['site_path'].'/'.$site) ? 'SUCCESS' : 'FAILED';
		break;

	case 'compress':
		$response = shell_exec('tar -czf /tmp/'.md5($site).'.tar.gz '.$config['site_path'].'/'.$site.'/public');

		echo $response == '' ? 'SUCCESS' : 'FAILED';
		break;
}

exit;