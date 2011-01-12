#!/usr/bin/php
<?php
$options = getopt(null, array('execute:', 'exclude-default'));

if(!array_key_exists('execute', $options) || strlen(trim($options['execute'])) == 0) {
	exit("Usage: mysql.php --execute \"query\" --exclude-default\n");
}

// Connect to MySQL.
include dirname(__FILE__).'/../credentials.php';

$link = mysql_connect('localhost', 'root', $credentials['mysql']['root']);

// Get a list of installed sites.
$result	= mysql_query('SHOW DATABASES LIKE \'police_%\';');

while($row = mysql_fetch_row($result)) {
	$sites[] = substr($row[0], 7);
}

mysql_free_result($result);

if(array_key_exists('exclude-default', $options)) {
	unset($sites['default']);
}

// Execute the query.
foreach($sites as $site)
{
	mysql_query('USE `police_'.$site.'`;');
	mysql_query($options['execute']);
}