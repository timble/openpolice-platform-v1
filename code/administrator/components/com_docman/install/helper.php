<?php
/**
 * @version		$Id: helper.php 1378 2010-06-11 16:07:19Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

if( !defined('DS') ) define('DS', DIRECTORY_SEPARATOR);


require_once( dirname(__FILE__).DS.'..'.DS.'docman.class.php');
global $_DOCMAN, $_DMUSER;
$_DOCMAN = new dmMainFrame();
$_DMUSER = $_DOCMAN->getUser();
require_once($_DOCMAN->getPath('classes', 'compat'));
define( '_DM_INSTALLER_ICONPATH', 'components/com_docman/images/');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class DMStatus
{
	var $_success = true;
	var $_msgs = array();

	function & getInstance()
	{
		static $instance;
		if(!isset($instance)) {
			$instance = new DMStatus;
		}
		return $instance;
	}
	function addMsg($msg)
	{
		$this->_msgs[] = $msg;
	}
	function getMsgs()
	{
		return $this->_msgs;
	}
	function set($success)
	{
		$this->_success = $success;
	}
	function get()
	{
		return $this->_success;
	}
}

/**
 * Helper functions for the installer
 * @static
 */
class DMInstallHelper
{
    function logo()
    {

    	?><br />
        <table>
            <tr>
                <th>
              	  <img border="0" src="http://ping.joomlatools.eu/?<?php echo DMInstallHelper::getInfo()?>" />
				  <a href='index.php?option=com_docman'><img border="0" alt="DOCman" src="<?php echo JURI::root(0)?>/administrator/components/com_docman/images/dm_logo.png" /></a>
                </th>
            </tr>
        </table><?php
    }

    function getFiles()
    {
    	$ext = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_docman'.DS.'ext';
    	return array(
			$ext.DS.'mod_docman_approval'.DS.'mod_docman_approval.php'
				=>JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_approval'.DS.'mod_docman_approval.php',
			$ext.DS.'mod_docman_approval'.DS.'mod_docman_approval.xml'
				=>JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_approval'.DS.'mod_docman_approval.xml',
			$ext.DS.'mod_docman_latest'.DS.'mod_docman_latest.php'
				=>JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_latest'.DS.'mod_docman_latest.php',
			$ext.DS.'mod_docman_latest'.DS.'mod_docman_latest.xml'
				=>JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_latest'.DS.'mod_docman_latest.xml',
			$ext.DS.'mod_docman_logs'.DS.'mod_docman_logs.php'
				=>JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_logs'.DS.'mod_docman_logs.php',
			$ext.DS.'mod_docman_logs'.DS.'mod_docman_logs.xml'
				=>JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_logs'.DS.'mod_docman_logs.xml',
			$ext.DS.'mod_docman_news'.DS.'mod_docman_news.php'
				=>JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_news'.DS.'mod_docman_news.php',
			$ext.DS.'mod_docman_news'.DS.'mod_docman_news.xml'
				=>JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_news'.DS.'mod_docman_news.xml',
			$ext.DS.'mod_docman_top'.DS.'mod_docman_top.php'
				=>JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_top'.DS.'mod_docman_top.php',
			$ext.DS.'mod_docman_top'.DS.'mod_docman_top.xml'
				=>JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_top'.DS.'mod_docman_top.xml',

			$ext.DS.'plugins'.DS.'docman'.DS.'standardbuttons.php'
				=> JPATH_ROOT.DS.'plugins'.DS.'docman'.DS.'standardbuttons.php',
            $ext.DS.'plugins'.DS.'docman'.DS.'standardbuttons.xml'
            	=> JPATH_ROOT.DS.'plugins'.DS.'docman'.DS.'standardbuttons.xml',

            //$ext.DS.'plugins'.DS.'editors-xtd'.DS.'doclink'.DS
            //	=> JPATH_ROOT.DS.'plugins'.DS.'editors-xtd'.DS.'doclink',
            $ext.DS.'plugins'.DS.'editors-xtd'.DS.'doclink.xml'
            	=> JPATH_ROOT.DS.'plugins'.DS.'editors-xtd'.DS.'doclink.xml',
			$ext.DS.'plugins'.DS.'editors-xtd'.DS.'doclink.php'
            	=> JPATH_ROOT.DS.'plugins'.DS.'editors-xtd'.DS.'doclink.php',

	    $ext.DS.'plugins'.DS.'search'.DS.'docman.searchbot.xml'
            	=> JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'docman.searchbot.xml',
                        $ext.DS.'plugins'.DS.'search'.DS.'docman.searchbot.php'
            	=> JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'docman.searchbot.php',

            $ext.DS.'mod_docman_catdown'.DS.'mod_docman_catdown.php'
				=>JPATH_SITE.DS.'modules'.DS.'mod_docman_catdown'.DS.'mod_docman_catdown.php',
			$ext.DS.'mod_docman_latestdown'.DS.'mod_docman_latestdown.php'
				=>JPATH_SITE.DS.'modules'.DS.'mod_docman_latestdown'.DS.'mod_docman_latestdown.php',
			$ext.DS.'mod_docman_lister'.DS.'mod_docman_lister.php'
				=>JPATH_SITE.DS.'modules'.DS.'mod_docman_lister'.DS.'mod_docman_lister.php',
			$ext.DS.'mod_docman_mostdown'.DS.'mod_docman_mostdown.php'
				=>JPATH_SITE.DS.'modules'.DS.'mod_docman_mostdown'.DS.'mod_docman_mostdown.php',
			$ext.DS.'mod_docman_catdown'.DS.'mod_docman_catdown.xml'
				=>JPATH_SITE.DS.'modules'.DS.'mod_docman_catdown'.DS.'mod_docman_catdown.xml',
			$ext.DS.'mod_docman_latestdown'.DS.'mod_docman_latestdown.xml'
				=>JPATH_SITE.DS.'modules'.DS.'mod_docman_latestdown'.DS.'mod_docman_latestdown.xml',
			$ext.DS.'mod_docman_lister'.DS.'mod_docman_lister.xml'
				=>JPATH_SITE.DS.'modules'.DS.'mod_docman_lister'.DS.'mod_docman_lister.xml',
			$ext.DS.'mod_docman_mostdown'.DS.'mod_docman_mostdown.xml'
				=>JPATH_SITE.DS.'modules'.DS.'mod_docman_mostdown'.DS.'mod_docman_mostdown.xml',

            	);
    }

