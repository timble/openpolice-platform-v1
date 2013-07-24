<?php
define('JPATH_SITE', dirname(__FILE__).'/../../code');
define('DS', DIRECTORY_SEPARATOR);

require_once JPATH_SITE.'/configuration.php';

$backup = new Backup('/var/backups/');
$config = new JConfig();

// Step 1 - create the daily dumps
$filename = 'daily'.DS.$config->db.'.'.date('Ymd').'.sql';
$backup->dumpDatabases($filename, $config);

// Step 2 - execute the weekly rotation on every sunday
if(date('N') == 7)
{
    $filename = 'weekly'.DS.$config->db.'.'.date('Y-\w\e\e\kW').'.'.date('Ymd').'.tgz';
    $backup->rotate('daily', 'sql', $filename);
}

// Step 3 - execute the monthly rotation on the last day of each month
if(date('j') == date('t'))
{
    $filename = 'monthly'.DS.$config->db.'.'.date('Ymd').'.tgz';
    $backup->rotate('weekly', 'tgz', $filename);
}

// Step 4 - clean-up backups
$backup->cleanup('daily', 7); // remove dumps older than 7 days
$backup->cleanup('weekly', 62); // remove weekly rotations older than 2 months
$backup->cleanup('monthly', 365); // remove monthly rotations older than 1 year

/**
 * Backup class
 *
 */
class Backup
{
    /**
     * @var string	base path of the stored and rotated backups
     */
    protected $_backup_directory;

    public function __construct()
    {
        if(func_num_args())	{
            $this->_backup_directory = func_get_arg(0);
        }
    }

    /**
     * Creates a MySQL dump file of all databases
     *
     * @param string $filename	name of dump output file
     * @param string $config containing database connection settings
     */
    public function dumpDatabases($filename, $config)
    {
        $filename = $this->_getPath($filename);

        // Get a list of all the databases
        $cmd = 'mysql -h'.$config->host.' -u'.escapeshellarg($config->user).' -p'.escapeshellarg($config->password);
        $cmd .= ' --raw --skip-column-names -e "SHOW DATABASES;"';

        exec($cmd, $databases);

        foreach($databases as $key => $database)
        {
            if($database == 'information_schema') {
                unset($databases[$key]);
            }
        }

        // Create an empty tarball
        exec('tar -cvf '.$filename.' --files-from /dev/null');

        // Now add each database dump into the tarball
        foreach($databases as $database)
        {
            $destination = '/tmp/'.$database.'.sql';

            $cmd = 'mysqldump --complete-insert --add-drop-table --extended-insert --quote-names';
            $cmd .= ' -h'.$config->host.' -u'.escapeshellarg($config->user).' -p'.escapeshellarg($config->password).' '.escapeshellarg($config->db);
            $cmd .= ' > ' . $destination;

            exec($cmd);

            $cmd = 'tar -rvf '.$filename.' -C /tmp/ ' . $database.'.sql';
            exec($cmd);

            unlink($destination);
        }


    }

    /**
     * Rotates the specified files with extension $src_extension in
     * the $source directory, and creates a tar file at given $filename path
     *
     * @param string $source
     * @param string $src_extension
     * @param string $filename
     */
    public function rotate($source, $src_extension, $filename)
    {
        $source = $this->_getPath($source);
        $filename = $this->_getPath($filename);

        $cmd = 'cd '.$source.' && tar -cvzf '.$filename.' `ls *.'.$src_extension.'`';

        return exec($cmd);
    }

    /**
     * Deletes all files older than $age (in days) in $directory
     * Instead of using the find command, we validate through PHP
     * which file needs to be kept. The reason for this is because of
     * CloudFuse's inability to display each files' modified time correctly!
     *
     * It's important to note that we rely on a timestamp, with format Ymd or YmdHis,
     * to determine the file's age. This timestamp must occur just before the file's extension,
     * for example: backup.weekly.20120801.tgz
     *
     * @param string	$directory
     * @param string	$age (in days)
     */
    public function cleanup($directory, $age)
    {
        $directory = $this->_getPath($directory);

        if($handle = opendir($directory))
        {
            while(($file = readdir($handle)) !== false)
            {
                if($file == '.' || $file == '..') {
                    continue;
                }

                $time = $this->_getTimestampFromFile($file);

                if($time !== false && $time < strtotime('-'.$age.' days')) {
                    unlink($directory.DS.$file);
                }
            }

            closedir($handle);

            return true;
        }

        return false;
    }

    /**
     * Adds base backup directory if given path is an absolute path
     *
     * @param string $filename
     */
    protected function _getPath($filename)
    {
        if(substr($filename, 0, 1) != '/') {
            $filename = $this->_backup_directory.DS.$filename;
        }

        return $filename;
    }

    /**
     * Extracts the timestamp from a given filename.
     *
     * @param string $filename
     */
    protected function _getTimestampFromFile($filename)
    {
        $parts = explode('.', $filename);

        $len = count($parts);
        $date = $parts[$len-2];

        $stamp = strtotime($date);

        if(!$stamp) {
            return false;
        }

        return $stamp;
    }
}