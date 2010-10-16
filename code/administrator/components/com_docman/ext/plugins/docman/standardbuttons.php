<?php
/**
 * @version		$Id: standardbuttons.php 1122 2010-01-14 20:55:22Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

JApplication::registerEvent( 'onFetchButtons', 'bot_standardbuttons' );

function bot_standardbuttons($params) 
{
    global $_DOCMAN, $_DMUSER;

    require_once($_DOCMAN->getPath('classes', 'button'));
    require_once($_DOCMAN->getPath('classes', 'token'));

    $_DOCMAN->loadLanguage('frontend');

    $doc        = & $params['doc'];
    $file       = & $params['file'];
    $objDBDoc   = $doc->objDBTable;

    $botParams  = bot_standardbuttonsParams();
    $js = "javascript:if(confirm('"._DML_ARE_YOU_SURE."')) {window.location='%s'}";

    // format document links, ONLY those the user can perform.
    $buttons = array();

    if ($_DMUSER->canDownload($objDBDoc) AND $botParams->get('download', 1)) {
        $buttons['download'] = new DOCMAN_Button('download', _DML_BUTTON_DOWNLOAD, $doc->_formatLink('doc_download'));
    }

    if ($_DMUSER->canDownload($objDBDoc) AND $botParams->get('view', 1)) {
        $viewtypes = trim($_DOCMAN->getCfg('viewtypes'));
        if ($viewtypes != '' && ($viewtypes == '*' || stristr($viewtypes, $file->ext))) {
            $link = $doc->_formatLink('doc_view', null, true, 'index.php');
            $params = new DMmosParameters('popup=1');
            $buttons['view'] = new DOCMAN_Button('view', _DML_BUTTON_VIEW, $link, $params);
        }
    }

    if($botParams->get('details', 1)) {
    	$params = new DMmosParameters('popup=1');
        $buttons['details'] = new DOCMAN_Button('details', _DML_BUTTON_DETAILS, $doc->_formatLink('doc_details', array('tmpl'=>'component')), $params);
    }


    if ($_DMUSER->canEdit($objDBDoc) AND $botParams->get('edit', 1)) {
        $buttons['edit'] = new DOCMAN_Button('edit', _DML_BUTTON_EDIT, $doc->_formatLink('doc_edit'));
    }

    if ($_DMUSER->canMove($objDBDoc) AND $botParams->get('move', 1)) {
        $buttons['move'] = new DOCMAN_Button('move', _DML_BUTTON_MOVE, $doc->_formatLink('doc_move'));
    }

    if ($_DMUSER->canDelete($objDBDoc) AND $botParams->get('delete', 1)) {
        $link = $doc->_formatLink('doc_delete', null, null, 'index.php', true);
        $buttons['delete'] = new DOCMAN_Button('delete', _DML_BUTTON_DELETE, sprintf($js, $link));
    }

    if ($_DMUSER->canUpdate($objDBDoc) AND $botParams->get('update', 1)) {
        $buttons['update'] = new DOCMAN_Button('update', _DML_BUTTON_UPDATE, $doc->_formatLink('doc_update'));
    }

    if ($_DMUSER->canReset($objDBDoc) AND $botParams->get('reset', 1)) {
        $buttons['reset'] = new DOCMAN_Button('reset', _DML_BUTTON_RESET, sprintf($js, $doc->_formatLink('doc_reset')));
    }

    if ($_DMUSER->canCheckin($objDBDoc) AND $objDBDoc->checked_out AND $botParams->get('checkout', 1)) {
        $params = new DMmosParameters('class=checkin');
        $buttons['checkin'] = new DOCMAN_Button('checkin', _DML_BUTTON_CHECKIN, $doc->_formatLink('doc_checkin'), $params);
    }

    if ($_DMUSER->canCheckout($objDBDoc) AND !$objDBDoc->checked_out AND $botParams->get('checkout', 1)) {
        $buttons['checkout'] = new DOCMAN_Button('checkout', _DML_BUTTON_CHECKOUT, $doc->_formatLink('doc_checkout'));
    }

    if ($_DMUSER->canApprove($objDBDoc) AND !$objDBDoc->approved AND $botParams->get('approve', 1)) {
        $params = new DMmosParameters('class=approve');
        $link   = $doc->_formatLink('doc_approve', null, null, 'index.php', true);
        $buttons['approve'] = new DOCMAN_Button('approve', _DML_BUTTON_APPROVE, $link, $params);
    }

    if ($_DMUSER->canPublish($objDBDoc) AND $botParams->get('publish', 1)) {
        $params = new DMmosParameters('class=publish');
        $link   = $doc->_formatLink('doc_publish', null, null, 'index.php', true);
        $buttons['publish'] = new DOCMAN_Button('publish', _DML_BUTTON_PUBLISH, $link, $params);
    }

    if ($_DMUSER->canUnPublish($objDBDoc) AND $botParams->get('publish', 1)) {
        $link   = $doc->_formatLink('doc_unpublish', null, null, 'index.php', true);
        $buttons['unpublish'] = new DOCMAN_Button('unpublish', _DML_BUTTON_UNPUBLISH, $link);
    }

    return $buttons;

}

function bot_standardbuttonsParams() 
{
    static $params;
    $database = JFactory::getDBO();

    $dbtable = '#__plugins';
   
	// check if param query has previously been processed
    if ( !isset($params) ) 
    {
        // load plugin params info
        $query = "SELECT params"
        . "\n FROM $dbtable"
        . "\n WHERE element = 'standardbuttons'"
        . "\n AND folder = 'docman'"
        ;
        $database->setQuery( $query );
        $result = $database->loadResult();

        // save query to class variable
        $params = $result;
    }

    // pull query data from class variable
    $botParams = new JParameter(  $params );
    return $botParams;
}