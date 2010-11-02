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
		$arguments[$option] = trim($value, '"');
	}
}

if(!isset($arguments['site']))
{
	echo "Required argument 'site' is not specified.\n";
	echo "Usage: migrator.php --site=1234\n\n";
	exit;
}

$site		= $arguments['site'];
$site_md5	= md5($site);

// Set mysql username.
if(empty($config['mysql']['username'])) {
	$config['mysql']['username'] = 'tor'.$site;
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

$stream		= ssh2_exec($connection, 'test -d '.$config['document_root'].'/'.$site.' && echo "OK" || echo "FAILED"');
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

$stream		= ssh2_exec($connection, 'mysqldump --user="'.$config['mysql']['username'].'" --password="'.$config['mysql']['password'].'" --add-drop-table --add-drop-database --databases police_'.$site.' | gzip > '.$config['document_root'].'/'.$site.'/database.sql.gz');
stream_set_blocking($stream, true);
$response	= trim(fread($stream, 4096));
fclose($stream);

if($response != '')
{
	echo "\t\tFAILED\n\n";
	exit;
}

$stream		= ssh2_exec($connection, 'tar -C '.$config['document_root'].'/'.$site.' -czf /tmp/'.$site_md5.'.tar.gz images dmdocuments database.sql.gz');
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

if(ssh2_scp_recv($connection, '/tmp/'.$site_md5.'.tar.gz', '/tmp/'.$site_md5.'.tar.gz')) {
	echo "\t\tOK\n";
}
else
{
	echo "\t\tFAILED\n\n";
	exit;
}

// Uncompress the site.
echo 'Uncompressing site...';

mkdir('/tmp/'.$site_md5);
shell_exec('cd /tmp/'.$site_md5.' && tar -xzf ../'.$site_md5.'.tar.gz');

echo "\t\tOK\n";

// Move files.
echo 'Moving files...';

if(!is_dir('/var/www/public/sites/'.$site)) {
	mkdir('/var/www/public/sites/'.$site);
}

if(is_dir('/tmp/'.$site_md5.'/images'))
{
	if(!is_dir('/var/www/public/sites/'.$site.'/images')) {
		mkdir('/var/www/public/sites/'.$site.'/images');
	}

	shell_exec('cp -R /tmp/'.$site_md5.'/images/* /var/www/public/sites/'.$site.'/images/');
}

if(is_dir('/tmp/'.$site_md5.'/dmdocuments'))
{
	if(!is_dir('/var/www/public/sites/'.$site.'/documents')) {
		mkdir('/var/www/public/sites/'.$site.'/documents');
	}

	shell_exec('cp -R /tmp/'.$site_md5.'/dmdocuments/* /var/www/public/sites/'.$site.'/documents/');
}

echo "\t\t\tOK\n";

// Import database.
echo 'Importing database...';

shell_exec('cd /tmp/'.$site_md5.' && gunzip database.sql.gz && mv database.sql database.sql.old');
shell_exec('cd /tmp/'.$site_md5.' && sed \'s/http:\/\/217.21.184.146\/'.$site.'\///g\' database.sql.old > database.sql');
shell_exec('cd /tmp/'.$site_md5.' && mysql --user="root" --password="" < database.sql');

echo "\t\tOK\n";

$users = array(
	'gergo@timble.net'
);

mail(implode(', ', $users), 'Site migration completed', 'Migration of site \''.$site.'\' completed.');

echo "\n";