#!/usr/bin/php
<?php
// Connect to MySQL.
include dirname(__FILE__).'/../credentials.php';

$link = mysql_connect('localhost', 'fedpol', $credentials['mysql']['fedpol']);

// Get a list of installed sites.
$result = mysql_query('SHOW DATABASES LIKE \'police_%\';');

while($row = mysql_fetch_row($result))
{
    $site = substr($row[0], 7);
    
    if($site != 'default') {
        $sites[$site] = $site;
    }
}

mysql_free_result($result);

// Execute the query.
foreach($sites as $site)
{
    mysql_select_db('police_'.$site);
    
    $result = mysql_query('SELECT `gid`, `email` FROM `pol_users` WHERE `gid` IN (23, 24);');
    
    while($row = mysql_fetch_assoc($result)) {
        $users[$row['email']] = array($row['email'], $site, $row['gid']);
    }
    
    mysql_free_result($result);
}

$output = '"email","site","gid"';

foreach($users as $user) {
    $output .= PHP_EOL.'"'.implode('","', $user).'"';
}

file_put_contents('users.csv', $output);