    function getFolders()
    {
    	return array(
			JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_approval',
			JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_latest',
			JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_logs',
			JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_news',
			JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_docman_top',
			JPATH_ROOT.DS.'plugins'.DS.'editors-xtd'.DS.'doclink',
            JPATH_SITE.DS.'modules'.DS.'mod_docman_catdown',
			JPATH_SITE.DS.'modules'.DS.'mod_docman_latestdown',
			JPATH_SITE.DS.'modules'.DS.'mod_docman_lister',
			JPATH_SITE.DS.'modules'.DS.'mod_docman_mostdown',
			);
    }


    function copyFiles()
    {
    	clearstatcache();

    	$status = & DMStatus::getInstance();
        $root   = JPATH_ROOT;
        $site   = $root.DS.'components'.DS.'com_docman';
        $admin  = $root.DS.'administrator'.DS.'components'.DS.'com_docman';

        // dmdocuments
        $dmdoc  = $root.DS._DM_DEFAULT_DATA_FOLDER;
        @mkdir ($dmdoc, 0755, true);
        @copy  ($admin.DS.'htaccess.txt', $dmdoc.DS.'.htaccess' );
        @copy  ($site.DS.'index.html', $dmdoc.DS.'index.html');
        if(!file_exists($dmdoc.DS.'.htaccess')) {
        	$status->addMsg("Couldn't secure <strong>$dmdoc</strong>. Please create the folder yourself. Next copy $admin".DS."htaccess.txt to $dmdoc".DS.".htaccess");
        }

        // create the folders
		$folders = DMInstallHelper::getFolders();
		foreach($folders as $folder) {
			JFolder::create($folder);
		}
		// plugins/docman is separate, because we don't want to delete on uninstall
		JFolder::create(JPATH_ROOT.DS.'plugins'.DS.'docman');

		//create the files
		$files = DMInstallHelper::getFiles();

		foreach( $files as $src=>$dest )
		{
			JFile::copy($src, $dest);
			if(!file_exists($dest)){
				$status->addMsg("Couldn't copy the following file: <br /><strong>Source: </strong>$src<br /><strong>Destination</strong>$dest<br />");
			}
		}

		//create the folder of plugins editors-xtd doclink
		JFolder::copy(
			JPATH_ADMINISTRATOR.DS.'components'.DS.'com_docman'.DS.'ext'.DS.'plugins'.DS.'editors-xtd'.DS.'doclink'.DS.'images'.DS,
			JPATH_ROOT.DS.'plugins'.DS.'editors-xtd'.DS.'doclink'.DS.'images'
		);
		JFolder::copy(
			JPATH_ADMINISTRATOR.DS.'components'.DS.'com_docman'.DS.'ext'.DS.'plugins'.DS.'editors-xtd'.DS.'doclink'.DS.'lang'.DS,
			JPATH_ROOT.DS.'plugins'.DS.'editors-xtd'.DS.'doclink'.DS.'lang'
		);
		JFolder::copy(
			JPATH_ADMINISTRATOR.DS.'components'.DS.'com_docman'.DS.'ext'.DS.'plugins'.DS.'editors-xtd'.DS.'doclink'.DS.'popups'.DS,
			JPATH_ROOT.DS.'plugins'.DS.'editors-xtd'.DS.'doclink'.DS.'popups'
		);

    }


