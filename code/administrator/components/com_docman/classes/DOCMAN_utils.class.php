<?php
/**
 * @version		$Id: DOCMAN_utils.class.php 1341 2010-04-26 16:31:08Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
* DOCMAN utils static class
*
* @desc class purpose is to handle generic utils functions
*/
// We need to spec the following this way because of mambots
require_once dirname(__FILE__) . DS.'DOCMAN_config.class.php';

class DOCMAN_Utils
{
  	function stripslashes($post)
    {
    	if(get_magic_quotes_gpc())
    	{
    		$ret = '';
			if (is_string( $post )) {
				$ret = stripslashes( $post );
			} else {
				if (is_array( $post )) {
					$ret = array();
					foreach ($post as $key => $val) {
						$ret[$key] = DOCMAN_Utils::stripslashes( $val );
					}
				} else {
					$ret = $post;
				}
			}
			return $ret;
    	}

    	return $post;
    }

	function categoryArray()
    {
    	static $array;

    	if(!isset($array))
    	{
	        global $_DMUSER;
	        $database = JFactory::getDBO();

	        // get a list of the menu items
	        $query = "SELECT c.*, c.parent_id AS parent"
	         . "\n FROM #__categories c"
	         . "\n WHERE section='com_docman'"
	         . "\n AND published AND access <= ".$_DMUSER->gid
	         . "\n ORDER BY ordering" ;

	        $database->setQuery($query);
	        $items = $database->loadObjectList();
	        // establish the hierarchy of the menu
	        $children = array();
	        // first pass - collect children
	        foreach ($items as $v) {
	            $pt = $v->parent;
	            $list = @$children[$pt] ? $children[$pt] : array();
	            array_push($list, $v);
	            $children[$pt] = $list;
	        }
	        // second pass - get an indent list of the items
	        $array = DOCMAN_Utils::mosTreeRecurse(0, '', array(), $children);

	        // making sure it's an empty array if there were no results
	        // looks silly huh?
	        $array = is_array($array) ? $array : array();

    	}

        return $array;
    }

    /**
     * @param string  $ The icon name (ex. 'zip.png')
     * @param boolean $ The path type, live (1), absolute (2)
     * @param string  $ Image size
     * @return string the icon path
     **/
    function pathIcon($icon, $type = null, $size = null )
    {
    	global $_DOCMAN;
        $icon_path = "components/com_docman/themes/". $_DOCMAN->getCfg('icon_theme') . "/images/icons/";

        // set icon size
        if (!isset($size)) {
            $icon_path .= $_DOCMAN->getCfg('icon_size') ? "32x32/" : "16x16/";
        } else {
            $icon_path .= $size . "/";
        }

        // set path type
        $path_type = '';
        switch($type)
        {
            case 1 : $path_type = JURI::root(true)."/"; ;     break;
            case 2 : $path_type = JPATH_ROOT . DS;   break;
            default : break;
        }

        // choose the icon to use, either the normal one or generic icon
        if( !file_exists(JPATH_ROOT.DS.$icon_path.$icon) ) {
            $icon = 'generic.png';
       }

        return $path_type . $icon_path . $icon;
    }

    function pathThumb($thumbnail)
    {
        $thumb_path = "images".DS."stories".DS.$thumbnail;
        return $thumb_path;
    }

    function implode_assoc($inner_glue = "=", $outer_glue = "\n", $array = null, $keepOuterKey = false)
    {
        $output = array();

        foreach($array as $key => $item)
        if (is_array ($item)) {
            if ($keepOuterKey)
                $output[] = $key;
            // This is value is an array, go and do it again!
            $output[] = implode_assoc($inner_glue, $outer_glue, $item, $keepOuterKey);
        } else
            $output[] = $key . $inner_glue . $item;

        return implode($outer_glue, $output);
    }

    function &get_object_vars($object)
    {
        $ar1 = get_class_vars(get_class($object));
        $ar2 = get_class_vars(get_parent_class($object));
        $ar = DOCMAN_Utils::array_diff_key($ar1, $ar2);

        $object_vars = new stdClass();
        foreach($ar as $key => $value)
        $object_vars->$key = $object->$key;

        return $object_vars;
    }

    function array_diff_key()
    {
        $arrays = func_get_args();
        // if only one array is given as argument, just return it
        if (count($arrays) == 1)
            return $arrays;
        elseif (count($arrays) < 1) {
            trigger_error(_DML_NOTARGGIVEN . ", " .
                count($arrays) . " given, > 1 needed", E_USER_WARNING);
            return false;
        }
        $array1 = array_shift($arrays);
        foreach ($array1 as $key => $val) {
            for ($i = 0; $i < count($arrays); $i++) {
                $array = &$arrays[$i];
                if (!is_array($array)) {
                    trigger_error(_DML_ARG . " $i " . _DML_ISNOTARRAY, E_USER_WARNING);
                    return false;
                }
                if (isset($array[$key])) {
                    unset($array1[$key]);
                }
            }
        }
        return $array1;
    }

