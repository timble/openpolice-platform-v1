<?php
/**
 * @version		$Id: upload.link.php 1368 2010-05-04 13:39:40Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__) . DS.'upload.link.html.php';

class DMUploadMethod
{
    function fetchMethodForm($uid, $step, $update = false)
    {
        global $task;

        switch ($step)
        {
            case 2: // Input the remote URL(Form)
            {
                $lists = array();
                $lists['action']    = _taskLink($task, $uid, array('step' => $step + 1), false);
                return HTML_DMUploadMethod::linkFileForm($lists);
            } break;

            case 3: // Create a link
            {
                $url = stripslashes(JRequest::getString('url' , 'http://'));
                $err = DMUploadMethod::linkFileProcess($uid, $step, $url);
                if($err['_error']) {
                	_returnTo($task, $err['_errmsg'], '', array("method" => 'link' ,"step" => $step - 1 ,"localfile" => '' , "url" => DOCMAN_Utils::safeEncodeURL($url)));
                }

                $uploaded = DOCMAN_Utils::safeEncodeURL(_DM_DOCUMENT_LINK . $url);

                $catid = $update ? 0 : $uid;
                $docid = $update ? $uid : 0;
                $session = JFactory::getSession();
				$session->set('docman.dmfilename', _DM_DOCUMENT_LINK);
				$session->set('docman.document_url', $url);
                return fetchEditDocumentForm($docid , $uploaded, $catid);
            } break;

            default:
                break;
        }
        return true;
    }

    function linkFileProcess($uid, $step, $url)
    {
        DOCMAN_token::check() or die('Invalid Token');

        global $_DMUSER, $_DOCMAN;

        if ($url == '') {
        	return array(
				'_error' => 1,
				'_errmsg'=> _DML_FILENAME_REQUIRED
         	);
        }

    	$path = $_DOCMAN->getCfg('dmpath');

   		//get file validation settings
   		if ($_DMUSER->isSpecial) {
      		$validate = _DM_VALIDATE_ADMIN;
   		} else {
     		if ($_DOCMAN->getCfg('user_all', false)) {
        		$validate = _DM_VALIDATE_USER_ALL ;
      		} else {
           		$validate = _DM_VALIDATE_USER;
       		}
  		}

  		//upload the file
  		$upload = new DOCMAN_FileUpload();
  		$file = $upload->uploadLINK($url , $validate);

        if (!$file) {

            $msg = _DML_ERROR_LINKING . " - " . $upload->_err;

            return array(
				'_error' => 1,
				'_errmsg'=> $msg
         	);
        }

       $msg = _DML_LINKED;

       return array(
			'_error' => 0,
			'_errmsg'=> $msg
         );
    }
}

