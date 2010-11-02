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

$stream		= ssh2_exec($connection, 'mysqldump --user="'.$config['mysql']['username'].'" --password="'.$config['mysql']['password'].'" --add-drop-database --databases police_'.$site.' | gzip > '.$config['document_root'].'/'.$site.'/database.sql.gz');
stream_set_blocking($stream, true);
$response	= trim(fread($stream, 4096));
fclose($stream);

if($response != '')
{
	echo "\t\tFAILED\n\n";
	exit;
}

$stream		= ssh2_exec($connection, 'tar -C '.$config['document_root'].'/'.$site.' -czf /tmp/'.$site_md5.'.tar.gz images dmdocuments database.sql.gz configuration.php');
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

mkdir('/tmp/'.$site_md5, 0775);
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

shell_exec('cd /tmp/'.$site_md5.' && gunzip database.sql.gz');
shell_exec('cd /tmp/'.$site_md5.' && mv database.sql database.sql.old');
shell_exec('cd /tmp/'.$site_md5.' && sed -e \'s/http:\/\/217.21.184.146\/'.$site.'\///g\' -e \'s/`jos_/`pol_/g\' database.sql.old > database.sql');
shell_exec('cd /tmp/'.$site_md5.' && mysql --user="root" --password="" < database.sql');
shell_exec('mysql --user="root" --password="" police_'.$site.' < migrator.sql');

echo "\t\tOK\n";

// Create configuration.
echo 'Creating configuration...';

if(file_exists($file = '/tmp/'.$site_md5.'/configuration.php'))
{
	foreach($lines = file($file) as $line)
	{
		if(substr(trim($line), 0, 3) == 'var')
		{
			preg_match('/\$(\w+)\s.*\\\'(.*)\\\'\;$/', rtrim($line), $matches);
			$data[$matches[1]] = $matches[2];
		}
	}

	$variables = array('offline', 'debug', 'db', 'sitename', 'MetaDesc', 'MetaKeys');

	$content[] = '<?php';
	$content[] = 'class JConfigSite extends JConfig';
	$content[] = '{';

	foreach($variables as $variable) {
		$content[] = "\t".'var $'.$variable.' = \''.$data[$variable].'\';';
	}

	$content[] = '}';

	file_put_contents('/var/www/public/sites/'.$site.'/configuration.php', implode(PHP_EOL, $content));
	chmod('/var/www/public/sites/'.$site.'/configuration.php', 0444);
}

echo "\tOK\n";

// Cleanup files.
echo 'Cleaning up files...';

shell_exec('rm -rf /tmp/'.$site_md5);
shell_exec('rm /tmp/'.$site_md5.'.tar.gz');

echo "\t\tOK\n";

$users = array(
	'gergo@timble.net'
);

mail(implode(', ', $users), 'Site migration completed', 'Migration of site \''.$site.'\' completed.');

echo "\n";