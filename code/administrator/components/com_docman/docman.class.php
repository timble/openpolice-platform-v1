<?php
/**
 * @version		$Id: docman.class.php 1302 2010-03-05 12:46:43Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

require_once( dirname( __FILE__ ) .DS.'includes'.DS.'defines.php');

/**
* DOCman Mainframe class using a singleton pattern
* Provide many supporting API functions
*/

class dmMainFrame
{
	/** @var object An object of configuration variables */
	var $_config = null;

	/** @var object An object that holds the user state */
	var $_user   = null;

	/** @var object An object that holds the user state */
	var $_type   = null;

	/** @var number An number that holds the menu id */
	var $_menuid = 0;

	/**
	* Class constructor
	*/
	function dmMainFrame( $type = _DM_TYPE_UNKNOWN)
	{
		$this->_initialise( $type );
	}

	function _initialise( $type )
	{
		$this->_setAdminPaths( JPATH_SITE );
        require_once($this->getPath('classes', 'compat'));
        require_once($this->getPath('classes', 'utils'));
		$this->_setConfig();
		$this->_setUser();
		$this->_setMenuId();

		$this->setType($type);

		//load common language defines
		$this->loadLanguage('common');

		//include php compatibility files
		$this->loadCompatibility();
	}

	/**
	* Determines the paths for including engine and menu files
	* @param string The base path from which to get the path
	*/
	function _setAdminPaths( $basePath = '.' ) {

		$this->_path = new stdClass();

		// sections
		if (file_exists( $basePath.DS.'administrator'.DS.'components'.DS.'com_docman'.DS.'classes')) {
			$this->_path->classes = DS.'administrator'.DS.'components'.DS.'com_docman'.DS.'classes';
		}
		if (file_exists( $basePath.DS.'administrator'.DS.'components'.DS.'com_docman'.DS.'contrib')) {
			$this->_path->contrib = DS.'administrator'.DS.'components'.DS.'com_docman'.DS.'contrib';
		}
		if (file_exists( $basePath.DS.'administrator'.DS.'components'.DS.'com_docman'.DS.'includes')) {
			$this->_path->includes = DS.'administrator'.DS.'components'.DS.'com_docman'.DS.'includes';
		}
		if (file_exists( "$basePath/administrator/components/com_docman/images")) {
			$this->_path->images = "/administrator/components/com_docman/images";
		}
		if (file_exists( "$basePath/administrator/components/com_docman/temp")) {
			$this->_path->temp = "/administrator/components/com_docman/temp";
		}

		//backend
		if (file_exists( "$basePath/administrator/components/com_docman")) {
			$this->_path->admin_root = "/administrator/components/com_docman";
		}

		//frontend
		if (file_exists( "$basePath/components/com_docman/themes")) {
			$this->_path->themes = "/components/com_docman/themes";
		}
		if (file_exists( "$basePath/components/com_docman/includes")) {
			$this->_path->includes_f = "/components/com_docman/includes";
		}

		//language
		if (file_exists( $basePath.DS.'administrator'.DS.'components'.DS.'com_docman'.DS.'language')) {
			$this->_path->language = DS.'administrator'.DS.'components'.DS.'com_docman'.DS.'language';
		}
	}

	/**
	* Returns a stored path variable
	*
	*/
	function getPath( $folder, $file = '', $type = 0)
	{
		$live_site       = substr_replace(JURI::root(), '', -1, 1);
		$absolute_path  = JPATH_SITE;

        $folder = $this->cleanPath( $folder );
        $file   = $this->cleanPath( $file );

		$result = null;

		if (isset( $this->_path->$folder ))
		{
			switch($folder)
			{
				case 'classes' :
				{
					if($file) {
						$path = $this->_path->$folder.DS.'DOCMAN_'.$file.'.class.php';
						if(file_exists($absolute_path.$path))
						 $result = $path;
					} else
					  	$result = $this->_path->$folder;
				} break;

				case 'contrib' :
				{
					if($file) {
						$path = $this->_path->$folder.DS.$file.DS;
						if(file_exists($absolute_path.$path))
						 $result = $path;
					} else
					  	$result = $this->_path->$folder;
				} break;

				case 'language' :
				{
					if($file) {
						$path = $this->_path->$folder.DS.$file.'.php';
						if(file_exists($absolute_path.$path))
						 $result = $path;
					} else
					  	$result = $this->_path->$folder;
				} break;

				case 'includes':
				case 'includes_f':
				{
					if($file) {
						$path = $this->_path->$folder.'/'.$file.'.php';
						if(file_exists($absolute_path.$path))
						 $result = $path;
					} else
					  	$result = $this->_path->$folder;
				} break;

				case 'images' :
					$result = $this->_path->$folder;
					break;

				case 'temp'   :
					$result = $this->_path->$folder;
					break;

				case 'themes' :
					if($file) {
						$path = $this->_path->$folder.'/'.$file.'/';
						if(file_exists($absolute_path.$path))
						 $result = $path;
					} else {
					  	$result = $this->_path->$folder;
					}
					break;
				case 'admin_root' :
					if($file) {
						$path = $this->_path->$folder.'/'.$file;
						if(file_exists($absolute_path.$path))
						$result = $path;
					} else
						$result = $this->_path->$folder;
						break;
			}
		} else {
			return false;
		}

		$path_type = $type ? $live_site :  $absolute_path;

		return $path_type.$result;
	}

