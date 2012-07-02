#!/usr/bin/php
<?php
// The SQL query to execute.
$sql = 'SELECT `gid`, `email` FROM `pol_users` WHERE `gid` IN (23, 24);';

// Optional settings.
$options = array('exclude-default' => true);

// Connect to MySQL.
include dirname(__FILE__).'/../../code/configuration.php';
$config = new JConfig();
$mysqli = new mysqli('localhost', $config->user, $config->password);

// Get a list of installed sites.
$result = $mysqli->query('SHOW DATABASES LIKE \'police_%\';');
while($row = $result->fetch_row()) {
    $sites[] = substr($row[0], 7);
}

$result->close();

if($options['exclude-default']) {
    unset($sites['default']);
}

// Execute the query.
foreach($sites as $site)
{
    $mysqli->select_db('police_'.$site);
    $result = $mysqli->query($sql);
    
    while($row = $result->fetch_assoc()) {
        $users[$row['email']] = array($row['email'], $site, $row['gid']);
    }
    
    $result->close();
}

$output = '"email","site","gid"';
foreach($users as $user) {
    $output .= PHP_EOL.'"'.implode('","', $user).'"';
}

file_put_contents('users.csv', $output);