    function taskLink($task, $gid = '', $params = null, $sef = true, $indexfile = 'index.php')
    {
        $link = DOCMAN_Utils::_rawLink($task, $gid, $params, $indexfile);
        $link = htmlspecialchars($link);

		$link = $sef ?  JRoute::_($link) : $link;
        return $link;
    }

    function returnTo($task, $msg = '', $gid = '', $params = null)
    {

        $mainframe = JFactory::getApplication();
		$link = DOCMAN_Utils::_rawLink($task, $gid, $params);

		if($link){
			$mainframe->redirect(JRoute::_($link), $msg);
		}
    }

    function _rawLink($task, $gid = '', $params = null, $indexfile = 'index.php')
    {
        global $limitstart, $limit, $Itemid;

        // This translates J1.0's index2.php system to J1.5's tmpl=component&format=raw
        if($indexfile == 'index2.php')
        {
        	$indexfile = 'index.php';
            if(!is_array($params)) {
            	$params = array();
            }
            $params['tmpl'] = 'component';
            $params['format'] = 'raw';
        }

        $link = "$indexfile?option=com_docman";

        if(!isset($params['Itemid']))
            $params['Itemid'] = $Itemid ? $Itemid : DOCMAN_Utils::getItemid();

        if (!empty($task))
            $link .= "&task=$task";
        if (!empty($gid))
            $link .= "&gid=$gid";
        if (is_array($params))
            $link .= "&" . DOCMAN_Utils::implode_assoc('=', '&', $params);

        return $link;
    }

    //  @desc returning diff in days.
    //  @args string date in format dd-mm-yyyy
    //  @return int 0 is today. positive is future
    function DaysDiff($dmdate)
    {
        $data_exp = explode("-", $dmdate);
        $Y = intval($data_exp[0]);
        $m = intval($data_exp[1]);
        $d = intval($data_exp[2]);
        $diff = ((mktime(0, 0, 0, $m, $d, $Y) - mktime(0, 0, 0, date("m"), date("d"), date("Y"))) / 86400) ;
        if (abs($diff) == $diff) // it's positive so use ceil
            $diff = ceil($diff);
        else // it's negative so use floor
            $diff = floor($diff);
        return $diff;
    }

    //  @desc Safely decode a URL that was base64 encoded.
    //  @args string that might be encoded.
    //  @return string that is clean
    function safeDecodeURL(&$url)
    {
        if (substr($url , 0 , 6) == 'SEURL_') {
            $url = base64_decode(substr($url, 6));
        }
        return $url;
    }

    function safeEncodeURL($url)
    {
        return 'SEURL_' . base64_encode($url);
    }

