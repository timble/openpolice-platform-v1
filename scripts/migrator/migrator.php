#!/usr/bin/php
<?php
/** $Id$ */

$config = array(
	'ssh'	=> array(
		'host'		=> '',
		'port'		=> 0,
		'username'	=> '',
		'password'	=> ''
	),
	'mysql'	=> array(
		'username'	=> '',
		'password'	=> ''
	),
	'document_root'	=> '/var/www'
);

// Validate the arguments.
if($_SERVER['argc'] < 2 || substr($_SERVER['argv'][1], 0, 7) != '--site=')
{
	echo "Usage: migrator.php --site=1234\n\n";
	exit;
}

$site = trim(substr($_SERVER['argv'][1], 7));

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

$stream		= ssh2_exec($connection, 'test -d '.$config['document_root'].'/'.$site.' && echo "OK" || echo "FAILED"');
stream_set_blocking($stream, true);
$response	= fread($stream, 4096);
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

$stream		= ssh2_exec($connection, 'mysqldump --user="'.$config['mysql']['username'].'" --password="'.$config['mysql']['password'].'" --add-drop-table *database* | gzip > '.$config['document_root'].'/'.$site.'/database.sql.gz');
stream_set_blocking($stream, true);
$response	= fread($stream, 4096);
fclose($stream);

if($response != '')
{
	echo "\t\tFAILED\n\n";
	exit;
}

$stream		= ssh2_exec($connection, 'tar -czf /tmp/'.md5($site).'.tar.gz '.$config['document_root'].'/'.$site.'/public');
stream_set_blocking($stream, true);
$response	= fread($stream, 4096);
fclose($stream);

if($response == '') {
	echo "\t\tSUCCESS\n";
}
else
{
	echo "\t\tFAILED\n\n";
	exit;
}

// Retrieve the compressed site.
echo 'Retrieving site...';

if(ssh2_scp_recv($connection, '/tmp/'.md5($site).'.tar.gz', '/tmp/'.md5($site).'.tar.gz')) {
	echo "\t\tSUCCESS\n";
}
else
{
	echo "\t\tFAILED\n\n";
	exit;
}

echo "\n";