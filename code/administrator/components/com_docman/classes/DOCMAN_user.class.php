<?php
/**
 * @version		$Id: DOCMAN_user.class.php 1155 2010-01-25 21:46:31Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
* DOCMAN permissions class.
*
* @desc class purpose is to handle users and groups permissions and related functions
*/

class DOCMAN_User
{
   /**
    * @access 	public
    * @var 		int
    */
    var $userid = null;

   /**
    * @access 	public
    * @var 		string
    */
    var $usertype = null;

   /**
    * @access 	public
    * @var 		int
    */
    var $gid = null;

   /**
    * @access 	public
    * @var 		string
    */
    var $username = null;

   /**
    * @access 	public
    * @var 		bool
    */
    var $isAdmin = 0;

    /**
    * @access   public
    * @var      bool
    */
    var $isSpecial = 0;

   /**
    * @access 	public
    * @var 		bool
    */
    var $isEditor = 0;

   /**
    * @access 	public
    * @var 		bool
    */
    var $isPublisher = 0;

   /**
    * @access 	public
    * @var 		bool
    */
    var $isAuthor = 0;

   /**
    * @access 	public
    * @var 		bool
    */
    var $isManager = 0;

    /**
    * @access 	public
    * @var 		bool
    */
    var $isRegistered = 0;

   /**
    * @access 	public
    * @var 		string 		Contains a 'negative' number list.
    */
    var $groupsIn = null;

    /**
     * @access	public
     * @var		integer		Special Compatibility mode
     * 0 = DOCman 1.3 Style, 1 = Joomla-style(authors+ are special)
     * Change this here in the code if needed.
     */
     var $specialcompat = 0;

   /**
    * @desc 	constructor
    * @return 	void
    */
    function DOCMAN_User()
    {
        $user = JFactory::getUser();

        $this->userid 	= $user->id;
        $this->username = $user->username;
        $this->usertype = strtolower($user->usertype);
        $this->gid 		= $user->gid;

		$this->setUsertype();
        $this->groupsIn = $this->getGroupsIn();

    }

    function setUsertype()
    {
        global $_DOCMAN;
        switch($this->usertype)
        {
        	case 'super administrator' :
        	{
        		$this->isAdmin   	= 1;
        		$this->isRegistered = 1;
                $this->isSpecial    = 1;
        	} break;
        	case 'administrator'	   :
        	{
        		$this->isAdmin   	= 1;
        		$this->isRegistered = 1;
                $this->isSpecial    = 1;
        	} break;
        	case 'manager'			   :
        	{
        		$this->isAdmin 		= 1;
            	$this->isManager 	= 1;
            	$this->isRegistered = 1;
                $this->isSpecial    = 1;
        	} break;
        	case 'editor'				:
        	{
        		$this->isEditor 	= 1;
        		$this->isRegistered = 1;
                $this->isSpecial    = $this->specialcompat;
        	} break;
        	case 'publisher'			:
        	{
        		$this->isPublisher 	= 1;
        		$this->isRegistered = 1;
                $this->isSpecial    = $this->specialcompat;
        	} break;
        	case 'author'				:
        	{
        		$this->isAuthor 	= 1;
        		$this->isRegistered = 1;
                $this->isSpecial    = $this->specialcompat;
        	} break;
        	case 'user'				:
        	case 'registered' 		:
        	{
        		$this->isRegistered = 1;
        	} break;
        }
    }


   /**
    * @desc 	Checks if the user can access the component.
    * @return 	bool
    */

    function getGroupsIn()
    {
        $database = JFactory::getDBO();

        $groups_in = array();

        //Add DOCman groups
        $database->setQuery("SELECT groups_id,groups_members " .
                            "\n FROM #__docman_groups");
        $all_groups = $database->loadObjectList();

        if (count($all_groups)) {
            foreach ($all_groups as $a_group) {
                $group_list = array();
                $group_list = explode(',', $a_group->groups_members);
                if (in_array($this->userid , $group_list))
				{
				  	$groups_in[] = trim(-1 * ($a_group->groups_id + 10));
                }
            }
        }

        //Add Mambo groups
        if($this->isAuthor) {
        	$groups_in[] = _DM_PERMIT_AUTHOR;
        }
        if($this->isEditor) {
        	$groups_in[] = _DM_PERMIT_EDITOR;
        }
        if($this->isPublisher)	{
        	$groups_in[] = _DM_PERMIT_PUBLISHER;
        }

        if ( empty($groups_in) )
        	return '0,0';

        return implode(',',$groups_in);
    }

   /**
    * @desc 			Checks if the the user is a member of a group
    * @param 	int 	Group $ ID to check (must be a negative number)
    * @return 	bool
    */

