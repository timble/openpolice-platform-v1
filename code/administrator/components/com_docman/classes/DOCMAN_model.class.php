<?php
/**
 * @version		$Id: DOCMAN_model.class.php 1366 2010-05-04 13:00:26Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

require_once($_DOCMAN->getPath('classes', 'utils'));
require_once($_DOCMAN->getPath('classes', 'user'));

class DOCMAN_Model
{
    var $objDBTable = null;

    var $objFormatData = null;
    var $objFormatLink = null;
    var $objFormatPath = null;

    function DOCMAN_Model()
    {
        $this->objFormatData = new stdClass();
        $this->objFormatLink = new stdClass();
        $this->objFormatPath = new stdClass();
    }

    function getLink($identifier)
    {
        if (isset($this->objFormatLink->$identifier))
            return $this->objFormatLink->$identifier;
        else
            return null;
    }

    function getPath($identifier)
    {
        if (isset($this->objFormatPath->$identifier))
            return $this->objFormatPath->$identifier;
        else return null;
    }

    function getData($identifier)
    {
        if (isset($this->objFormatData->$identifier))
            return $this->objFormatData->$identifier;
        else
            return null;
    }

    function setData($identifier, $data)
    {
        $this->objFormatData->$identifier = $data;
    }

    function &getLinkObject()
    {
        return $this->objFormatLink;
    }

    function &getPathObject()
    {
        return $this->objFormatPath;
    }

    function &getDataObject()
    {
        return $this->objFormatData;
    }

    function getDBObject()
    {
        return $this->objDBTable;
    }

    function _format($objDBTable)
    {
    }

    function _formatLink($task, $params = array(), $sef = true, $indexfile = 'index.php', $token = false)
    {
        global $_DOCMAN;
        require_once($_DOCMAN->getPath('classes', 'token'));

        if($token)
        {
            $params[DOCMAN_token::get(false)] = 1;
        }


        $link = DOCMAN_Utils::taskLink($task, $this->objDBTable->id, $params, $sef, $indexfile );
        return $link;
    }
}

class DOCMAN_Category extends DOCMAN_Model
{
    function DOCMAN_Category($id)
    {
        $this->objDBTable = & mosDMCategory::getInstance( $id );

        $this->_format($this->objDBTable);
    }

    function getPath($identifier, $type = 1, $param = null, $png = 1)
    {
        $result = null;

        switch ($identifier) {
            case 'icon' :
                $result = DOCMAN_Utils::pathIcon ('folder.png', $type, $param, $png);
                break;

            default :
                $result = parent::getPath($identifier);
        }

        return $result;
    }

    function _format(&$objDBCat)
    {
        global $_DOCMAN;

        $user = $_DOCMAN->getUser();
        // format category data
        $this->objFormatData = DOCMAN_Utils::get_object_vars($objDBCat);

        $this->objFormatData->files = DOCMAN_Cats::countDocsInCatByUser($objDBCat->id, $user, true);
        // format category links
        $this->objFormatLink->view = $this->_formatLink('cat_view');
        // format category paths
        $this->objFormatPath->thumb = DOCMAN_Utils::pathThumb($objDBCat->image);
        $this->objFormatPath->icon = DOCMAN_Utils::pathIcon ('folder.png', 1);
    }
}

class DOCMAN_Document extends DOCMAN_Model
{
    function DOCMAN_Document($id)
    {
        $database = JFactory::getDBO();
        $this->objDBTable = new mosDMDocument($database);

        $this->objDBTable->load($id);

        $this->_format($this->objDBTable);

    }

    function & getInstance($id) {
    	static $instances;

        if(!isset($instances)) {
            $instances = array();
        }

        if(!isset($instances[$id])) {
        	$instances[$id] = new DOCMAN_Document($id);
        }

        return $instances[$id];
    }

    function getPath($identifier, $type = 1, $param = null)
    {
        $result = null;

        switch ($identifier) {
            case 'icon' :
                $result = DOCMAN_Utils::pathIcon ($this->objFormatData->filetype . ".png", $type, $param);
                break;

            default :
                $result = parent::getPath($identifier);
        }

        return $result;
    }

    function _format(&$objDBDoc)
    {
        global $_DOCMAN;
        require_once($_DOCMAN->getPath('classes', 'file'));
        require_once($_DOCMAN->getPath('classes', 'params'));
        require_once($_DOCMAN->getPath('classes', 'mambots'));

        $file = new DOCMAN_file($objDBDoc->dmfilename, $_DOCMAN->getCfg('dmpath'));
        $params = new dmParameters( $objDBDoc->attribs, '' , 'params' );

        // format document data
        $this->objFormatData = DOCMAN_Utils::get_object_vars($objDBDoc);

        $this->objFormatData->owner 			= $this->_formatUserName($objDBDoc->dmowner);
        $this->objFormatData->submited_by 		= $this->_formatUserName($objDBDoc->dmsubmitedby);
        $this->objFormatData->maintainedby 		= $this->_formatUserName($objDBDoc->dmmantainedby);
        $this->objFormatData->lastupdatedby 	= $this->_formatUserName($objDBDoc->dmlastupdateby);
        $this->objFormatData->checkedoutby 		= $this->_formatUserName($objDBDoc->checked_out);
        $this->objFormatData->filename 			= $this->_formatFilename($objDBDoc);
        $this->objFormatData->filesize 			= $file->getSize();
        $this->objFormatData->filetype 			= $file->ext;
        $this->objFormatData->mime 				= $file->mime;
        $this->objFormatData->hot               = $this->_formatHot($objDBDoc);
        $this->objFormatData->new               = $this->_formatNew($objDBDoc);
        $this->objFormatData->state 			= $this->objFormatData->new.' '.$this->objFormatData->hot; //for backwards compat with 1.3
        $this->objFormatData->params			= $params;
        $this->objFormatData->dmdescription     = $objDBDoc->dmdescription;
        $this->objFormatData->permalink    		= JRoute::_($this->_formatLink('doc_details'));
        $this->objFormatData->downloadlink 		= JRoute::_($this->_formatLink('doc_download'));


        // onFetchButtons event
        // plugins should always return an array of Button objects
        $bot = new DOCMAN_mambot('onFetchButtons');
        $bot->setParm('doc' , $this);
        $bot->setParm('file' , $file);
        $bot->trigger();
        if ($bot->getError()) {
            _returnTo('cat_view', $bot->getErrorMsg());
        }

        $buttons = array();
        foreach( $bot->getReturn() as $return) {
            if(!is_array($return)) {
            	$return = array($return);
            }
        	$buttons = array_merge($buttons, $return);
        }

        $this->objFormatLink = & $buttons;


        // format document paths
        $this->objFormatPath->icon = DOCMAN_Utils::pathIcon ($file->ext . ".png", 1);
        $this->objFormatPath->thumb = DOCMAN_Utils::pathThumb($objDBDoc->dmthumbnail, 1);

    }

    //  @desc Translate the numeric ID to a character string
    //  @param integer $ The numeric ID of the user
    //  @return string Contains the user name in string format
    function _formatUserName($userid)
    {
        global $_DOCMAN;
        $database = JFactory::getDBO();
        require_once($_DOCMAN->getPath('classes', 'user'));
        require_once($_DOCMAN->getPath('classes', 'groups'));

        switch ($userid)
        {
            case '-1':
                return _DML_EVERYBODY;
                break;
            case '0':
                return _DML_ALL_REGISTERED;
                break;
            case _DM_PERMIT_PUBLISHER:
                return _DML_GROUP_PUBLISHER;
                break;
            case _DM_PERMIT_EDITOR:
                return _DML_GROUP_EDITOR;
                break;
            case _DM_PERMIT_AUTHOR:
                return _DML_GROUP_AUTHOR;
                break;
            default:

                if ($userid > 0)
                {
                    $user = DOCMAN_users::get($userid);
                    return $user->username;
                }

				if($userid < -5)
				{
      				$calcgroups = (abs($userid) - 10);
                    $user = DOCMAN_groups::get($calcgroups);
                    return $user->groups_name;
				}
                break;
        }

        return "USER ID?";
    }

    function _formatNew(&$objDBDoc)
    {
        global $_DOCMAN;
        $days = $_DOCMAN->getCfg('days_for_new');
        $result = null;

        if ($days > 0 &&
            (DOCMAN_Utils::Daysdiff ($objDBDoc->dmdate_published) > ($days -2 * $days)) && (DOCMAN_Utils::Daysdiff ($objDBDoc->dmdate_published) <= 0)) {
            $result = _DML_NEW;
        }
        return $result;
    }

    function _formatHot(&$objDBDoc)
    {
        global $_DOCMAN;
        $hot = $_DOCMAN->getCfg('hot');
        $result = null;

        if ($hot > 0 && $objDBDoc->dmcounter >= $hot) {
            $result = _DML_HOT;
        }

        return $result;
    }

    function _formatFilename( &$objDBDoc)
    {
        global $_DOCMAN;
        $_DMUSER = $_DOCMAN->getUser();

        $filename = $objDBDoc->dmfilename;
        $is_link = (  substr($filename, 0, strlen(_DM_DOCUMENT_LINK)  ) == _DM_DOCUMENT_LINK );
        $hide_remote = $_DOCMAN->getCfg( 'hide_remote', 1 );
        $can_edit = $_DMUSER->canEdit( $objDBDoc );


        if( $is_link AND $hide_remote AND !$can_edit )  {
            // strip 'Link: '
            $filename = preg_replace( '$^'._DM_DOCUMENT_LINK.'$', '', $filename) ;

            // strip scheme (http://, ftp:// )
            $filename = preg_replace( '$^[a-zA-Z]+://$', '', $filename);

            if( strpos( $filename, '/' )) { // format www.mysite.com/ or www.mysite.com/path/ or www.mysite.com/path/myfile.com
                // strip domain (www.mysite.com )
                $filename = preg_replace( '$^(([.]?[a-zA-Z0-9_-])*)/$', '/', $filename);
                // strip path
                $filename = substr( $filename, strrpos( $filename, '/')+1 );
            } else { // format www.mysite.com (no trailing slash or path or filename)
            	$filename ='';
            }

            // if there's nothing left, we mark it 'unknown'
            $filename = ( $filename ? _DML_LINKTO.$filename : _DML_UNKNOWN );

        }

        return $filename;
    }
}