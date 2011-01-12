<?php
/**
 * @version		$Id: DOCMAN_cleardata.class.php 1109 2010-01-07 10:52:08Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class DOCMAN_CleardataItem
{
    /**
     * @abstract
     */
	var $name;

    /**
     * @abstract
     */
    var $friendlyname;

    var $msg;

    /**
     * @static
     */
     function & getInstance( $item )
     {
        $classname = "DOCMAN_CleardataItem_$item";
        $instance = new $classname;
     	return $instance;
     }

    function clear()
    {
    	if (!$this->check()) {
    		return false;
    	}
        return true;
    }

    function check(){return true;}
}


/**
 * @abstract
 */
class DOCMAN_CleardataItemTable extends DOCMAN_CleardataItem
{
    var $table;
    var $where;
    
    function clear()
    {
        if(!$this->check()) {
            return false;
        }
        
    	$database = JFactory::getDBO();
        $database->setQuery("DELETE FROM ".$this->table
                            ."\n ".$this->where);
        if( $database->query()){
            $this->msg = _DML_CLEARDATA_CLEARED.$this->friendlyname;
            return true;
        } else {
        	$this->msg = _DML_CLEARDATA_FAILED.$this->friendlyname;
            return false;
        }
    }
}

class DOCMAN_CleardataItem_docman extends DOCMAN_CleardataItemTable
{
	var $name = 'docman';
    var $friendlyname = 'Documents';
    var $table = '#__docman';
}

class DOCMAN_CleardataItem_docman_groups extends DOCMAN_CleardataItemTable
{
    var $name = 'docman_groups';
    var $friendlyname = 'User Groups';
    var $table = '#__docman_groups';
}

class DOCMAN_CleardataItem_docman_history extends DOCMAN_CleardataItemTable
{
    var $name = 'docman_history';
    var $friendlyname = 'Document History';
    var $table = '#__docman_history';
}

class DOCMAN_CleardataItem_docman_licenses extends DOCMAN_CleardataItemTable
{
    var $name = 'docman_licenses';
    var $friendlyname = 'Licenses';
    var $table = '#__docman_licenses';
}

class DOCMAN_CleardataItem_docman_log extends DOCMAN_CleardataItemTable
{
    var $name = 'docman_log';
    var $friendlyname = 'Download Logs';
    var $table = '#__docman_log';
}

class DOCMAN_CleardataItem_categories extends DOCMAN_CleardataItemTable
{
    var $name = 'categories';
    var $friendlyname = 'Categories';
    var $table = '#__categories';
    var $where = "WHERE section = 'com_docman'";

    function check()
    {
      	$database = JFactory::getDBO();
        $database->setQuery("SELECT COUNT(*) FROM #__docman");
        if( $database->loadResult() >=1 ){
        	$this->msg = _DML_CLEARDATA_CATS_CONTAIN_DOCS;
            return false;
        }
        return true;
    }
}

class DOCMAN_CleardataItem_files extends DOCMAN_CleardataItem
{
	var $name = 'files';
    var $friendlyname = 'Files';
    
    function clear()
    {
        if(!$this->check()) {
            return false;
        }
        
        global $_DOCMAN;
        require_once($_DOCMAN->getPath('classes', 'file'));
    	$folder = new DOCMAN_Folder( $_DOCMAN->getCfg('dmpath' ));
        $files = $folder->getFiles();
        $this->msg = _DML_CLEARDATA_CLEARED.$this->friendlyname;
        if( count($files)){
            foreach( $files as $file ){
        	   if( !$file->remove() ){
        		  $this->msg = _DML_CLEARDATA_FAILED.$this->friendlyname;
                  return false;
        	   }
            }
        }
        return true;
    }

    function check()
    {
        $database = JFactory::getDBO();
        $database->setQuery("SELECT COUNT(*) FROM #__docman");
        if( $database->loadResult() >=1 ){
            $this->msg = _DML_CLEARDATA_DELETE_DOCS_FIRST;
            return false;
        }
        return true;
    }
}

class DOCMAN_CleardataItem_thumbs extends DOCMAN_CleardataItem
{
	var $name = 'thumbs';
    var $friendlyname = 'Thumbnails';
    
    function clear()
    {
        if(!$this->check()) {
            return false;
        }
        
        $database = JFactory::getDBO();
        $query = "UPDATE #__docman SET dmthumbnail = ''";
        $database->setQuery($query);
        $database->query();
        $this->msg = _DML_CLEARDATA_CLEARED.$this->friendlyname;
       
        return true;
    }
}


class DOCMAN_Cleardata 
{
	var $items = array();

    /**
     * @constructor
     */
    function DOCMAN_Cleardata( $items = null )
    {
    	if ( !$items ) {
            $items = array( 'docman', 'categories', 'files', 'docman_groups', 'docman_history', 'docman_licenses', 'docman_log', 'thumbs');
        }
        foreach ($items as $item){
        	$this->items[] = & DOCMAN_CleardataItem::getInstance( $item );
        }
    }

    function clear()
    {
    	foreach( $this->items as $item){
    		$item->clear();
    	}
    }

    function & getList(){
    	return $this->items;
    }

}