	/**
	* Loads the configuration file and creates a new class
	*/
	function _setConfig( ) 
	{
		require_once( $this->getPath('classes', 'config') );
		$this->_config = new DOCMAN_Config('dmConfig', dirname(__FILE__)."/docman.config.php" );

        //$this->_checkConfig();
	}

    /**
     * Check if the configuration values are valid
     */
    function _checkConfig()
    {
        global $task;
        $save = false;

        // Get the path (ignore result) ... this sets a default value
        if(is_null($this->_config->getCfg('dmpath'))) {
            $this->_config->setCfg('dmpath', JPATH_ROOT.DS._DM_DEFAULT_DATA_FOLDER, true );
            $save = true;
        }

        // trim pipes and spaces in $fname_reject
        if(isset($this->_config->fname_reject)) {
            $this->_config->fname_reject = trim($this->_config->fname_reject, '| ');
            $save = true;
        }

        // never save config during download
        if( $task=='license_result' OR $task=='doc_download' ){
        	$save = false;
        }

        // save the config if necessary
        if($save) {
        	$this->_config->saveConfig();
        }

    }

	/**
	* @param string The name of the variable
	* @return mixed The value of the configuration variable or null if not found
	*/
	function getCfg( $varname , $default=null) {
		return $this->_config->getCfg($varname, $default);
	}

	/**
	* @param string The name of the variable
	* @param string The new value of the variable
	* @return bool True if succeeded, otherwise false.
	*/
	function setCfg( $varname, $value, $create=false) {
		return $this->_config->setCfg($varname, $value, $create);
	}

	/**
	* Saves the configuration object
	*/
	function saveConfig() {

        /*$dmpath = $this->cleanPath($this->getCfg('dmpath'));
        $this->setCfg('dmpath', $dmpath);
		@mkdir($dmpath, 0755, true);*/

		return $this->_config->saveConfig();
		
	}

	/**
	* Create a user object
	*/
	function _setUser( ) {
		require_once( $this->getPath('classes', 'user') );
		$this->_user = new DOCMAN_User( $this->getCfg('specialcompat', _DM_SPECIALCOMPAT_DM13));
	}

	function & getUser() {
        $null = null;
		if (isset( $this->_user )) {
			return $this->_user;
		} else {
			return $null;
		}
	}

	/**
	* Set the mainframe type
	*/
	function setType($type) {
		$this->_type = $type;
	}
	function getType($type) {
		return $this->_type;
	}

	/**
	* Set the menu id
	*/
	function _setMenuId()
	{
		$menus = DOCMAN_Menus::getList();
		if( array_key_exists( 0, $menus)) {
			return $menus[0];
		} else {
			return current($menus);
		}
	}

	function getMenuId() {
		return $this->_menuid;
	}

	/**
	* Load language files
	*/
	function loadLanguage($type)
	{
		$langobj =& JFactory::getLanguage();
		$lang =$langobj->getBackwardLang();

		if (file_exists($this->getPath('language').DS.$lang.'.'.$type.'.php')) {
    		require_once ($this->getPath('language').DS.$lang.'.'.$type.'.php');
		} else {
    		require_once ($this->getPath('language').DS.'english.'.$type.'.php');
		}
	}

	/**
	* Load PHP compatibility files
	*/
	function loadCompatibility()
	{

	}