    function text2number($val)
    {
        $val = preg_replace( "/[^0-9KMGkmg]/", '', $val);
        $last = strtolower($val{strlen($val)-1});
        switch($last) {
            case 'g':
                $val *= 1024;
                //pass through...
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }


    // Reverse of above function.
    function number2text($value)
    {
        $index = 0;
        $pow_label = ' KMGT?';

        if (is_numeric($value) && $value > 1023) {
            while (($value % 1024) == 0) {
                $value /= 1024;
                $index++;
            }
        }
        $value = number_format($value, 0, '.', '');

        $return  = trim($value . substr(' KMGT' , $index, 1));
        return $return;
    }

    //  @desc Translate the numeric ID to a character string
	//  @param integer $ The numeric ID of the user
	//  @return string Contains the user name in string format
	function getUserName($userid)
	{
 		$database = JFactory::getDBO();

   		switch ($userid)
   		{
     		case _DM_PERMIT_EDITOR:
     			return _DML_GROUP_EDITOR;
     			break;
     		case _DM_PERMIT_AUTHOR:
     			return _DML_GROUP_AUTHOR;
     			break;
     		case _DM_PERMIT_PUBLISHER:
     			return _DML_GROUP_PUBLISHER;
     			break;
     		case _DM_PERMIT_EVERYBODY:
        		return _DML_EVERYBODY;
           		break;
     		case _DM_PERMIT_REGISTERED:
         		return _DML_ALL_REGISTERED;
           		break;
            case _DM_PERMIT_CREATOR:
                return _DML_CREATOR;
                break;

       		default:

          		if ($userid > '0')
           		{
                    $user = & DOCMAN_users::get($userid);
                    return $user->username;
          		}

				if($userid < '-5')
				{
      				$calcgroups = (abs($userid) - 10);
                    $group = & DOCMAN_groups::get($calcgroups);
        			return $group->groups_name;
				}
            	break;
   		}

   		return '*'._DML_UNKNOWN.'*';
	}

	function checkDomainAuthorization()
	{
		global $_DOCMAN;

		if(!$_DOCMAN->getCfg('security_anti_leech')) {
			return true;
		}

		$this_url = parse_url(JURI::root());
        $this_host = trim($this_url['host']);

        if (isset($_SERVER['HTTP_REFERER'])) {
        	$from_url = parse_url($_SERVER['HTTP_REFERER']);
        	$from_host = trim($from_url['host']);
		}
	    else {
			$from_host = "";
	    }

        // Determine if they are local. They must:
        // 	1. match the defined server string
        //  2. match the local address or have 'localhost' as their hostname.
        // The last one is unlikely, but this will catch any case at all.
		// If $from_host (remote) is empty, it's considered local, too.

        if ( empty($from_host) || strcasecmp($this_host, $from_host) == 0 ||
				strcasecmp('127.0.0.1', $from_host) == 0 ||	strcasecmp('localhost', $from_host) == 0 )
		{
            $localhost = true;
        }
		else
		{
			$localhost = false;
		}

		$allowed = false;

        // If the connection is NOT local, check if the remote host is allowed.
        if ( !$localhost )
		{
			$allowed_hosts = explode('|',$_DOCMAN->getCfg('security_allowed_hosts'));

			//  If the $allowed_hosts list is empty, the remote host is not allowed by default.
			if ( count($allowed_hosts > 0) )
			{
				foreach ( $allowed_hosts as $allowed_host )
				{
					$allowed_host = DOCMAN_Utils::wild2regular(trim($allowed_host));
					if ( strlen($allowed_host) == 0 ) continue;
					$allowed_host .= 'i'; // make pattern case-insensitive
					if ( preg_match($allowed_host, $from_host)) {
						$allowed = true;
						break;
					}
				}
			}
		}

		return $localhost || $allowed;
	}

	function wild2regular($pattern)
	{
		if ( strlen($pattern) == 0 ) {
			return $pattern;
		}

		$pattern = preg_quote($pattern);
		$pattern = str_replace('/','\/',$pattern);
		$pattern = str_replace('\*','\w*',$pattern);
		$pattern = str_replace('\?','\w',$pattern);
		$pattern = '/'.$pattern.'/';

		return $pattern;
	}


    function processContentBots( & $doc, $field = 'description' )
    {
         global $_DOCMAN;

        $application = JFactory::getApplication();

        if(!$_DOCMAN->getCfg('process_bots', 0)) {
            return;
        }

        // initialize objects
        $params     = new JParameter( '' ); // fake params
        $row        = new stdClass();

        // get data from object
        $dataObj    = & $doc->getDataObject();
        $row->text  = & $dataObj->$field;

        JPluginHelper::importPlugin( 'content' );
        $results = $application->triggerEvent( 'onPrepareContent', array($row, $params, 0 ), true );
    }

    /**
     * Does the browser support PNG Alpha transparency?
     */
    function supportPng()
    {
        global $_DOCMAN;
        require_once $_DOCMAN->getPath('classes', 'jbrowser');
        $browser = & JBrowser::getInstance();
        return !$browser->getQuirk('png_transparency');
    }

    /**
     * Substr replacement, doesn't break words in the middle
     */
    function snippet($text,$length=200,$tail="(...)")
    {
       $text = trim($text);
       $txtl = strlen($text);
       if($txtl > $length) {
           for($i=1;$text[$length-$i]!=" ";$i++) {
               if($i == $length) {
                   return substr($text,0,$length) . $tail;
               }
           }
           $text = substr($text,0,$length-$i+1) . $tail;
       }
       return $text;
    }

    /**
     * Snips an string in the middle eg http://www.mysite(...)/myfile.zip
     */
    function urlSnippet($text,$length=60,$tail="(...)")
    {
        $text = trim($text);
        $txtl = strlen($text);
        if($txtl > $length) {
            $snip = floor(($length-strlen($tail)) / 2);
            $text = substr($text, 0, $snip) . $tail . substr($text, -$snip, $snip);
        }
        return $text;
    }

    /**
     * Custom tooltip method
     *
     * When no href ( or '#') is given, the icon will become a link to a js alert box
     */
    function mosToolTip( $tooltip, $title='', $width='', $image='tooltip.png', $text='', $href='#', $link=1  )
    {
        JHTML::_('behavior.tooltip');

    	if ( $href=='#' OR $href=='')
        {
            $alert = strip_tags(DOCMAN_Utils::br2nl($tooltip));
        	$href="javascript:alert('".$alert."');";
        }
    	return JHTML::_('tooltip', $tooltip, $title, $image, $text, $href, $link );
    }

    function br2nl($text)
    {
       $text = str_replace("<br />","\\n",$text);
       $text = str_replace("<br>","\\n",$text);
       return $text;
   }

    /**
     * Get DOCman's Itemid
     * We can't use global $Itemid because this class can be used outside of
     * docman
     */
    function getItemid( $component='com_docman')
    {
    	static $ids;
        if( !isset($ids) ) {
        	$ids = array();
		}

        if( !isset($ids[$component]) )
		{
        	$database = JFactory::getDBO();
            $query = "SELECT id FROM #__menu"
                    ."\n WHERE link LIKE '%option=$component%'"
                    ."\n AND type = 'component'"
                    ."\n AND published = 1";
            $database->setQuery($query, 0, 1);
            $ids[$component] = $database->loadResult();
				}
        return $ids[$component];
			}

    /**
     * Joomla 1.0's mosTreeRecurse for backward compat in 1.5
     */
    function mosTreeRecurse( $id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type=1 )
    {
        if (@$children[$id] && $level <= $maxlevel)
        {
            foreach ($children[$id] as $v) {
                $id = $v->id;

                if ( $type ) {
                    $pre    = '<sup>|_</sup>&nbsp;';
                    $spacer = '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                } else {
                    $pre    = '- ';
                    $spacer = '&nbsp;&nbsp;';
                }

                if ( $v->parent == 0 ) {
                    $txt    = $v->name;
                } else {
                    $txt    = $pre . $v->name;
                }
                $pt = $v->parent;
                $list[$id] = $v;
                $list[$id]->treename = "$indent$txt";
                $list[$id]->children = count( @$children[$id] );

                $list = DOCMAN_Utils::mosTreeRecurse( $id, $indent . $spacer, $list, $children, $maxlevel, $level+1, $type );
            }
        }
        return $list;
    }


    /**
     * Calculate the maximum upload size from php.ini
     *
     * @return int
     */
	public static function getMaxUploadSize()
	{
		$sysUploadMax	= DOCMAN_Utils::text2number(ini_get('upload_max_filesize'));
		$sysPostMax 	= DOCMAN_Utils::text2number(ini_get('post_max_size'));
    	return  min($sysUploadMax , $sysPostMax);
	}
}

/**
* DOCMAN document utils static class
*
* @desc class purpose is to handle generic utils functions
*/
class DOCMAN_Cats
{
    /**
    *
    * @desc This function selects every child category
    * 		from a parent category by user access level
    * @param object $ the user object
    * @param int $ the parent id category
    * @param string $ the ordering query
    * @returns array a db object with category rows
    */
    function getChildsByUserAccess($parent_id = 0, $ordering = "ordering ASC", $userID = null)
    {
        global $_DOCMAN;

        $database = JFactory::getDBO();

        if (! $userID) {
            $user = $_DOCMAN->getUser();
        } else {
            $user = &$userID;
        }

        $query = "SELECT * FROM #__categories "
         . "\n WHERE section = 'com_docman'"
         . "\n   AND published = 1 "
         . "\n   AND parent_id=". (int) $parent_id ." AND ";

        if($user->userid) {
        	if($user->isSpecial) {
        		$query .= "(access=0 OR access=1 OR access=2)";
        	} else {
        		$query .= "(access=0 OR access=1)";
        	}
        } else {
        	$query .= "access=0";
        }

        $query .= " ORDER BY " . $ordering;
        $database->setQuery($query);
        $childs = $database->loadObjectList();
        return $childs;
    }

