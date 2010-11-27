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
		'database'	=> '',
		'username'	=> '',
		'password'	=> 'mWLnbw6d',
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

$site['old']['name']	= $arguments['site'];
$site['old']['md5']		= md5($site['old']['name']);
$site['new']['name']	= strpos($site['old']['name'], '_') !== false ? substr($site['old']['name'], 0, strpos($site['old']['name'], '_')) : $site['old']['name'];

$config['mysql']['username'] = 'tor'.str_replace('_', '', $site['old']['name']);
$config['mysql']['database'] = 'police_'.strtolower($site['old']['name']);

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

$stream		= ssh2_exec($connection, 'test -d '.$config['document_root'].'/'.$site['old']['name'].' && echo "OK" || echo "FAILED"');
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

$stream		= ssh2_exec($connection, 'mysqldump --user="'.$config['mysql']['username'].'" --password="'.$config['mysql']['password'].'" --add-drop-database --databases '.$config['mysql']['database'].' | gzip > '.$config['document_root'].'/'.$site['old']['name'].'/database.sql.gz');
stream_set_blocking($stream, true);
$response	= trim(fread($stream, 4096));
fclose($stream);

if($response != '')
{
	echo "\t\tFAILED\n\n";
	exit;
}

$stream		= ssh2_exec($connection, 'tar -C '.$config['document_root'].'/'.$site['old']['name'].' -czf /tmp/'.$site['old']['md5'].'.tar.gz images dmdocuments database.sql.gz configuration.php templates/rhuk_milkyway_police/images/mw_joomla_logo.png');
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

if(ssh2_scp_recv($connection, '/tmp/'.$site['old']['md5'].'.tar.gz', '/tmp/'.$site['old']['md5'].'.tar.gz')) {
	echo "\t\tOK\n";
}
else
{
	echo "\t\tFAILED\n\n";
	exit;
}

// Uncompress the site.
echo 'Uncompressing site...';

mkdir('/tmp/'.$site['old']['md5'], 0775);
shell_exec('cd /tmp/'.$site['old']['md5'].' && tar -xzf ../'.$site['old']['md5'].'.tar.gz');

echo "\t\tOK\n";

// Move files.
echo 'Moving files...';

if(!is_dir('/var/www/public/sites/'.$site['new']['name'])) {
	mkdir('/var/www/public/sites/'.$site['new']['name']);
}

if(is_dir('/tmp/'.$site['old']['md5'].'/images'))
{
	if(!is_dir('/var/www/public/sites/'.$site['new']['name'].'/images')) {
		mkdir('/var/www/public/sites/'.$site['new']['name'].'/images');
	}

	shell_exec('cp -R /tmp/'.$site['old']['md5'].'/images/* /var/www/public/sites/'.$site['new']['name'].'/images/');
}

if(is_dir('/tmp/'.$site['old']['md5'].'/dmdocuments'))
{
	if(!is_dir('/var/www/public/sites/'.$site['new']['name'].'/documents')) {
		mkdir('/var/www/public/sites/'.$site['new']['name'].'/documents');
	}

	shell_exec('cp -R /tmp/'.$site['old']['md5'].'/dmdocuments/* /var/www/public/sites/'.$site['new']['name'].'/documents/');
}

if(file_exists('/tmp/'.$site['old']['md5'].'/templates/rhuk_milkyway_police/images/mw_joomla_logo.png')) {
	copy('/tmp/'.$site['old']['md5'].'/templates/rhuk_milkyway_police/images/mw_joomla_logo.png', '/var/www/public/sites/'.$site['new']['name'].'/logo.png');
}

echo "\t\t\tOK\n";

// Import database.
echo 'Importing database...';