    function insertInDb()
    {
    	$database = JFactory::getDBO();

    	// Plugins

    	$query = "SELECT id FROM #__plugins WHERE element = 'standardbuttons' AND folder='docman'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
    		$query = "INSERT INTO `#__plugins` (`name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`)"
                    ."\n VALUES ('DOCman Standard Buttons', 'standardbuttons', 'docman', '0', '1', '1', '1', '0', '0', '0000-00-00 00:00:00', "
                    ." 'download=1\nview=1\ndetails=1\nedit=1\nmove=1\ndelete=1\nupdate=1\nreset=1\ncheckout=1\napprove=1\npublish=1')";
			$database->setQuery($query);
			$database->query();
    	}

    	$query = "SELECT id FROM #__plugins WHERE element = 'docman.searchbot' AND folder='search'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
    		$query = "INSERT INTO `#__plugins`  (`name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`)"
    				."\n VALUES('Search DOCman', 'docman.searchbot', 'search', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'prefix=Download: \nhref=download\nsearch_name=1\nsearch_description=1\n')";
			$database->setQuery($query);
			$database->query();
    	}

    	$query = "SELECT id FROM #__plugins WHERE element = 'docman' AND folder='editors-xtd'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
    		$query = "INSERT INTO `#__plugins`  (`name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`)"
    				."\n VALUES('DOCLink', 'doclink', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '')";
			$database->setQuery($query);
			$database->query();
    	}

    	// Admin modules

    	$query = "SELECT id FROM #__modules WHERE  module = 'mod_docman_latest'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
    		DMInstallHelper::_insertModule(array('title'=>'Latest docs', 'position'=>'dmcpanel', 'module'=>'mod_docman_latest', 'showtitle'=>1, 'params'=>'', 'ordering'=>0, 'published'=>1, 'client_id'=>1));
    	}

    	$query = "SELECT id FROM #__modules WHERE  module = 'mod_docman_top'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
			DMInstallHelper::_insertModule(array('title'=>'Top docs', 'position'=>'dmcpanel', 'module'=>'mod_docman_top', 'showtitle'=>1, 'params'=>'', 'ordering'=>1, 'published'=>1, 'client_id'=>1));
    	}

    	$query = "SELECT id FROM #__modules WHERE  module = 'mod_docman_logs'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
			DMInstallHelper::_insertModule(array('title'=>'Latest logs', 'position'=>'dmcpanel', 'module'=>'mod_docman_logs', 'showtitle'=>1, 'params'=>'', 'ordering'=>2, 'published'=>1, 'client_id'=>1));
    	}

    	$query = "SELECT id FROM #__modules WHERE  module = 'mod_docman_approval'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
			DMInstallHelper::_insertModule(array('title'=>'Top docs', 'position'=>'dmcpanel', 'module'=>'mod_docman_top', 'showtitle'=>1, 'params'=>'', 'ordering'=>3, 'published'=>1, 'client_id'=>1));
    	}

    	$query = "SELECT id FROM #__modules WHERE  module = 'mod_docman_news'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
			DMInstallHelper::_insertModule(array('title'=>'Top docs', 'position'=>'dmcpanel', 'module'=>'mod_docman_top', 'showtitle'=>1, 'params'=>'', 'ordering'=>4, 'published'=>1, 'client_id'=>1));
    	}


    	// Frontend modules

    	$query = "SELECT id FROM #__modules WHERE module = 'mod_docman_catdown'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
    		DMInstallHelper::_insertModule(array('title'=>'DOCman Category', 'position'=>'left', 'module'=>'mod_docman_catdown', 'showtitle'=>1, 'params'=>''));
    	}

    	$query = "SELECT id FROM #__modules WHERE module = 'mod_docman_latestdown'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
			DMInstallHelper::_insertModule(array('title'=>'DOCman Latest Downloads', 'position'=>'left', 'module'=>'mod_docman_latestdown', 'showtitle'=>1, 'params'=>''));
    	}

		$query = "SELECT id FROM #__modules WHERE module = 'mod_docman_lister'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
    		DMInstallHelper::_insertModule(array('title'=>'DOCman Lister', 'position'=>'left', 'module'=>'mod_docman_lister', 'showtitle'=>1, 'params'=>''));
    	}

    	$query = "SELECT id FROM #__modules WHERE module = 'mod_docman_mostdown'";
    	$database->setQuery($query);
    	if(!$database->loadResult())
    	{
			DMInstallHelper::_insertModule(array('title'=>'DOCman Most Downloaded', 'position'=>'left', 'module'=>'mod_docman_mostdown', 'showtitle'=>1, 'params'=>''));
    	}



    }


    function _insertModule($data)
    {
    	$row = JTable::getInstance('module');
		$row->bind($data);

		return $row->store() ? $row->id : false;
    }


    function deleteFromDb()
     {
        $database = JFactory::getDBO();

        $queries = array(

        "DELETE FROM #__plugins WHERE element = 'standardbuttons' AND folder='docman'",
        "DELETE FROM #__plugins WHERE element = 'docman.searchbot' AND folder='search'",
        "DELETE FROM #__plugins WHERE element = 'doclink' AND folder='editors-xtd'",
 	"DELETE FROM #__modules WHERE  module = 'mod_docman_latest'",
    	"DELETE FROM #__modules WHERE  module = 'mod_docman_top'",
    	"DELETE FROM #__modules WHERE  module = 'mod_docman_logs'",
    	"DELETE FROM #__modules WHERE  module = 'mod_docman_approval'",
    	"DELETE FROM #__modules WHERE  module = 'mod_docman_news'",
    	"DELETE FROM #__modules WHERE module = 'mod_docman_catdown'",
    	"DELETE FROM #__modules WHERE module = 'mod_docman_latestdown'",
    	"DELETE FROM #__modules WHERE module = 'mod_docman_lister'",
    	"DELETE FROM #__modules WHERE module = 'mod_docman_mostdown'"

        );

        foreach($queries as $query){
        	$database->setQuery($query);
        	$database->query();
        }


     }

	function removeAdminMenuImages()
	{
        $database = JFactory::getDBO();

        $id = DMInstallHelper::getComponentId();

        $database->setQuery("UPDATE #__components SET admin_menu_img = '"._DM_INSTALLER_ICONPATH."dm_spacer_16.png' WHERE parent = $id");
        $database->query();
    }

    function setAdminMenuImages()
    {
      	$database = JFactory::getDBO();

        $id = DMInstallHelper::getComponentId();

        // Main mennu
        $database->setQuery("UPDATE #__components SET admin_menu_img = '"._DM_INSTALLER_ICONPATH."dm_logo_16.png' WHERE id=$id");
        $database->query();

        // Submenus
        $submenus = array();
        $submenus[] = array( 'image' => _DM_INSTALLER_ICONPATH.'dm_cpanel_16.png', 'name'=>'Home' );
        $submenus[] = array( 'image' => _DM_INSTALLER_ICONPATH.'dm_files_16.png', 'name'=>'Files' );
        $submenus[] = array( 'image' => _DM_INSTALLER_ICONPATH.'dm_documents_16.png', 'name'=>'Documents' );
        $submenus[] = array( 'image' => _DM_INSTALLER_ICONPATH.'dm_categories_16.png', 'name'=>'Categories' );
        $submenus[] = array( 'image' => _DM_INSTALLER_ICONPATH.'dm_groups_16.png', 'name'=>'Groups' );
        $submenus[] = array( 'image' => _DM_INSTALLER_ICONPATH.'dm_licenses_16.png', 'name'=>'Licenses' );
        $submenus[] = array( 'image' => _DM_INSTALLER_ICONPATH.'dm_stats_16.png', 'name'=>'Statistics' );
        $submenus[] = array( 'image' => _DM_INSTALLER_ICONPATH.'dm_logs_16.png', 'name'=>'Download Logs' );
        $submenus[] = array( 'image' => _DM_INSTALLER_ICONPATH.'dm_config_16.png', 'name'=>'Configuration' );
        $submenus[] = array( 'image' => _DM_INSTALLER_ICONPATH.'dm_templates_16.png', 'name'=>'Themes' );

        foreach( $submenus as $submenu ){
          $database->setQuery("UPDATE #__components SET admin_menu_img = '".$submenu['image']."'"
                                . "\n WHERE parent=$id AND name = '".$submenu['name']."';");
            $database->query();
        }
    }

	function cpanel()
    {
        ?><br /><br />
        <div class="cpanel">
            <div class="icon">
                <a href="index.php?option=com_docman" style="text-decoration:none;">
                    <img border="0" align="top" alt="Home" src="<?php echo JURI::root(true);?>/administrator/components/com_docman/images/dm_cpanel_48.png"/>
                    <br />
                    <span>Home</span>
                </a>
            </div><br />
            <div class="icon">
                <a href="index.php?option=com_docman&amp;task=sampledata" style="text-decoration:none;">
                    <img border="0" align="top" alt="Add Sample Data" src="<?php echo JURI::root(true); ?>/administrator/components/com_docman/images/dm_newdocument_48.png"/>
                    <br />
                    <span>Add Sample Data</span>
                </a>
            </div>
        </div>
        <?php

    }

    function removeFiles()
    {


        $files = DMInstallHelper::getFiles();

        foreach( $files as $file ){
            JFile::delete($file);
        }

        $folders = DMInstallHelper::getFolders();
        foreach($folders as $folder)
        {
        	JFolder::delete($folder);
        }

    }


    function getDefaultFiles(){
        return array( '.htaccess', 'index.html' );
    }

    function getComponentId()
    {
        static $id;

        if( !$id )
        {
            $database = JFactory::getDBO();
            $database->setQuery("SELECT id FROM #__components WHERE name= 'DOCman'");
            $id =$database->loadResult();
        }
        return $id;
    }

    /**
     * Count items in tables
     */
    function cntDbRecords()
    {
        $database = JFactory::getDBO();
    	$cnt = array();
        $tables = DMInstallHelper::getTablesList();

        foreach( $tables as $table ){
            $database->setQuery("SELECT COUNT(*) FROM `$table`");
            $cnt[] = (int) $database->loadResult();
        }

        // count categories
        $database->setQuery("SELECT COUNT(*) FROM `#__categories` WHERE `section` = 'com_docman'");
        $cnt[] = (int) $database->loadResult();

        return array_sum($cnt);
    }

    function removeTables()
    {
        $database = JFactory::getDBO();
        $tables = DMInstallHelper::getTablesList();

    	foreach( $tables as $table ){
            $database->setQuery("DROP TABLE `$table`");
            $database->query();
        }
    }

    function getTablesList(){
    	return array( '#__docman', '#__docman_groups', '#__docman_history', '#__docman_licenses', '#__docman_log');
    }

    /**
     * Count the number of files in the data folder
     */
    function cntFiles()
    {
    	global $_DOCMAN;

        $files = DMInstallHelper::getDefaultFiles();
        $dir = DOCMAN_Compat::mosReadDirectory( $_DOCMAN->getCfg( 'dmpath' ) );
        return count( array_diff( $dir, $files ));
    }

    function getInfo()
    {
    	$db = & JFactory::getDBO();
    	$version = new JVersion();

    	$info = array(
    		'ext'	=> 'DOCman',
    		'v'		=> _DM_VERSION,
    		'up'	=> 'new',
    		'cms'	=> $version->PRODUCT.' '.$version->RELEASE .'.'. $version->DEV_LEVEL,
    	    'k'		=> class_exists('Koowa') &&  method_exists('Koowa', 'getVersion') ? Koowa::getVersion() : 0,
    		'p' 	=> phpversion(),
    		'db'	=> $db->getVersion(),
    	);
    	return http_build_query($info);

    }

    function removeDmdocuments()
    {
        global $_DOCMAN;

        $dmpath = $_DOCMAN->getCfg( 'dmpath' );

        $files = DMInstallHelper::getDefaultFiles();

    	foreach( $files as $file ) {
            @unlink ( $dmpath.DS.$file );
        }
        @rmdir( $dmpath );
    }
}