    /**
    * Check a filename or path for '..', '//' or '\\'
    */
    function cleanPath( $path )
    {
        $path = trim( $path );
        // remove '..'
        $path = str_replace( '..', '', $path );
        // Remove double slashes and backslahses and convert all slashes and backslashes to DS
        $path = preg_replace('#[/\\\\]+#', DIRECTORY_SEPARATOR, $path);

        return $path;
    }
}

/**
* Document database table class
* @package DOCman_1.5
*/

class mosDMDocument extends JTable
{
    var $id                 = null;
    var $catid              = null;
    var $dmname             = null;
    var $dmfilename         = null;
    var $dmdescription      = null;
    var $dmdate_published   = null;
    var $dmowner            = null;
    var $published          = null;
    var $dmurl              = null;
    var $dmcounter          = null;
    var $checked_out        = null;
    var $checked_out_time   = null;
    var $approved           = null;
    var $dmthumbnail        = null;
    var $dmlastupdateon     = null;
    var $dmlastupdateby     = null;
    var $dmsubmitedby       = null;
    var $dmmantainedby      = null;
    var $dmlicense_id       = null;
    var $dmlicense_display  = null;
    var $access             = null;
    var $attribs            = null;

	function __construct(&$database)
	{
		parent::__construct('#__docman', 'id', $database);
	}

	function load( $cid=0 )
	{
		if( $cid == 0 )			// Only read if recID passed
			return $this->init_record();
		else				// fill in some 'null' fields
			return parent::load( $cid );
	}

	/*
	*   @desc Internal routine - initialize some critical values
	*	@param none
	*	@param true
	*/

	function init_record()
	{
		global $_DOCMAN;

		$my = JFactory::getUser();

		$this->id				= null;
		$this->published        = 0;
		$this->approved         = 0;
		$this->dmsubmitedby     = $my->id;
		$this->dmlastupdateby   = $my->id;

		$this->dmowner		 = $_DOCMAN->getCfg( 'default_viewer' );
		$this->dmmantainedby = $_DOCMAN->getCfg( 'default_editor' );

		$this->dmdate_published = date( "Y-m-d H:i:s" );

		if( $this->dmowner  == _DM_PERMIT_CREATOR ){
			$this->dmowner = $this->dmsubmitedby;
		}
		if( $this->dmmantainedby == _DM_PERMIT_CREATOR ){
			$this->dmmantainedby = $this->dmsubmitedby;
		}
		return true;
	}

	/*
	*   @desc Check a document
	*	@param nothing
	*	@returns boolean true if checked
	*/