    // -- Dirty solution - Arrays needs to be merged.
    function countDocsInCatByUser($catid, $user, $include_childs = false)
    {
        global $_DOCMAN;

        $database = JFactory::getDBO();

        /*
         * -- Count the documents per category --
         */

        $query = "SELECT catid, count( d.id ) AS count "
         . "\n FROM #__docman AS d";

        if (!$user->userid/*&& !$_DOCMAN->getCfg('registered')*/) {
            $query .= "\n   WHERE dmowner=" . _DM_PERMIT_EVERYONE
             . "\n   AND d.published=1 "
             . "\n   AND d.approved=1";
        } elseif ($user->isSpecial) {
           $query .= " ";
        } elseif ($user->canApprove()) {
        	$query .= " ";
        } elseif ($user->canPublish()) {
        	 $query .= "\n WHERE d.approved=1";
        } elseif ($user->userid) {
            $query .= "\n WHERE (dmowner=" . $user->userid
             . "\n OR dmmantainedby=" . $user->userid
             . "\n OR dmowner=" . _DM_PERMIT_EVERYONE
             . "\n OR dmowner=" . _DM_PERMIT_REGISTERED;
            if ($user->groupsIn != '0,0') {
                $query .= "\n OR dmowner IN (" . $user->groupsIn . ")";
            }
            $query .= "\n)";
            $query .= "\n  AND d.published=1"
             . "\n  AND d.approved=1";
        }
        $query .= "\n GROUP BY d.catid";

        // Performance: each query should only be executed once
        static $docresults = array();
        if( !isset( $docresults[$query])) {
            $database->setQuery($query);
            $docresults[$query] = $database->loadObjectList('catid');
        }
        $docs = & $docresults[$query];




        /*
         * -- Get a category hierarchy --
         */
        // Performance: query should only be executed once
        static $cats;
        if( !isset($cats)) {
            $query = "SELECT c.id, c.parent_id AS parent"
             . "\n FROM #__categories AS c"
             . "\n WHERE section='com_docman'"
             . "\n AND published <> -2"
             . "\n ORDER BY ordering" ;
            $database->setQuery($query);
            $cats = $database->loadObjectList();
        }

        $total = 0;
        if ($include_childs) {
            DOCMAN_Cats::countDocsInCatRecurse($catid, $cats, $docs, $total);
        }

        if (isset($docs[$catid])) {
            $total += $docs[$catid]->count;
        }

        return $total;
    }