shell_exec('cd /tmp/'.$site['old']['md5'].' && gunzip database.sql.gz');
shell_exec('cd /tmp/'.$site['old']['md5'].' && mv database.sql database.sql.old');
shell_exec('cd /tmp/'.$site['old']['md5'].' && sed -e \'s/http:\/\/217.21.184.146\/'.$site['old']['name'].'\///g\' -e \'s/`jos_/`pol_/g\' -e \'s/`'.$config['mysql']['database'].'`/`police_'.$site['new']['name'].'`/g\' -e \'s/href=\\\\"\\.\\/index\\.php/href=\\\\"index\\.php/g\' database.sql.old > database.sql');
shell_exec('cd /tmp/'.$site['old']['md5'].' && mysql --user="root" --password="" < database.sql');
shell_exec('mysql --user="root" --password="" police_'.$site['new']['name'].' < migrator.sql');

$link	= mysql_connect('localhost', 'root', '');
mysql_select_db('police_'.$site['new']['name']);
$result	= mysql_query('SELECT * FROM `pol_menu` WHERE `alias` = \'\'');

while($row = mysql_fetch_assoc($result))
{
	$alias = str_replace('-', ' ', $row['name']);
	$alias = htmlentities(utf8_decode($alias));
	$alias = preg_replace(
			array('/&szlig;/','/&(..)lig;/', '/&([aouAOU])uml;/','/&(.)[^;]*;/'),
			array('ss',"$1","$1".'e',"$1"),
			$alias);
	$alias = trim(strtolower($alias));
	$alias = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-', ''), $alias);
	$alias = substr($alias, 0, 100);

	mysql_query('UPDATE `pol_menu` SET `alias` = \''.$alias.'\' WHERE `id` = \''.$row['id'].'\'');
}

mysql_free_result($result);

$result	= mysql_query('SELECT * FROM `pol_components` WHERE `link` = \'option=com_jce\'');

if(!mysql_num_rows($result))
{
	mysql_free_result($result);

	mysql_query('INSERT INTO `pol_components` VALUES(0, \'JCE\', \'option=com_jce\', 0, 0, \'option=com_jce\', \'JCE\', \'com_jce\', 0, \'components/com_jce/img/logo.png\', 0, \'\\npackage=1\', 1);');

	$result = mysql_query('SELECT * FROM `pol_components` WHERE `link` = \'option=com_jce\'');
	$row = mysql_fetch_assoc($result);

	mysql_query('INSERT INTO `pol_components` VALUES(0, \'JCE MENU CPANEL\', \'\', 0, '.$row['id'].', \'option=com_jce\', \'JCE MENU CPANEL\', \'com_jce\', 0, \'templates/khepri/images/menu/icon-16-cpanel.png\', 0, \'\', 1);');
	mysql_query('INSERT INTO `pol_components` VALUES(0, \'JCE MENU CONFIG\', \'\', 0, '.$row['id'].', \'option=com_jce&type=config\', \'JCE MENU CONFIG\', \'com_jce\', 1, \'templates/khepri/images/menu/icon-16-config.png\', 0, \'\', 1);');
	mysql_query('INSERT INTO `pol_components` VALUES(0, \'JCE MENU GROUPS\', \'\', 0, '.$row['id'].', \'option=com_jce&type=group\', \'JCE MENU GROUPS\', \'com_jce\', 2, \'templates/khepri/images/menu/icon-16-user.png\', 0, \'\', 1);');
	mysql_query('INSERT INTO `pol_components` VALUES(0, \'JCE MENU PLUGINS\', \'\', 0, '.$row['id'].', \'option=com_jce&type=plugin\', \'JCE MENU PLUGINS\', \'com_jce\', 3, \'templates/khepri/images/menu/icon-16-plugin.png\', 0, \'\', 1);');
	mysql_query('INSERT INTO `pol_components` VALUES(0, \'JCE MENU INSTALL\', \'\', 0, '.$row['id'].', \'option=com_jce&type=install\', \'JCE MENU INSTALL\', \'com_jce\', 4, \'templates/khepri/images/menu/icon-16-install.png\', 0, \'\', 1);');
}

mysql_free_result($result);

