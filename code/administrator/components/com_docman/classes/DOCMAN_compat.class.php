<?php
/**
 * @version		$Id: DOCMAN_compat.class.php 1302 2010-03-05 12:46:43Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class DOCMAN_Compat 
{
    function mosLoadAdminModules( $position='left', $style=0 ) 
    {
		jimport('joomla.html.pane');
    	$modules    =& JModuleHelper::getModules($position);
        $pane       =& JPane::getInstance('sliders');
        echo $pane->startPane("content-pane");

        foreach ($modules as $module) 
        {
            $title = $module->title ;
            echo $pane->startPanel( $title, "$position-panel" );
            echo JModuleHelper::renderModule($module);
            echo $pane->endPanel();
        }

        echo $pane->endPane();
    }

    function mosReadDirectory($path, $filter='.', $recurse=false, $fullpath=false) 
    {
        $arr = array();
        if (!@is_dir( $path )) {
            return $arr;
        }
        $handle = opendir( $path );

        while ($file = readdir($handle)) {
            $dir = DOCMAN_Compat::mosPathName( $path.'/'.$file, false );
            $isDir = is_dir( $dir );
            if (($file != ".") && ($file != "..")) {
                if (preg_match( "/$filter/", $file )) {
                    if ($fullpath) {
                        $arr[] = trim( DOCMAN_Compat::mosPathName( $path.'/'.$file, false ) );
                    } else {
                        $arr[] = trim( $file );
                    }
                }
                if ($recurse && $isDir) {
                    $arr2 = DOCMAN_Compat::mosReadDirectory( $dir, $filter, $recurse, $fullpath );
                    $arr = array_merge( $arr, $arr2 );
                }
            }
        }
        closedir($handle);
        asort($arr);
        return $arr;
    }
    
	function mosPathName($p_path, $p_addtrailingslash = true)
	{
		jimport('joomla.filesystem.path');
		$path = JPath::clean($p_path);
		if ($p_addtrailingslash) {
			$path = rtrim($path, DS) . DS;
		}
		return $path;
	}

    function editorArea($areaname, $content, $name, $width, $height, $rows, $cols) 
    {
        $editor =& JFactory::getEditor();

        // JEditor::display( $name,  $html,  $width,  $height,  $col,  $row, [ $buttons = true])
        echo $editor->display($name, $content, $width, $height, $rows, $cols, array('pagebreak', 'readmore')) ;
    }

    // Add the Calendar includes to the document <head> section
    function calendarJS() {
        JHTML::_('behavior.calendar');
    }

    function calendar($name, $value) 
    {
    	JHTML::_('behavior.calendar'); //load the calendar behavior

		$format	= '%Y-%m-%d';
		$class	= 'inputbox';
		$id   	= $name;

		echo JHTML::_('calendar', $value, $name, $id, $format, array('class' => $class));
    }

    /**
     * Removes illegal tags and attributes from html input
     */
    function inputFilter($html)
    {
        // Replaced code to fix issue with img tags
        jimport('phpinputfilter.inputfilter');
        $filter = new InputFilter(array(), array(), 1, 1);
        return $filter->process( $html );
    }
    
	function sefRelToAbs($value)
	{
		// Replace all &amp; with & as the router doesn't understand &amp;
		$url = str_replace('&amp;', '&', $value);
		if(substr(strtolower($url),0,9) != "index.php") return $url;
		$uri    = JURI::getInstance();
		$prefix = $uri->toString(array('scheme', 'host', 'port'));
		return $prefix.JRoute::_($url);
	}
}

jimport('joomla.html.pagination');
/**
 * Overridden class that drops the infernal 'all' option from the limitbox, to prevent
 * memory overloads
 */	
class DOCMAN_Pagination extends JPagination
{
	function __construct($total, $limitstart, $limit)
	{
		if($limit == 0 || $limit > 100) {
			$limit = 100;
		}
		parent::__construct($total, $limitstart, $limit);
	}
	
	function getLimitBox()
	{
		global $mainframe;

		// Initialize variables
		$limits = array ();

		// Make the option list
		for ($i = 5; $i <= 30; $i += 5) {
			$limits[] = JHTML::_('select.option', "$i");
		}
		$limits[] = JHTML::_('select.option', '50');
		$limits[] = JHTML::_('select.option', '100');

		$selected = $this->_viewall ? 0 : $this->limit;

		// Build the select list
		if ($mainframe->isAdmin()) {
			$html = JHTML::_('select.genericlist',  $limits, 'limit', 'class="inputbox" size="1" onchange="submitform();"', 'value', 'text', $selected);
		} else {
			$html = JHTML::_('select.genericlist',  $limits, 'limit', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $selected);
		}
		return $html;
	}

	
	function writeLimitBox($link = null) {
		echo $this->getLimitBox();
	}

	function writePagesCounter() {
		return $this->getPagesCounter();
	}	

	function writePagesLinks($link = null) {
		return $this->getPagesLinks();
	}
	
	function writeLeafsCounter() {
		return $this->getPagesCounter();
	}
	
	
	function rowNumber($index) {
		return $index +1 + $this->limitstart;
	}
	
	function orderUpIcon2($id, $order, $condition = true, $task = 'orderup', $alt = '#')
	{
		// handling of default value
		if ($alt = '#') {
			$alt = JText::_('Move Up');
		}

		if ($order == 0) {
			$img = 'uparrow0.png';
		} else {
			if ($order < 0) {
				$img = 'uparrow-1.png';
			} else {
				$img = 'uparrow.png';
			}
		}
		$output = '<a href="javascript:void listItemTask(\'cb'.$id.'\',\'orderup\')" title="'.$alt.'">';
		$output .= '<img src="images/'.$img.'" width="16" height="16" border="0" alt="'.$alt.'" title="'.$alt.'" /></a>';

		return $output;
	}

	function orderDownIcon2($id, $order, $condition = true, $task = 'orderdown', $alt = '#')
	{
		// handling of default value
		if ($alt = '#') {
			$alt = JText::_('Move Down');
		}

		if ($order == 0) {
			$img = 'downarrow0.png';
		} else {
			if ($order < 0) {
				$img = 'downarrow-1.png';
			} else {
				$img = 'downarrow.png';
			}
		}
		$output = '<a href="javascript:void listItemTask(\'cb'.$id.'\',\'orderdown\')" title="'.$alt.'">';
		$output .= '<img src="images/'.$img.'" width="16" height="16" border="0" alt="'.$alt.'" title="'.$alt.'" /></a>';

		return $output;
	}
} 