    function countDocsInCatRecurse($id, &$cats, &$docs, &$total)
    {
        $i = 0;
        $size = count($cats);
        for($i; $i < $size; $i++) {
            if ($cats[$i]->parent == $id) {
                $new_id = $cats[$i]->id;
                if (isset($docs[$new_id])) {
                    $total += $docs[$new_id]->count;
                }
                DOCMAN_Cats::countDocsInCatRecurse($new_id, $cats, $docs, $total);
            }
        }
    }

    function & getAncestors($id)
    {
        $database = JFactory::getDBO();
        static $results = array();

        if( !isset( $results[$id] ) ) {
            // get a category hierarchy
            $query = "SELECT id, name, title, parent_id AS parent"
             . "\n FROM #__categories"
             . "\n WHERE section='com_docman'"
             . "\n AND published <> -2"
             . "\n ORDER BY ordering" ;
            $database->setQuery($query);
            $cats = $database->loadObjectList('id');
            if($err = $database->getErrorMsg()) {
            	throw new Exception($err);
            }

            $arAncestors = array();
            DOCMAN_Cats::getAncestorsRecurse($id, $cats, $arAncestors);
            $results[$id] = $arAncestors;
        }
        return $results[$id];
    }

    function getAncestorsRecurse($id, &$cats, &$ancestors)
    {
        $cat = new StdClass();
        $cat->name  = $cats[$id]->name;
        $cat->title = $cats[$id]->title;
        $sef =  false;
        $cat->link = DOCMAN_Utils::taskLink('cat_view', $id, null, $sef);
        $ancestors[] = &$cat;

        $id = $cats[$id]->parent;
        if ($id != 0) {
            DOCMAN_Cats::getAncestorsRecurse($id, $cats, $ancestors);
        }
    }