    function isInGroup( $group_number )
    {
        return preg_match("/(^|,)$group_number(,|$)/" , $this->groupsIn) ;
    }

    /**
    * @desc 	checks if the user can preform a certain task
    * @access  	public
    * @return 	string	error message
    */
    function canPreformTask($doc = null, $task)
	{
    	$err = '';

    	if ($this->userid > _DM_PERMIT_USER)
    	{
       		//Make sure we have a document object
        	$this->isDocument($doc);

        	// user has no permissions to preform the operation
     		$func = "can".$task;
      		if (!call_user_func(array($this, "".$func.""), $doc)) {
         		$err .= _DML_NOT_AUTHORIZED;
      		}

       		// document already checked out by other user
       		if (!is_null($doc) && $doc->checked_out) {
         		if ($doc->checked_out != $this->userid) {
             		$err .= _DML_THE_MODULE . " $doc->dmname " . _DML_IS_BEING;
           		}
      		}
    	} else {
        	$err .= _DML_NOLOG;
    	}

    	return $err;
	}

   /**
    * @desc checks in the user can access the component.
    * @access  	public
    * @return 	bool
    */

    function canAccess()
    {
        global $_DOCMAN;
        // if the user is not logged in...
        if (!$this->userid && $_DOCMAN->getCfg('registered') == _DM_GRANT_NO) {
            return 0;
        }
        // check if the component is down
        if (!$this->isSpecial && $_DOCMAN->getCfg('isDown')) {
            return -1;
        }

        return 1;
    }

   /**
    * @desc 	checks if the user can download a document
    * @access  	public
    * @return 	bool
    */

    function canUpload()
    {
        global $_DOCMAN;

        // preform checks
        if ($this->isAdmin) {
            return true;
        }

        if ($this->userid)
        {
            $upload = $_DOCMAN->getCfg('user_upload');

            if ($upload == $this->userid || $upload == _DM_PERMIT_REGISTERED) {
                return true;
            }

            if ( $upload == _DM_PERMIT_AUTHOR AND ( $this->isAuthor OR $this->isEditor OR $this->isPublisher) ) {
            	return true;
            }

            if ( $upload == _DM_PERMIT_EDITOR AND ( $this->isEditor OR $this->isPublisher) ) {
                return true;
            }

            if ( $upload == _DM_PERMIT_PUBLISHER AND $this->isPublisher ) {
                return true;
            }

            if ($this->isInGroup($upload)) {
              	return true;
            }
        }

        return false;
    }

   /**
    * @desc 	Checks if the user can download a document
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */
    function canDownload($doc = null)
    {
        global $_DOCMAN;

        $database = JFactory::getDBO();

        //Make sure we have a document object
        $this->isDocument($doc);

        //check if user has access to the document's category
        if(!$this->canAccessCategory($doc->catid)) {
        	return false;
        }

        // preform checks
        if ($this->isSpecial ) {
            return true;
        }

        if($this->canEdit($doc, false)) {
        	return true;
        }

        if ($this->userid == 0 && $_DOCMAN->getCfg('registered') != _DM_GRANT_RX) {
            return false;
        }

        if ($doc->dmowner == _DM_PERMIT_EVERYONE) {
            return true;
        }

        if ($this->userid) {
            if ($doc->dmowner == _DM_PERMIT_REGISTERED) {
                return true;
            }

            if ($doc->dmowner > _DM_PERMIT_USER && $doc->dmowner == $this->userid) {
                return true;
            }

            if ($doc->dmowner < _DM_PERMIT_GROUP && $this->isInGroup($doc->dmowner)) {
                return true;
            }

            if ($doc->dmsubmitedby == $this->userid) {
                if (is_a($doc, 'mosDMDocument')) {
                    $authorCan = $doc->authorCan();
                } else { // Naughty! No object. Create a temp one
                    $tempDoc = new mosDMDocument($database);
                    $tempDoc->attribs = $doc->attribs;
                    $authorCan = $tempDoc->authorCan();
                }
                if ($authorCan >= _DM_AUTHOR_CAN_READ) {
                    return true;
                }
            }
        }
        return false;
    }

   /**
    * @desc 	Checks if the user can edit a document entry
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */

    function canEdit($doc = null, $checkCreator = true)
    {
        global $_DOCMAN;

        $database = JFactory::getDBO();

        //Make sure we have a document object
        $this->isDocument($doc);

        // preform checks
        if ($this->isSpecial) { // admin
            return true;
        }

        //check if user has access to the document's category
        if(!$this->canAccessCategory($doc->catid)) {
        	return false;
        }

        $maintainer = $doc->dmmantainedby;

        if($this->userid)
        {
        	if ( ($maintainer == $this->userid) || ($maintainer == _DM_PERMIT_REGISTERED) ) { // maintainer
            	return true;
        	}

        	// Check Creator
        	if ($checkCreator && $doc->dmsubmitedby == $this->userid) {
            	if (is_a($doc, 'mosDMDocument')) {
                	$authorCan = $doc->authorCan();
            	} else { // Naughty! No object. Create a temp one
             	   $tempDoc = new mosDMDocument($database);
                	$tempDoc->attribs = $doc->attribs;
                	$authorCan = $tempDoc->authorCan();
            	}
            	if ($authorCan &_DM_AUTHOR_CAN_EDIT) {
                	return true;
            	}
        	}

        	if ($this->isInGroup($maintainer)) {
            	   	return true;
        	}
        }

        return false; // DEFAULT: can't edit
    }

   /**
    * @desc 	Checks if the user can approve a document entry
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return	bool
    */

    function canApprove()
    {
        global $_DOCMAN;

        // preform checks
        if ($this->isSpecial) {
            return true;
        }

        if ($this->userid) {
            $approve = $_DOCMAN->getCfg('user_approve');

            if ($approve == $this->userid || $approve == _DM_PERMIT_REGISTERED) {
                return true;
            }

           	if ($this->isInGroup($approve)) {
               	return true;
            }
        }
        return false; // DEFAULT: can't approve
    }

   /**
    * @desc 	Checks if the user can publish a document
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */

    function canPublish($doc = null)
    {
        global $_DOCMAN;

        //Make sure we have a document object
        $this->isDocument($doc);

        if(!is_null($doc)) {
        	//make sure the document isn't published and is approved
        	if ($doc->published || !$doc->approved) {
           	 	return false;
        	}
        }

        if ($this->isSpecial) {
            return true;
        }

        if ($this->userid)
        {
            $publish = $_DOCMAN->getCfg('user_publish');

            if ($publish == $this->userid || $publish == _DM_PERMIT_REGISTERED) {
                return true;
            }



          	if ($this->isInGroup($publish)) {
              	return true;
            }
        }
        return false; // DEFAULT: can't publish
    }

   /**
    * @desc 	Checks if the user can unpublish a document
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return	bool
    */

    function canUnPublish($doc = null)
    {
        global $_DOCMAN;

        //Make sure we have a document object
        $this->isDocument($doc);

        //make sure the document is published and is approved
        if (!$doc->published || !$doc->approved) {
            return false;
        }

        if ($this->isSpecial) {
            return true;
        }

         if ($this->userid)
         {
            $publish = $_DOCMAN->getCfg('user_publish');

            if ($publish == $this->userid || $publish == _DM_PERMIT_REGISTERED) {
                return true;
            }

          	if ($this->isInGroup($publish)) {
              	return true;
            }
        }
        return false; // DEFAULT: can't unpublish
    }

   /**
    * @desc 	checks if the user can checkout a document
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */

    function canCheckOut($doc = null)
    {
        global $_DOCMAN;

        //Make sure we have a document object
        $this->isDocument($doc);

        if ($doc->checked_out) {
            return false;
        }

        return $this->canEdit($doc);
    }

   /**
    * @desc 	Checks if the user can checkin a document
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */

    function canCheckIn($doc = null)
    {
        global $_DOCMAN;

        //Make sure we have a document object
        $this->isDocument($doc);

        if (!$doc->checked_out) {
            return false;
        }

        return $this->canEdit($doc);
    }

   /**
    * @desc 	Checks if the user can move a document
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */

    function canMove($doc = null)
    {
        global $_DOCMAN;

        //Make sure we have a document object
        $this->isDocument($doc);

        return $this->canEdit($doc);
    }

   /**
    * @desc 	Checks if the user can reset a documents hit counter
    * @param 	object $ or numeric $doc
    * @access  	public
    * @return 	bool
    */
    function canReset($doc = null)
    {
        global $_DOCMAN;

        //Make sure we have a document object
        $this->isDocument($doc);

        return $this->canEdit($doc);
    }

   /**
    * @desc 	Checks if the user can delete a document
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */

    function canDelete($doc = null)
    {
        global $_DOCMAN;

        //Make sure we have a document object
        $this->isDocument($doc);

        return $this->canEdit($doc);
    }

    /**
    * @desc 	Checks if the user can update a document
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */

    function canUpdate($doc = null)
    {
        global $_DOCMAN;

        //Make sure we have a document object
        $this->isDocument($doc);

        return $this->canEdit($doc);
    }

