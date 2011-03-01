#!/usr/bin/php
<?php
// The SQL query to execute.
$sql = '';

// Optional settings.
$options = array('exclude-default' => true);

// Connect to MySQL.
include dirname(__FILE__).'/../credentials.php';

$link = mysql_connect('localhost', 'police', $credentials['mysql']['police']);

// Get a list of installed sites.
$result = mysql_query('SHOW DATABASES LIKE \'police_%\';');

while($row = mysql_fetch_row($result)) {
    $sites[] = substr($row[0], 7);
}

mysql_free_result($result);

if($options['exclude-default']) {
    unset($sites['default']);
}

// Execute the query.
foreach($sites as $site)
{
    mysql_query('USE `police_'.$site.'`;');
    mysql_query($sql);
}