    /**
     * Returns an array of category objects with their id as key
     */
    function & getCategoryList()
    {
    	static $list;

        if( !isset($list) )
        {
        	$database = JFactory::getDBO();
            $database->setQuery( "SELECT * FROM #__categories" .
                                "\n WHERE section = 'com_docman'" );
            $list = $database->loadObjectList( 'id' );

        }
        return $list;
    }
}

class DOCMAN_Docs
{
    /**
    *
    * @desc This function selects every documents in a category
    * 		by user access level
    * @param mixed $catid Integer or comma separated string of catids
    * @param int $ the category id
    * @param string $ the ordering query
    */
    function getDocsByUserAccess($catid = 0, $ordering = '', $direction = '', $limit = '', $limitstart = 0)
    {
        global $_DOCMAN;

        $database = JFactory::getDBO();

        $user = $_DOCMAN->getUser();
        // get ordering
        $ordering = trim($ordering);
        if ($ordering == '')
            $ordering = $_DOCMAN->getCfg('default_order');

        switch ($ordering) {
            case 'name' : $ordering = 'd.dmname';
                break;
            case 'date' : $ordering = 'd.dmdate_published';
                break;
            case 'hits' : $ordering = 'd.dmcounter';
                break;
            default :
                $ordering = 'd.dmname';
        }
        // get direction
        $direction = (string) strtoupper(trim($direction));
        if ($direction == '') {
            $direction = $_DOCMAN->getCfg('default_order2');
        }
        if(!in_array($direction, array('ASC', 'DESC')) ) {
        	$direction = 'ASC';
        }

        // get limit
        if ($limit == '') {
            $limit = $_DOCMAN->getCfg('perpage');
        }
        // preform query
        $query = "SELECT d.*, c.title AS cat_title FROM #__docman AS d"
        	. "\n LEFT JOIN #__categories AS c ON d.catid = c.id ";

         if (!$user->userid)
         {
         	if(!$_DOCMAN->getCfg('registered')) {
         		return array();
         	}

            $query .= "WHERE d.dmowner=" . _DM_PERMIT_EVERYONE
                 . "\n AND d.published=1 AND d.approved=1";

           	$query .= $catid ? "\n AND d.catid IN ($catid) " : "";

        }
        else
       	{
        	if ($user->isSpecial) {
        		 $query .= $catid ? "\n WHERE d.catid IN ($catid) " : "";
        	} elseif ($user->canApprove()) {
        		$query .= $catid ? "\n WHERE d.catid IN ($catid) " : "";
        	} elseif ($user->canPublish()) {
        	 	$query .= "WHERE d.approved=1";
        	 	$query .= $catid ? "\n AND d.catid IN ($catid) " : "";
        	} elseif ($user->userid) {
            	$query .= "WHERE d.published=1 AND d.approved=1"
             		. "\n AND (d.dmowner=" . $user->userid
             	 	. "\n OR d.dmmantainedby=" . $user->userid
             	 	. "\n OR d.dmowner=" . _DM_PERMIT_EVERYONE
             	 	. "\n OR d.dmowner=" . _DM_PERMIT_REGISTERED;
           	 	if ($user->groupsIn != '0,0') {
                	$query .= "\n OR d.dmowner IN (" . $user->groupsIn . ")";
                	$query .= "\n OR d.dmmantainedby IN (" . $user->groupsIn . ")";
           		}
            	if ($_DOCMAN->getCfg('author_can') != _DM_AUTHOR_NONE) {
                	$query .= "\n OR d.dmsubmitedby = " . $user->userid;
            	}
            	$query .= ")";

            	$query .= $catid ? "\n AND d.catid IN ($catid) " : "";
        	}
         }

        $query .= "\n ORDER BY $ordering $direction";
        $database->setQuery($query, $limitstart, $limit);

        return $database->loadObjectList();
    }

    function getFilesByUserAccess($extra_files = null)
    {
        global $_DOCMAN, $_DMUSER;

        $database = JFactory::getDBO();

        if (! $_DMUSER->userid) {
            return null;
        }

        $doq = false;
        // perform query
        $query = "SELECT * FROM #__docman "
         . "\n WHERE "
         . "\n    ( ";

        $where = '';
        if (! $_DMUSER->isSpecial) {
            $doq = true;
            $where .= "\n  dmsubmitedby=" . $_DMUSER->userid . "\n  ";
        }
        if ($extra_files) {
            if ($doq) {
                $query .= "  OR " ;
            }
            if (is_array($extra_files)) {
                $where .= "dmfilename in ( '" . implode("','", $extra_files) . "')\n  ";
            } else {
                $doq = true;
                $where .= "dmfilename = '" . $extra_files . "'\n  ";
            }
        }

        if ($where == '') {
            return array();
        }

        $query .= $where;
        $query .= "  )"
         . "\n ORDER BY dmfilename";

        $database->setQuery($query);

        return $database->loadObjectList();
    }