	function check()
	{
		$my = JFactory::getUser();

		// Check fields to be sure they are correct
		$this->_error = "";
		if( ! $this->dmname){
			$this->_error .= "\\n" . _DML_ENTRY_NAME;
		}
		if( $this->dmfilename == "" ){
			$this->_error .= "\\n". _DML_ENTRY_DOC;
		}
        if( $this->dmfilename == _DM_DOCUMENT_LINK
            AND $document_url = JRequest::getString('document_url', false, 'post')
            AND parse_url($document_url))
        {
            $this->dmfilename = _DM_DOCUMENT_LINK.$document_url;
        }

		if( ! $this->catid ){
			$this->_error .= "\\n" . _DML_ENTRY_CAT;
		}
		if( $this->dmowner == _DM_PERMIT_NOOWNER ||
			$this->dmowner == "" ){
			$this->_error .= "\\n" . _DML_ENTRY_OWNER;
		}

		if( $this->dmmantainedby == _DM_PERMIT_NOOWNER ||
		    	$this->dmmantainedby == "" ){
			$this->_error .= "\\n" . _DML_ENTRY_MAINT;
		}
		if( $this->dmdate_published == "" ){
			$this->_error .= "\\n" . _DML_ENTRY_DATE;
		}

        // making sure...
        $this->id                 = (int) $this->id;
        $this->catid              = (int) $this->catid;
        $this->dmname             = strip_tags($this->dmname);
        //$this->dmdescription      = DOCMAN_Compat::inputFilter($this->dmdescription);
        //$this->dmfilename         = strip_tags($this->dmfilename);
        $this->dmdate_published   = strip_tags($this->dmdate_published);
        $this->dmowner            = (int) $this->dmowner;
        $this->published          = strip_tags($this->published);
        $this->dmurl              = strip_tags($this->dmurl);
        $this->dmcounter          = (int) $this->dmcounter;
        $this->checked_out        = (int) $this->checked_out;
        $this->checked_out_time   = strip_tags($this->checked_out_time);
        $this->approved           = (int) $this->approved;
        $this->dmthumbnail        = strip_tags($this->dmthumbnail);
        $this->dmlastupdateon     = strip_tags($this->dmlastupdateon);
        $this->dmlastupdateby     = (int) $this->dmlastupdateby;
        $this->dmsubmitedby       = (int) $this->dmsubmitedby;
        $this->dmmantainedby      = (int) $this->dmmantainedby;
        $this->dmlicense_id       = (int) $this->dmlicense_id;
        $this->dmlicense_display  = (int) $this->dmlicense_display;
        $this->access             = (int) $this->access;
        $this->attribs            = strip_tags( $this->attribs );


		// Check for links...
		if( strncasecmp( $this->dmfilename , _DM_DOCUMENT_LINK , _DM_DOCUMENT_LINK_LNG )==0){

			$document_url = str_replace(_DM_DOCUMENT_LINK, '', $this->dmfilename);
			// Check for a config string..
			if( defined( '_DM_DOCUMENT_VALIDATE' ) ){
				$rmatch = '(' . _DM_DOCUMENT_VALIDATE . ')' ;
			}else{
				$rmatch = '([a-zA-Z]*)';
			}
			if( strncasecmp( 'file://' ,  $document_url , 7 ) == 0 ){
				$this->_error .= "\\n" . _DML_ENTRY_DOCLINK_PROTOCOL . ' (code 150) '.$document_url;
			}else if( ! preg_match( '/^' . $rmatch . ':\/\//' , $document_url ) ){
				$this->_error .= "\\n" . _DML_ENTRY_DOCLINK_PROTOCOL . ' (code 151) '.$document_url;
			}else if( ! preg_match( '/^' . $rmatch . ':\/\/(.+)$/' , $document_url ) ){
				$this->_error .= "\\n" . _DML_ENTRY_DOCLINK_NAME . ' (code 152) '.$document_url;
			/* Removed test, user is responsible for submitting existing urls
              }else if( ($fh = fopen( $document_url , 'r' ) ) == false ){
				$this->_error .= "\\n" . _DML_ENTRY_DOCLINK_INVALID . ' (code 153) '.$document_url;
                */
			}else{
				//fclose( $fh );
				$this->dmfilename = _DM_DOCUMENT_LINK . $document_url;
			}
		}

		if( $this->_error ){
			$this->_error = _DML_ENTRY_ERRORS
			. "\\n---------------------------------"
			. $this->_error;
			return false;
		}

		// Fill in default submitted values
		$date = date( "Y-m-d H:i:s" );

		if( $my->id )
		{
			$this->dmlastupdateby   = $my->id;
			if( $this->dmowner  == _DM_PERMIT_CREATOR ){
				$this->dmowner = $this->dmsubmitedby;
			}
			if( $this->dmmantainedby == _DM_PERMIT_CREATOR ){
				$this->dmmantainedby = $this->dmsubmitedby;
			}
			if( ! $this->dmsubmitedby  ){
        		$this->dmsubmitedby     = $my->id;
			}
		}

		if( ! $this->dmdate_published )
			$this->dmdate_published = $date;

		$this->dmlastupdateon 	= $date;



		return true;
	}
	/*
	* @desc Approves a document
	* @param int the document id
	* @param boolean approve/unapprove
	*/

	function approve($cid, $approved = 1)
	{
		$my       = JFactory::getUser();
		$database = JFactory::getDBO();

		$cids = implode(',', $cid);
		$database->setQuery(
			"UPDATE #__docman SET approved=". (int) $approved
			."\n WHERE id IN ($cids) "
			."\n   AND (checked_out=0 OR (checked_out=". $my->id . "))");

	  	if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
			return false;
	   	}

