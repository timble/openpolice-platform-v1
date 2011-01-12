<?php
/**
 * @version		$Id: files.php 1373 2010-06-11 14:48:29Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__) . DS.'files.html.php';

require_once($_DOCMAN->getPath('classes', 'file'));
require_once($_DOCMAN->getPath('classes', 'utils'));

// retrieve some expected url (or form) arguments
$old_filename = JRequest::getVar('old_filename', 1);

switch ($task)
{
    case "new": // make a new document using the selected file
    	if(!$cid[0]) {
    		JFactory::getApplication()->redirect("index.php?option=com_docman&section=files", _DML_MAKE_SELECTION);
    	}
        // modify the request and go to 'documents' view
        $_REQUEST['section']        = 'documents';
        $_REQUEST['uploaded_file']  = $cid[0];
        $GLOBALS['section']        = 'documents';
        $GLOBALS['uploaded_file']  = $cid[0];
        include_once($_DOCMAN -> getPath('includes', 'documents'));
        break;
    case "upload" :
    	{
            $step = JRequest::getInt('step', 1);
            $method = JRequest::getCmd('radiobutton', null, 'post');

            if (!$method) {
                $method = JRequest::getCmd('method', 'http');
            }

            uploadWizard($step, $method, $old_filename);
        }
        break;
    case "remove":
        removeFile($cid);
        break;
    case "update":
        uploadWizard(2, 'http', $old_filename);
        break;
    case "show" :
    default :
        showFiles();
}


function showFiles()
{
    global $option, $section;
    global $_DOCMAN;

    $database = JFactory::getDBO();
    $mainframe = JFactory::getApplication();
    $limit     = $mainframe->getCfg('list_limit');

    $limit      = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $limit);
    $limitstart = $mainframe->getUserStateFromRequest("view{$option}{$section}limitstart", 'limitstart', 0);
    $levellimit = $mainframe->getUserStateFromRequest("view{$option}{$section}limit", 'levellimit', 10);

    $filter = $mainframe->getUserStateFromRequest("filterarc{$option}{$section}", 'filter', 0);
    $search = $mainframe->getUserStateFromRequest( "search{$option}{$section}", 'search', '' );

    // read directory content
    $folder = new DOCMAN_Folder($_DOCMAN->getCfg('dmpath'));
    $files = $folder->getFiles($search);

    // count number of links to docs
    $database->setQuery("SELECT `dmfilename`, COUNT(`dmfilename`) AS cnt FROM `#__docman` GROUP BY `dmfilename`");
    $links = $database->loadObjectList('dmfilename');
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
    }
    foreach($files as $file) {
        $file->links = (int) @$links[$file->name]->cnt;
    }


    if ($filter == 2) {
        $files = array_filter($files, 'filterOrphans');
    }
    if ($filter == 3) {
        $files = array_filter($files, 'filterDocuments');
    }

    $total = count($files);

    $pageNav = new DOCMAN_Pagination($total, $limitstart, $limit);

     // slice out elements based on limits
    $rows = array_slice($files, $pageNav->limitstart, $pageNav->limit);

    $filters[] = JHTML::_('select.option', '0', _DML_SELECT_FILE);
    $filters[] = JHTML::_('select.option', '1', _DML_ALLFILES);
    $filters[] = JHTML::_('select.option', '2', _DML_ORPHANS);
    $filters[] = JHTML::_('select.option', '3', _DML_DOCFILES);
    $lists['filter'] = JHTML::_('select.genericlist', $filters, 'filter',
        'class="inputbox" size="1" onchange="document.adminForm.submit( );"',
        'value', 'text', $filter);


    HTML_DMFiles::showFiles($rows, $lists, $search, $pageNav);
}

function removeFile($cid)
{
    DOCMAN_token::check() or die('Invalid Token');

    global $_DOCMAN;
    $mainframe = JFactory::getApplication();
    $database = JFactory::getDBO();
	$cid = JRequest::getVar('cid', array());
    foreach($cid as $name)
    {
        $database->setQuery("SELECT COUNT(dmfilename) FROM #__docman WHERE dmfilename='" . $database->getEscaped($name) . "'");
        $result = $database->loadResult();

        if ($database->getErrorNum()) {
            echo $database->stderr();
            return false;
        }

        if ($result != 0)
            $mainframe->redirect("index.php?option=com_docman&section=files", _DML_ORPHANS_LINKED);

        $file = $_DOCMAN->getCfg('dmpath') . DS . $name;

        jimport('joomla.filesystem.file');
        if (!JFile::delete($file))
        {
            $mainframe->redirect("index.php?option=com_docman&section=files", _DML_ORPHANS_PROBLEM);
        }
    }

    $mainframe->redirect("index.php?option=com_docman&section=files", _DML_ORPHANS_DELETED);
}

function uploadWizard($step = 1, $method = 'http', $old_filename)
{
    global $_DOCMAN;
	$mainframe = JFactory::getApplication();

    $database = JFactory::getDBO();

    switch ($step) {
        case 1:
            $lists['methods'] = dmHTML::uploadSelectList($method);
            HTML_DMFiles::uploadWizard($lists);
            break;

        case 2:
            switch ($method) {
                case 'http':
                    HTML_DMFiles::uploadWizard_http($old_filename);
                    break;
                case 'ftp':
                    HTML_DMFiles::uploadWizard_ftp();
                    break;
                case 'link':
                    $mainframe->redirect("index.php?option=com_docman&section=documents&task=new&makelink=1",_DML_CREATEALINK);
                    // HTML_DMFiles::uploadWizard_link();
                    break;
                case 'transfer':
                    HTML_DMFiles::uploadWizard_transfer();
                    break;
                default:
                    $mainframe->redirect("index.php?option=com_docman&section=files", _DML_SELECTMETHODFIRST);
            }
            break;
        case 3:
            DOCMAN_token::check() or die('Invalid Token');
            switch ($method) {
                case 'http':
                    $path = $_DOCMAN->getCfg('dmpath');

                    $upload = new DOCMAN_FileUpload();
                    $file_upload = JRequest::getVar('upload', '', 'files' , 'array');
                    $result = &$upload->uploadHTTP($file_upload, $path, _DM_VALIDATE_ADMIN);

                    if (!$result) {
                        $mainframe->redirect("index.php?option=com_docman&section=files", _DML_ERROR_UPLOADING . " - " . $upload->_err);
                    } else {
                        $batch = JRequest::getCmd('batch', null);

                        if ($batch && $old_filename <> null)
                        {
                            require_once JPATH_ADMINISTRATOR.DS.'includes'.DS.'pcl'.DS.'pclzip.lib.php';

                            if (!extension_loaded('zlib')) {
                                $mainframe->redirect("index.php?option=com_docman&section=files", _DML_ZLIB_ERROR);
                            }

                            $target_directory = $_DOCMAN->getCfg('dmpath');
                            $zip = new PclZip($target_directory .DS. $result->name);
                            $file_to_unzip = preg_replace('/(.+)\..*$/', '$1', $target_directory .DS. $result->name);

                            if (!$zip->extract($target_directory)) {
                                $mainframe->redirect("index.php?option=com_docman&section=files", _DML_UNZIP_ERROR);
                            }

                            @unlink ($target_directory .DS. $result->name);
                        }

                        if ($old_filename && $old_filename!=$file_upload['name']) {

                            $file = $_DOCMAN->getCfg('dmpath') .DS. $old_filename;
							@unlink($file);

                            $database->setQuery("UPDATE #__docman SET dmfilename='". $database->getEscaped($result->name) ."' WHERE dmfilename='". $database->getEscaped($old_filename) ."'");

                            if (!$database->query()) {
                                echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1);</script>\n";
                                exit();
                            }
                        }

                        //HTML_DMFiles::uploadWizard_sucess($result, $batch, $old_filename);
                        $mainframe->redirect("index.php?option=com_docman&section=files&task=upload&step=4" . "&result=" . urlencode($result->name) . "&batch=" . (0 + $batch) . "&old_filename=" . $old_filename,
                            _DML_SUCCESS . ' &quot;' . $result->name . '&quot; - ' . _DML_FILEUPLOADED);
                    }
                    break;

                case 'ftp': break;

                case 'link': break;

                case 'transfer':

                    $url  = stripslashes(JRequest::getString('url', null, 'post'));
                    $name = stripslashes(JRequest::getString('localfile', null, 'post'));
                    $path = $_DOCMAN->getCfg('dmpath') .DS;

                    $upload = new DOCMAN_FileUpload();
                    $result = $upload->uploadURL($url, $path, _DM_VALIDATE_ADMIN, $name);

                    if ($result) {
                        // HTML_DMFiles::uploadWizard_sucess($result, 0, 1);
                        $mainframe->redirect("index.php?option=com_docman&section=files&task=upload&step=4" . "&result=" . urlencode($result->name) . "&batch=0&old_filename=1",
                            _DML_SUCCESS . ' &quot;' . $result->name . '&quot; - ' . _DML_FILEUPLOADED);
                    } else {
                        $mainframe->redirect("index.php?option=com_docman&section=files", $upload->_err);
                    }
                    break;
            }
            break;

        case '4':/* New step that gives us a header completion message rather than
			   "in body" completion. For uniformity
			 */
            $file = new StdClass();
            $file->name = urlencode(stripslashes(JRequest::getString('result' , 'INTERNAL ERROR')));
            $batch = JRequest::getInt('batch' , 0);
            $old_filename = JRequest::getString('old_filename' , null);

            HTML_DMFiles::uploadWizard_sucess($file, $batch, $old_filename, 0);
            break;
    } //End switch($step)
}

function filterOrphans($var)
{
    if ($var->links != 0) {
        return false;
    }
    return true;
}

function filterDocuments($var)
{
    if ($var->links == 0) {
        return false;
    }
    return true;
}