    /**
    *
    * @desc This function performs a generic search
    * 		against the database. Originaly from the mambot
    * 		but enhanced for wider searches
    * @param array $ of arrays $searchArray The lists of what to search for
    * 		i.e.: array( array( 'phrase'=>'search phrases', mode=>'exact'),
    * 			         array( 'phrase=>'.....
    * 		Currently only uses the FIRST array request. (FUTURE: multiples)
    * @param string $ The ordering of the results (newest...etc).
    * 		Prefix with a '-' to reverse the ordering.
    * @param int $ the categories to search for (0=all)
    * @param mixed $ Either an array of terms to return or '*'
    * 		(Array is 'column-name' => 'return name'.)
    * @param array $ List of options for searching
    *
    * NOTE: We are NOT assured that we have $_DOCMAN and all the other goodies.
    * 	    (we may be just from mambot)
    */
    function search(&$searchArray, $ordering = '', $cats = '', array $columns = array(), $options = array())
    {
        global $_DOCMAN;

        $my = JFactory::getUser();

        $database = JFactory::getDBO();
        $_DMUSER = $_DOCMAN->getUser();

        $searchterms = array_pop($searchArray); // Only do one (for now)
        if ( empty($options) ) {
            $options = array('search_name', 'search_description');
        }

        if($ordering == '') {
        	$ordering = 'newest';
        }

        $registered = $_DOCMAN->getCfg('registered');
        $perpage = $_DOCMAN->getCfg('perpage');
        $authorCan = $_DOCMAN->getCfg('author_can', '9999');

        $userid = intval($my->id);

        $isAdmin = $_DMUSER->isAdmin;


        // -------------------------------------
        // Fetch the search options. Passed in options array
        // -------------------------------------
        $search_col = array();
        if (is_array($options)) {
            if (in_array('search_name', $options)) {
                $search_col[] = 'DM.dmname ';
            }
            if (in_array('search_description', $options) || in_array('search_desc', $options)) {
                $search_col[] = 'DM.dmdescription ';
            }
            if (in_array('search_cat' , $options)) {
                $search_col[] = "CAT.title ";
                $search_col[] = "CAT.name ";
                $search_col[] = "SUB.title ";
                $search_col[] = "SUB.name ";
            }
        }

        if (count($search_col) == 0) {
            return array(); // Have to search SOMETHING!
        }
        // BUILD QUERY PARTS
        $search_mode = $searchterms['search_mode'];
        $text = trim($searchterms['search_phrase']);

        if (! $text) {
            return array();
        }
        // (1) Format search 'phrase' into SQL
        $invert = false;
        if (substr($search_mode , 0 , 1) == '-') {
            $invert = true;
            $search_mode = substr($search_mode, 1);
        }

        $wheres = array();
        switch ($search_mode) {
            case 'exact':
                foreach($search_col as $col) {
                    $wheres[] = $col . "LIKE '%$text%'";
                }

                $where = '(' . implode(') OR (' , $wheres) . ')';
                break;

            case 'any': // Fall through for regex
                $text = implode('|', explode(' ', $text));

            case 'regex':
                foreach($search_col as $col) {
                    $wheres[] = $col . "RLIKE '$text'";
                }

                $where = '(' . implode(' OR ' , $wheres) . ')';
                break;

            case 'all':
            default:
                $words = explode(' ', $text);
                foreach($search_col as $col) {
                    $wheres2 = array();
                    foreach ($words as $word) {
                        $wheres2[] = $col . "LIKE '%$word%'";
                    }

                    $wheres[] = implode(' AND ' , $wheres2) ;
                }
                $where = '(' . implode(') OR (', $wheres) . ')';
                break;
        }
        if ($invert) {
            $where = 'NOT ( ' . $where . ')';
        }
        // DEBUG:
        // echo "<pre>WHERE is: $where</pre>";
        // (2) Create the 'ORDER BY' section based on user request
        $_DM_SEARCH_SORT_ORDER = array(
            'newest' => 'DM.dmlastupdateon DDD',
            'oldest' => 'DM.dmlastupdateon AAA',
            'popular' => 'DM.dmcounter DDD',
            'alpha' => 'DM.dmname AAA',
            'category' => 'CAT.title AAA, SUB.title AAA, DM.dmname AAA'
            );
        $_DM_SEARCH_PATTERN = array('/DDD/', '/AAA/');
        $invert = false;
        if (substr($ordering , 0 , 1) == '-') {
            $ordering = substr($ordering, 1);
            $invert = true;
        }

        $order = $_DM_SEARCH_SORT_ORDER[$ordering ];


        if ($invert) {
            $order = preg_replace($_DM_SEARCH_PATTERN ,
                array('ASC' , 'DESC') , $order);
        } else {
            $order = preg_replace($_DM_SEARCH_PATTERN ,
                array('DESC' , 'ASC') , $order);
        }
        // (3) SQL WHERE portion based on user access priviledges
        if ($isAdmin) {
            $user_filter = " (SUB.access=" . _DM_ACCESS_PUBLIC . " OR   SUB.access=" . _DM_ACCESS_REGISTERED . ")" ;
        } else {
            if ($userid > 0) { // Logged IN
                $user_groups = DOCMAN_Docs::_dmCheckGroupsUserIn();
                $user_filter = "("
                 . "\n    DM.dmowner=" . _DM_PERMIT_EVERYONE
                 . "\n OR DM.dmowner=" . _DM_PERMIT_REGISTERED
                 . "\n OR DM.dmowner=" . $userid
                 . "\n OR DM.dmowner IN ($user_groups) "
                 . "\n OR DM.dmmantainedby=" . $userid
                 . "\n OR DM.dmmantainedby IN ($user_groups) " ;
                if ($authorCan > 0) {
                    $user_filter .= "\n OR DM.dmsubmitedby = $userid";
                }
                $user_filter .= ")"
                 . "\n AND (SUB.access=" . _DM_ACCESS_PUBLIC
                 . "\n OR   SUB.access=" . _DM_ACCESS_REGISTERED . ")" ;
            } else { // NOT logged in
                $user_filter = " DM.dmowner=" . _DM_PERMIT_EVERYONE
                 . "\n AND SUB.access=" . _DM_ACCESS_PUBLIC;
            } // endif $userid
        } // endif isAdmin
        // (4)Build up the category list (if they selected it)

        if ($cats != '' && $cats != 0) {
            $user_filter .= "\n AND DM.catid ";
            if (is_array($cats)) {
                $user_filter .= 'IN (' . implode(',' , $cats) . ')';
            } else {
                $user_filter .= "= $cats";
            }
        }

        // (5) Build up list of columns to return
        $list = array();
		foreach($columns as $key => $value) {
			$list[] = "\n\t$key  AS $value";
		}
		if(!count($list)) {
			$list[] = "\n\t*";
		}
		$list_terms = implode(',' , $list);
        $list_terms .= strlen($list_terms) ? ', ':'';
        $list_terms .= 'DM.* , DM.catid AS docman_catid';

        // (*) Build final query for SQL lookup
        $query = "SELECT $list_terms "
         . "\nFROM #__docman AS DM "
         . "\nLEFT JOIN #__categories AS SUB ON SUB.id = DM.catid"
         . "\nLEFT JOIN #__categories AS CAT ON CAT.id = SUB.parent_id"
         . "\nWHERE $user_filter "
         . "\n  AND DM.published=1 AND DM.approved=1"
         . "\n  AND ($where) "
         . "\nORDER BY $order";

        // TODO: add proper pagination instead of hardcoded limit?
        $database->setQuery($query, 0, 20);
        $rows = $database->loadObjectList();


        $cache = array(); // Fill in the correct sections
        for($r = 0; $r < count($rows); $r++) {
            $rows[$r]->section = @$options['section_prefix']
                        .DOCMAN_Docs::_dmSearchSection($rows[$r]->catid, $cache , '/')
                        .@$options['section_suffix'];
        }


        // FINAL SORT:
        // We couldn't sort by category until now (we didn't HAVE a category)
        if ($order == 'category') {
            if ($invert) {
                usort($rows , create_function("$a,$b","return strcasecmp($a->section . $a->dmname , $b->section . $b->dmname);"));
            } else {
                usort($rows , create_function("$a,$b","return strcasecmp($b->section . $b->dmname , $a->section . $a->dmname);"));
            }
        }
        return $rows;
    }
 /*
 * This is a similar to a routine docman.php but I've moved the id check to the
 * database SQL and altered the string build operation
 */