	  	return true;
	}

	/*
	* @desc Publish a document
	* @param array an array with ids
	* @param boolean publish/unpublish
	*/

	function publish( $cid, $publish )
	{
		$my       = JFactory::getUser();
		$database = JFactory::getDBO();

		if (!is_array($cid) || count($cid) <1) {
			$action = $publish ? 'publish' : 'unpublish';
			echo "<script> alert('". _DML_SELECT_ITEM_MOVE ." $action'); window.history.go(-1);</script>\n";
			return false;
		}

		$cids = implode(',', $cid);
		$database->setQuery(
			"UPDATE #__docman SET published=" . (int) $publish
			." \n WHERE id IN ($cids) "
			." \n AND (checked_out=0 OR (checked_out=$my->id))");

		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
			return false;
		}

		return true;
	}

	/*
	* @desc Move a document
	* @param array an array with ids
	* @param int an int with the new category id
	*/

	function move( $cid, $catid )
	{
		$my       = JFactory::getUser();
		$database = JFactory::getDBO();

		if (!(is_array($cid)) || (count($cid) < 1)) {
			echo "<script> alert('". _DML_SELECT_ITEM_MOVE ." ); window.history.go(-1);</script>\n";
			return false;
		}

		$cids = implode(',', $cid);
        $query = "UPDATE #__docman SET catid=". (int) $catid
                ."\n WHERE id IN ($cids)"
                ."\n AND (checked_out = 0 OR (checked_out=".$my->id."))";
		$database->setQuery($query);

		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
			return false;
		}

	        return true;
	}

   /*
    * @desc Copy a document
    * @param array an array with ids
    * @param int an int with the new category id
    */

    function copy( $cid, $catid )
    {
        $database = JFactory::getDBO();

        if (!(is_array($cid)) || (count($cid) < 1)) {
            echo "<script> alert('". _DML_SELECT_ITEM_COPY ." ); window.history.go(-1);</script>\n";
            return false;
        }

        foreach( $cid as $id )
        {
           $docold = new mosDMDocument($database);
           $docnew = new mosDMDocument($database);
           $docold->load($id);
           $docnew->bind( (array) $docold );
           $docnew->id = 0;
           $docnew->catid = $catid;
           if($docold->catid == $docnew->catid) {
               $docnew->dmname = _DML_COPY_OF . ' ' . $docnew->dmname;
           }
           $docnew->store();
        }


        return true;
    }

	/*
	* @desc Deletes documents
	* @param array an array with ids
	*/

	function remove($cid)
	{
		$database = JFactory::getDBO();

		if (!is_array($cid) || count($cid) <1) {
			echo "<script>alert(". _DML_SELECT_ITEM_DEL ."); window.history.go(-1);</script>\n";
			return false;
		}

		$cids = implode(',', $cid);
		$database->setQuery("DELETE FROM #__docman WHERE id IN ($cids)");

		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
			return false;
		}

		return true;
	}

	function save()
	{
		$database = JFactory::getDBO();

        $post = DOCMAN_Utils::stripslashes($_POST);

		$this->reorder("catid=".(int)$_POST['catid']);
		if (!$this->bind($post)) {
			echo "<script> alert('".$this->getError() ."'); window.history.go(-1); </script>\n";
			exit();
		}
		$this->_tbl_key = "id";
		if (!$this->check()) { // Javascript SHOULD catch all this!
			echo "<h1><center>" . _DML_ENTRY_ERRORS . "</center><h1>";
			echo "<script> alert('".$this->getError() ."'); window.history.go(-1); </script>\n";
			exit();
		}
		if (!$this->store()) {
			echo "<script> alert('".$this->getError() ."'); window.history.go(-1); </script>\n";
			exit();
		}
		$this->checkin();
		return true;
	}

	function cancel()
	{
		$this->bind(DOCMAN_Utils::stripslashes($_POST));
		$this->checkin();

		return true;
	}

	function incrementCounter()
	{
		$database = JFactory::getDBO();
		$database->setQuery("UPDATE #__docman SET dmcounter=dmcounter+1 WHERE id=". (int) $this->id);
		if (!$database->query()) {
			echo "<script> alert('".$db->getErrorMsg() ."'); window.history.go(-1); </script>\n";
			exit();
		}
		return true;
	}

	function _returnParam( $field , $config_field='',$attribs=null )
	{
		global $_DOCMAN;

		if( ! $config_field ) { $config_field = $field ; }
		if( is_null($attribs)){ $attribs = $this->attribs ;}

		if( ! isset($this->_params) && $attribs ) {
			$this->_params =  new JParameter( $attribs );
		}

		if( isset( $this->_params->$field ) ) {
			return( $this->_params->$field );
		}

		return $_DOCMAN->getCfg( $config_field );
	}

	function authorCan($a=null)    { return $this->_returnParam( 'author_can'   ,'',$a );}
	function readerAssign($a=null) { return $this->_returnParam( 'reader_assign','',$a );}
	function editorAssign($a=null) { return $this->_returnParam( 'editor_assign','',$a );}
}

