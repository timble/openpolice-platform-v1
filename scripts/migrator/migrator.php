#!/usr/bin/php
<?php
/** $Id$ */

$config = array(
	'ssh'	=> array(
		'host'		=> '217.21.184.146',
		'port'		=> 22,
		'username'	=> 'police',
		'password'	=> 'P?W88nP3!eg'
	),
	'mysql'	=> array(
		'username'	=> '',
		'password'	=> 'mWLnbw6d'
	),
	'document_root'	=> '/var/www/vhosts/police.be/httpdocs'
);

// Validate and get the arguments.
foreach($_SERVER['argv'] as $argument)
{
	if(substr($argument, 0, 2) == '--' && strpos($argument, '=') !== false)
	{
		list($option, $value) = explode('=', substr($argument, 2), 2);
		$arguments[$option] = $value;
	}
}

if(!isset($arguments['site']))
{
	echo "Required argument 'site' is not specified.\n";
	echo "Usage: migrator.php --site=1234\n\n";
	exit;
}

// Set mysql username.
if(!isset($config['mysql']['username'])) {
	$config['mysql']['username'] = 'tor'.$arguments['site'];
}

// Connect to the server.
echo 'Connecting...';

if($connection = ssh2_connect($config['ssh']['host'], $config['ssh']['port'])) {
	echo "\t\t\tOK\n";
}
else
{
	echo "\t\t\tFAILED\n\n";
	exit;
}

// Authenticate.
echo 'Authenticating...';

if(@ssh2_auth_password($connection, $config['ssh']['username'], $config['ssh']['password'])) {
	echo "\t\tOK\n";
}
else
{
	echo "\t\tFAILED\n\n";
	exit;
}

// Validate the site.
echo 'Validating site...';

$stream		= ssh2_exec($connection, 'test -d '.$config['document_root'].'/'.$arguments['site'].' && echo "OK" || echo "FAILED"');
stream_set_blocking($stream, true);
$response	= trim(fread($stream, 4096));
fclose($stream);

if($response == 'OK') {
	echo "\t\tOK\n";
}
else
{
	echo "\t\tFAILED\n\n";
	exit;
}

// Compress the site.
echo 'Compressing site...';

$stream		= ssh2_exec($connection, 'mysqldump --user="'.$config['mysql']['username'].'" --password="'.$config['mysql']['password'].'" --add-drop-table police_'.$arguments['site'].' | gzip > '.$config['document_root'].'/'.$arguments['site'].'/database.sql.gz');
stream_set_blocking($stream, true);
$response	= trim(fread($stream, 4096));
fclose($stream);

if($response != '')
{
	echo "\t\tFAILED\n\n";
	exit;
}

$stream		= ssh2_exec($connection, 'tar -C '.$config['document_root'].'/'.$arguments['site'].' -czf /tmp/'.md5($arguments['site']).'.tar.gz .');
stream_set_blocking($stream, true);
$response	= trim(fread($stream, 4096));
fclose($stream);

if($response == '') {
	echo "\t\tOK\n";
}
else
{
	echo "\t\tFAILED\n\n";
	exit;
}

// Retrieve the compressed site.
echo 'Retrieving site...';

if(ssh2_scp_recv($connection, '/tmp/'.md5($arguments['site']).'.tar.gz', '/tmp/'.md5($arguments['site']).'.tar.gz')) {
	echo "\t\tOK\n";
}
else
{
	echo "\t\tFAILED\n\n";
	exit;
}

echo "\n";