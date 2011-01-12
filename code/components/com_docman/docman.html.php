<?php
/**
 * @version		$Id: docman.html.php 1098 2009-12-17 13:36:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_docman
{
    function pageMsgBox($msg)
    {
        global $_DOCMAN;

        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assign('msg', $msg);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_msgbox.tpl.php');
    }

    function pageDocman(&$html)
    {
        global $_DOCMAN;

        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html', $html);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docbrowse.tpl.php');
    }

    function pageDocument(&$html)
    {
        global $_DOCMAN;

        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html' , $html);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docdetails.tpl.php');
    }

    function pageDocumentEdit(&$html)
    {
        global $_DOCMAN;

        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html', $html);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docedit.tpl.php');
    }

    function pageDocumentMove(&$html)
    {
        global $_DOCMAN;

        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html', $html);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docmove.tpl.php');
    }

    function pageDocumentUpload(&$html, $step, $method, $update)
    {
        global $_DOCMAN;

        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html', $html);
        $tpl->assignRef('step', $step);
        $tpl->assignRef('method', $method);
        $tpl->assignRef('update', $update);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docupload.tpl.php');
    }

    function pageDocumentLicense(&$html, &$license)
    {
        global $_DOCMAN;

        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html',    $html   );
        $tpl->assignRef('license', $license);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_doclicense.tpl.php');
    }

    function pageSearch(&$html, &$items)
    {
        global $_DOCMAN;

        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html' , $html);
        $tpl->assignRef('items', $items);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docsearch.tpl.php');
    }

    function scriptDocumentEdit()
    {
    	 global $_DOCMAN;

    	 //set private cache control
		header("Cache-Control: private");

		//send javascript mime-type header
		header("Content-Type: text/javascript");

        $tpl = new DOCMAN_Theme();
        // Display a template using the assigned values.
        $tpl->display('script_docedit.tpl.php');
        die();
    }

    function scriptDocumentUpload($step, $method, $update)
    {
    	global $_DOCMAN;

    	//set private cache control
		header("Cache-Control: private");

		//send javascript mime-type header
		header("Content-Type: text/javascript");

        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('step', $step);
        $tpl->assignRef('method', $method);
        $tpl->assignRef('update', $update);
        // Display a template using the assigned values.
        $tpl->display('script_docupload.tpl.php');
    }

    function fetchMenu(&$links, &$perms)
    {
        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('links', $links);
        $tpl->assignRef('perms', $perms);
        // Display a template using the assigned values.
        return $tpl->fetch('general/menu.tpl.php');
    }

    function fetchPathWay(&$links)
    {
        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('links', $links);
        // Display a template using the assigned values.
        return $tpl->fetch('general/pathway.tpl.php');
    }

    function fetchPageNav(&$pageNav, $link)
    {
        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('pagenav', $pageNav);
        $tpl->assignRef('link', $link);
        // Display a template using the assigned values.
        return $tpl->fetch('general/pagenav.tpl.php');
    }

    function fetchPageTitle(&$pageTitle)
    {
        $tpl = new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('pagetitle', $pageTitle);
        // Display a template using the assigned values.
        return $tpl->fetch('general/pagetitle.tpl.php');
}

} // end class