/**
* Category database table class
* @package DOCman_1.5
*/
class mosDMCategory extends JTable
{

	/** @var int */
	var $id			= null;
	var $parent_id		= null;
	var $title		= null;
	var $name		= null;
	var $image		= null;
	var $section		= null;
	var $image_position	= null;
	var $description	= null;
	var $published		= null;
	var $checked_out	= null;
	var $checked_out_time	= null;
	var $editor		= null;
	var $ordering		= null;
	var $access		= null;
	var $count		= null;
	var $params		= null;

	/**
	* @param database A database connector object
	*/
	function __construct( &$db ) {
		parent::__construct( '#__categories', 'id', $db );
	}

    function & getInstance( $id = 0 )
    {
        $database = JFactory::getDBO();
    	static $instances = array();

        if( !$id) {
        	$new = new mosDMCategory( $database );
            return $new;
        }

        if( !isset( $instances[$id] )) {

            $instances[$id] = new mosDMCategory( $database );
            //$instances[$id]->load( $id );

            // instead of loading, we'll use the the following method to improve performance
            $list = & DOCMAN_Cats::getCategoryList(); // get a list of categories, $list[$id] is our current category
            $instances[$id]->bind( (array) $list[$id] ); // assign each property of the category to the category object
        }

        return $instances[$id];
    }

	/**
	* @desc	  generic check method
	* @return boolean True if the object is ok
	*/
	function check()	{
		$this->section = "com_docman";
		return true;
	}
}

/**
* Group database table class
* @package DOCman_1.5
*/

class mosDMGroups extends JTable
{
	var $groups_id		= null;
	var $groups_name	= null;
	var $groups_description = null;
	var $groups_access 	= null;
	var $groups_members 	= null;

	function __construct(&$database)
	{
		parent::__construct('#__docman_groups', 'groups_id', $database);
	}
}

/**
* License database table class
* @package DOCman_1.5
*/

class mosDMLicenses extends JTable
{
	var $id 	= null;
	var $name 	= null;
	var $license 	= null;

	function __construct(&$database)
	{
		parent::__construct('#__docman_licenses', 'id', $database);
	}
}

/**
* History database table class
* @package DOCman_1.5
*/

class mosDMHistory extends JTable
{
	var $id 	= null;
	var $doc_id 	= null;
	var $his_date 	= null;
	var $his_who 	= null;
	var $his_obs 	= null;

	function __construct(&$database)
	{
		parent::__construct('#__docman_history', 'id', $database);
	}
}

/**
* Log database table class
* @package DOCman_1.5
*/

class mosDMLog extends JTable
{
	var $id 		= null;
	var $log_docid 		= null;
	var $log_ip		= null;
	var $log_datetime 	= null;
	var $log_user 		= null;
	var $log_browser 	= null;
	var $log_os 		= null;

	function __construct(&$database)
	{
		parent::__construct('#__docman_log', 'id', $database);
	}

	/*
	* @desc Deletes download logs entries
	* @param array the log ids as an array
	*/

	function remove($cid) //removeLog
	{
		$database = JFactory::getDBO();

		if (!is_array($cid) || count($cid) <1) {
			echo "<script> alert(". _DML_SELECT_ITEM_DEL ."); window.history.go(-1);</script>\n";
			return false;
		}

		if (count($cid))
		{
			$cids = implode(',', $cid);
			$database->setQuery(
				"DELETE FROM #__docman_log "
				. "\n WHERE id IN ($cids)"
			);

			if (!$database->query()) {
				echo "<script> alert('".$database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
				return false;
			}
		}
		return true;
	}

	function loadRows($cid)
	{
		$database = JFactory::getDBO();

		if( is_array( $cid ) ) {
			if( count( $cid )){
				$cids = implode(',', $cid);
			}
		} else {
			$cids = $cid;
		}
		if( ! $cids )
			return null;

		$database->setQuery(
			  "SELECT * FROM #__docman_log "
			. "\n WHERE id IN ($cids)"
		);
		return $database->loadObjectlist();
	}
}