   /**
    * @desc 	Checks if the user can assign viewers
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */

    function canAssignViewer($doc = null)
    {
    	global $_DOCMAN;

    	//Make sure we have a document object
        $this->isDocument($doc);

        if ($this->isSpecial) {
            return true;
        }

        if ($_DOCMAN->getCfg('reader_assign') & _DM_ASSIGN_BY_AUTHOR )
        {
        	if($this->userid == $doc->dmsubmitedby) {
        		return true;
        	}
        }

        if ($_DOCMAN->getCfg('reader_assign') & _DM_ASSIGN_BY_EDITOR )
        {
        	if($this->canEdit($doc, false)) {
        		return true;
        	}
        }

        return false; // DEFAULT: can't assign viewer
    }

   /**
    * @desc 	Checks if the user can assign maintainer
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */
    function canAssignMaintainer($doc = null)
    {
    	global $_DOCMAN, $database;

    	//Make sure we have a document object
        $this->isDocument($doc);

       	if ($this->isSpecial) {
            return true;
        }

        if ($_DOCMAN->getCfg('editor_assign') & _DM_ASSIGN_BY_AUTHOR )
        {
        	if($this->userid == $doc->dmsubmitedby) {
        		return true;
        	}
        }

        if ($_DOCMAN->getCfg('editor_assign') & _DM_ASSIGN_BY_EDITOR )
        {
        	if($this->canEdit($doc, false)) {
        		return true;
        	}
        }

       	return false; // DEFAULT: can't assign maintainer
    }

    /**
    * @desc 	Checks if the user can access a category
    * @param 	mixed	object or numeric $doc
    * @access  	public
    * @return 	bool
    */
    function canAccessCategory($category = null)
    {
    	global $_DOCMAN;

    	$database = JFactory::getDBO();

    	//Make sure we have a document object
        $category = $this->isCategory($category);

        if(!$category->published AND !$this->isSpecial) {
        	return false;
        }

        switch($category->access) {
        	case '0' : //public
				return true;
        		break;
        	case '1' :	//registered
        		if($this->isRegistered) {
        			return true;
        		}
        		break;
        	break;
        	case '2' :	//special
        		if($this->isSpecial) {
        			return true;
        		}
        		break;
        	break;
        }
        return false;
    }



   /**
    * @desc 	Transform the document to a object if necessary
    * @param 	mixed	object or numeric $doc
    * @access  	private
    * @return 	object 	a document object
    */

    function isDocument(&$doc)
    {
   		$database = JFactory::getDBO();

   		// check to see if we have a object
        if (!is_a($doc, 'mosDMDocument')) {
            $id = $doc;
            // try to create a document db object
            if (is_numeric($id)) {
                $doc = new mosDMDocument($database);
                $doc->load($id);
            }
        }
    }

    /**
    * @desc 	Transform the document to a object if necessary
    * @param 	mixed	object or numeric $category
    * @access  	private
    * @return 	object 	a document object
    */

    function isCategory(&$category)
    {
   		$database = JFactory::getDBO();

        // check to see if we have a object
        if (!is_a($category, 'mosDMCategory')) {
            // try to create a category db object
            if (is_object( $category ) ){
                $id = (int) @ $category->id;
            } else {
                $id = (int) $category;
            }

            $category = & mosDMCategory::getInstance($id);
        }

        return $category;
    }

} // end class


class DOCMAN_users
{

    /**
     * Provides a list of all users
     *
     * @deprecated
     */
	function & getList()
	{
        static $users;

        if( !isset( $users ))
        {
            $database = JFactory::getDBO();
            $database->setQuery("SELECT * "
                 . "\n FROM #__users "
                 . "\n ORDER BY name ASC");
            $users = $database->loadObjectList( 'id' );
        }

        return $users;
	}

    /**
     * Get a mosUser object, caches results
     */
    function & get($id)
    {
        static $users;

        if( !isset( $users )) {
            $users = array();
        }

        if(!self::exists($id))
        {
        	// make a mock user
        	$users[$id] = new JUser;
        	$users[$id]->id = $id;
        	$users[$id]->name = JText::_('unknown');
        	$users[$id]->username = JText::_('unknown');
        }

        if( !isset( $users[$id] ))
        {
            $users[$id] = JFactory::getUser($id);
        }

        return $users[$id];
    }

    function exists($id)
    {
    	static $cache = array();
    	if(!array_key_exists($id, $cache))
    	{
    		$db = JFactory::getDBO();
    		$db->setQuery('SELECT id FROM #__users WHERE id = '.(int) $id);
    		$cache[$id] = (bool) $db->loadResult();
    	}
    	return $cache[$id];
    }
}