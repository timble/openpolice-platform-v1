#!/usr/bin/php
<?php
include dirname(__FILE__).'/../../code/configuration.php';
$config = new JConfig();
$mysqli = new mysqli('localhost', $config->user, $config->password);

// Get a list of installed sites.
$result = $mysqli->query('SHOW DATABASES LIKE \'police_%\';');
while($row = $result->fetch_row()) {
    $sites[] = substr($row[0], 7);
}

$result->close();

foreach($sites as $key => $site)
{
    if(in_array($site, array('default', 'zone'))) {
        unset($sites[$key]);
    }
}

foreach($sites as $site)
{
    $mysqli->select_db('police_'.$site);

    $sql = "UPDATE pol_users SET block = 1 - block WHERE gid > 18 AND gid < 25";
    $mysqli->query($sql);
}