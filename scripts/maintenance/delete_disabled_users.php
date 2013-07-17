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

// Execute the query.
foreach($sites as $site)
{
    $mysqli->select_db('police_'.$site);

    // Get the disabled users
    $sql = "SELECT id, name, email FROM pol_users WHERE block = 1";
    $result = $mysqli->query($sql);

    if($result)
    {
        while($row = $result->fetch_object())
        {
            echo "Deleting " . $row->name . " (" . $row->email . "/" . $row->username.") from `police_".$site."`" . PHP_EOL;

            $user = new User($row->id, $mysqli);
            $user->delete();
        }
    }
}

class User
{
    protected $_id = null;
    protected $_mysqli = null;

    protected $_acl_id = null;

    public function __construct($id = 0, $mysqli = null)
    {
        $this->_id      = (int) $id;
        $this->_mysqli  = $mysqli;

        $this->_initialize();
    }

    protected function _initialize()
    {
        if(is_null($this->_mysqli)) {
            throw new Exception('No MySQLi connection given');
        }

        if(!($this->_mysqli instanceof MySQLi)) {
            throw new Exception('Object is not a valid MySQLi object');
        }

        if(is_null($this->_id) || $this->_id <= 0) {
            throw new Exception('Invalid user id');
        }

        $this->_loadACLId();
    }

    protected function _loadACLId()
    {
        $sql    = "SELECT * FROM pol_core_acl_aro WHERE value = " . $this->_id;
        $result = $this->_mysqli->query($sql);

        if($result)
        {
            $row            = $result->fetch_object();
            $this->_acl_id  = (int) $row->id;
        }
    }

    public function delete()
    {
        if(is_int($this->_acl_id))
        {
            $sql = "DELETE FROM pol_core_acl_groups_aro_map WHERE aro_id = " . $this->_acl_id;
            $this->_mysqli->query($sql);

            $sql = "DELETE FROM pol_core_acl_aro WHERE id = " . $this->_acl_id;
            $this->_mysqli->query($sql);
        }

        $sql = "DELETE FROM pol_users WHERE id = " . $this->_id;
        $this->_mysqli->query($sql);
    }
}