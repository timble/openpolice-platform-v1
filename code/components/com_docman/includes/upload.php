<?php
/**
 * @version		$Id: upload.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__) . DS.'upload.html.php';
include_once dirname(__FILE__) . DS.'documents.php';

require_once($_DOCMAN->getPath('classes', 'mambots'));
require_once($_DOCMAN->getPath('classes', 'file'));

function fetchDocumentUploadForm($uid, $step, $method, $update)
{
    global $_DMUSER, $_DOCMAN;

    //preform permission check
    if($_DMUSER->canPreformTask(null, 'Upload'))	{
    	_returnTo('', _DML_NOLOG_UPLOAD);
    }



    //check to see if method is available
    if(!methodAvailable($method))	{
    	_returnTo('upload', _DML_UPLOADMETHOD , array('step' => 1));
    }

   	switch($step)
   	{
      	case '1' :
   			return fetchMethodsForm($uid, $step, $method);
      		break;
   		case '2' :
   		case '3' :
           	return fetchMethodForm($uid, $step, $method, $update);
   			break;

      	default : break;
    }
}

function fetchMethodsForm($uid, $step, $method)
{
	global $task;

	// Prompt with a list of upload methods
   	$lists = array();
   	$lists['methods'] = dmHTML::uploadSelectList();
   	$lists['action']  = _taskLink($task, $uid, array('step' => $step + 1), false);

    return HTML_DMUpload::uploadMethodsForm($lists);
}

function fetchMethodForm($uid, $step, $method, $update)
{
	global $_DOCMAN, $task;

  	$method_file = $_DOCMAN->getPath('includes_f', 'upload.'.$method) ;
   	if (! file_exists($method_file)) {
       _returnTo($task, "Protocol " . $method . " not supported", '', array('step' => 1));
   	}

    require_once($method_file);

    return DMUploadMethod::fetchMethodForm($uid, $step, $update);
}

function methodAvailable($method)
{
	global $_DOCMAN, $_DMUSER;

	if($_DMUSER->isSpecial || is_null($method)) {
		return true;
	}

	$methods = $_DOCMAN->getCfg('methods', array('http'));
	if(!in_array($method, $methods)) {
		return false;
	}
	return true;
}