mysql_query('UPDATE `pol_content` SET `introtext` = REPLACE(`introtext`, \'images/\', \'/sites/'.$site['new']['name'].'/images/\');');
mysql_query('UPDATE `pol_content` SET `fulltext` = REPLACE(`fulltext`, \'images/\', \'/sites/'.$site['new']['name'].'/images/\');');
mysql_query('UPDATE `pol_categories` SET `description` = REPLACE(`description`, \'images/\', \'/sites/'.$site['new']['name'].'/images/\');');
mysql_query('UPDATE `pol_modules` SET `content` = REPLACE(`content`, \'images/\', \'/sites/'.$site['new']['name'].'/images/\');');
mysql_query('UPDATE `pol_sections` SET `description` = REPLACE(`description`, \'images/\', \'/sites/'.$site['new']['name'].'/images/\');');

$tidy_options = array('show-body-only' => true, 'clean' => true, 'word-2000' => true, 'drop-font-tags' => true, 'drop-proprietary-attributes' => true);

$result	= mysql_query('SELECT `id`, `introtext`, `fulltext` FROM `pol_content`');

while($row = mysql_fetch_assoc($result)) {
	mysql_query('UPDATE `pol_content` SET `introtext` = \''.tidy_repair_string($row['introtext'],$tidy_options).'\', `fulltext` = \''.tidy_repair_string($row['fulltext'], $tidy_options).'\' WHERE `id` = '.$row['id']);
}

mysql_free_result($result);

$result	= mysql_query('SELECT `id`, `description` FROM `pol_categories`');

while($row = mysql_fetch_assoc($result)) {
	mysql_query('UPDATE `pol_categories` SET `description` = \''.tidy_repair_string($row['description'], $tidy_options).'\' WHERE `id` = '.$row['id']);
}

mysql_free_result($result);

$result	= mysql_query('SELECT `id`, `content` FROM `pol_modules`');

while($row = mysql_fetch_assoc($result)) {
	mysql_query('UPDATE `pol_modules` SET `content` = \''.tidy_repair_string($row['content'], $tidy_options).'\' WHERE `id` = '.$row['id']);
}

mysql_free_result($result);

$result	= mysql_query('SELECT `id`, `description` FROM `pol_sections`');

while($row = mysql_fetch_assoc($result)) {
	mysql_query('UPDATE `pol_sections` SET `description` = \''.tidy_repair_string($row['description'], $tidy_options).'\' WHERE `id` = '.$row['id']);
}

mysql_free_result($result);

echo "\t\tOK\n";

// Create configuration.
echo 'Creating configuration...';

if(file_exists($file = '/tmp/'.$site['old']['md5'].'/configuration.php'))
{
	foreach($lines = file($file) as $line)
	{
		if(substr(trim($line), 0, 3) == 'var')
		{
			list($key, $value) = explode('=', trim($line), 2);
			$key	= trim(substr($key, 5));
			$value	= substr(trim($value), 1, strlen(trim($value)) - 3);

			$data[$key] = $key == 'db' ? 'police_'.$site['new']['name'] : $value;
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

	file_put_contents('/var/www/public/sites/'.$site['new']['name'].'/configuration.php', implode(PHP_EOL, $content));
}

echo "\tOK\n";

// Change file and directory permissions.
echo 'Changing permissions...';

shell_exec('find /var/www/public/sites/'.$site['new']['name'].'/ -type d -exec chmod 775 {} \;');
shell_exec('find /var/www/public/sites/'.$site['new']['name'].'/ -type f -exec chmod 664 {} \;');
shell_exec('chmod 444 /var/www/public/sites/'.$site['new']['name'].'/configuration.php');

echo "\t\tOK\n";

// Cleanup files.
echo 'Cleaning up files...';

shell_exec('rm -rf /tmp/'.$site['old']['md5']);
shell_exec('rm /tmp/'.$site['old']['md5'].'.tar.gz');

echo "\t\tOK\n";

$users = array(
	'gergo@timble.net'
);

mail(implode(', ', $users), 'Site migration completed', 'Migration of site \''.$site['old']['name'].'\' completed.');

echo "\n";