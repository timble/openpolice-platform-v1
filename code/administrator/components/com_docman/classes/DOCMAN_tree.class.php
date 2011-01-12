<?php
/**
 * @version		$Id: DOCMAN_tree.class.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_LIBRARIES . DS.'domit'.DS.'xml_domit_lite_include.php' );

/**
* DOCMAN tree  class.
*
* @desc class purpose is to handle operations with categories trees.
*/

class DOCMAN_Tree
{
    var $xmldoc = null; //the generated xml document
    function DOCMAN_Tree()
    {
        // create domit document
        $this->xmldoc = new DOMIT_Document();
        // generate database data
        $dbdata = $this->createData();
        // generate xml document
        $xmldata = "<?xml version=\"1.0\"?>\n";
        $xmldata .= "<!DOCTYPE tree SYSTEM \"tree.dtd\">\n";
        $xmldata .= "<tree>";
        $xmldata .= $this->transformToXML(0, $dbdata, 0);
        $xmldata .= "</tree>";
        $this->xmldoc->parseXML($xmldata, true);
    }

    function getXMLDoc()
    {
        return $this->xmldoc;
    }

    function getText()
    {
        return $this->xmldoc->toString();
    }

    function getNormalizedText()
    {
        return $this->xmldoc->toNormalizedString();
    }

    function saveAsXML($fileName)
    {
        $success = $this->xmldoc->saveXML($fileName);
        return $success;
    }

    function saveAsText($fileName)
    {
        $success = $this->xmldoc->saveTextToFile($fileName, $this->xmldoc->toNormalizedString());
        return $success;
    }

    function createData()
    {
        $my       = JFactory::getUser();
        $database = JFactory::getDBO();

        /* If a user has signed in, get their user type */
        $intUserType = 0;

        if ($my->gid) {
            switch ($my->usertype) {
                case 'Super Administrator':
                    $intUserType = 0;
                    break;
                case 'Administrator':
                    $intUserType = 1;
                    break;
                case 'Editor':
                    $intUserType = 2;
                    break;
                case 'Registered':
                    $intUserType = 3;
                    break;
                case 'Author':
                    $intUserType = 4;
                    break;
                case 'Publisher':
                    $intUserType = 5;
                    break;
                case 'Manager':
                    $intUserType = 6;
                    break;
            }
        } else {
            /* user isn't logged in so make their usertype 0 */
            $intUserType = 0;
        }

    	$sql = "\n SELECT id, parent_id, title AS text FROM #__categories";
      	$sql .= "\n WHERE section='com_docman' AND published=1 AND access <= $my->gid";
     	$sql .= "\n ORDER BY parent_id,ordering";

        $database->setQuery($sql);

        $rows = $database->loadObjectList('id');
        echo $database->getErrorMsg();
        // establish the hierarchy of the menu
        $data = array();
        // get children
        foreach ($rows as $row)
        {
            // generated valid xml link
            $parent_id = $row->parent_id;
            $list = @$data[$parent_id] ? $data[$parent_id] : array();
            array_push($list, $row);
            $data[$parent_id] = $list;
        }

        return $data;
    }

    function transformToXML($id, &$data, $level = 0)
    {
        // $xml = "<tree sublevel=\"$level\">";
        $xml = '';

        if (@$data[$id]) {
            foreach ($data[$id] as $row) {
                $xml .= "<tree";

                $child = (array) $row;
                foreach ($child as $tag => $value) {
                    $xml .= " $tag=\"$value\"";
                }

                if (@$data[$row->id]) {
                    $xml .= ">\n";
                    $xml .= $this->transformToXML($row->id, $data, $level + 1);
                    $xml .= "</tree>\n";
                } else {
                    $xml .= " />\n";
                }
            }
        }
        // $xml .= "</tree>";
        return $xml;
    }
}