    function _dmCheckGroupsUserIn()
    {
        $database = JFactory::getDBO();
        $my       = JFactory::getUser();

        $this_user = intval($my->id);
        $prefix = '';

        $query = "SELECT groups_id " . "FROM   #__docman_groups " . "WHERE  groups_members REGEXP '(^|[^0-9])0*$this_user([^0-9]|$)'" ;
        $database->setQuery($query);
        $all_groups = $database->loadObjectList();

        $user_groups = '';
        if (count($all_groups)) {
            foreach ($all_groups as $a_group) {
                $user_groups .= $prefix . trim((-1 * $a_group->groups_id)-10);
                $prefix = ',';
            }
        }
        if ($user_groups == '')
            return("0,0");

        return ($user_groups);
    }

    function _dmSearchSection($id , &$cache , $sep)
    {
        $database = JFactory::getDBO();

        if (! $id) return "";
        if ( isset($cache[ $id ]) ) return $cache[ $id ];

        // Find it...
        $query = "SELECT parent_id, name FROM #__categories WHERE id = ". (int) $id;
        $database->setQuery($query);
        $row = $database->loadObjectList();
        if (count($row)) {
            if ($row[0]->parent_id) {
                $cache[ $id ] = DOCMAN_Docs::_dmSearchSection($row[0]->parent_id, $cache, $sep) . $sep . $row[0]->name ;
            } else {
                $cache[ $id ] = $row[0]->name;
            }
        }
        return $cache[ $id ];
    }
}

class DOCMAN_Menus
{
	/*
	 * Return a list of all menu items pointing to docman, with docman cat id => menu item
	 */
	public static function getList()
	{
		static $list;

		$database = JFactory::getDBO();

		if(!isset($list))
		{
			$list = array();
			$query = "SELECT id, link, params FROM #__menu"
                    ."\n WHERE link LIKE '%option=com_docman%'"
                    ."\n AND type = 'component'"
                    ."\n AND published = 1";
            $database->setQuery($query);
            foreach($database->loadObjectList() as $item)
            {
            	$item->params = new JParameter($item->params);
            	$list[$item->params->get('cat_id', 0)] = $item->id;
            }
		}

		return $list;
	}
}