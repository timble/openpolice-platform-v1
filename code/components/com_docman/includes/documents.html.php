<?php
/**
 * @version		$Id: documents.html.php 1372 2010-06-11 14:22:50Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

require_once($_DOCMAN->getPath('classes', 'html'));

class HTML_DMDocuments
{
    function displayDocument(&$buttons, &$paths, &$data)
    {
        // modify links data
        unset($buttons['details']);
        $tpl = new DOCMAN_Theme();

        // Assign values to the Savant instance.
        $tpl->assignRef('buttons', $buttons);
        $tpl->assignRef('paths', $paths);
        $tpl->assignRef('data', $data);

        // Display a template using the assigned values.
        return $tpl->fetch('documents/document.tpl.php');
    }

    function displayDocumentList(&$order, &$items)
    {
        $tpl = new DOCMAN_Theme();

        // Assign values to the Savant instance.
        $tpl->assignRef('order', $order);
        $tpl->assignRef('items', $items);

        // Display a template using the assigned values.
        return $tpl->fetch('documents/list.tpl.php');
    }

    function editDocumentForm(&$row, &$lists, $last, $created, &$params)
    {
        global $Itemid;
        global $_DOCMAN, $_DMUSER;

        require_once(JPATH_SITE . DS.'includes'.DS.'HTML_toolbar.php');

        JFilterOutput::objectHTMLSafe($row);

        ob_start();
        ?>
        <form action="<?php echo JRoute::_('index.php?option=com_docman')?>" method="post" name="adminForm" onsubmit="javascript:setgood();" id="dm_frmedit" class="dm_form">

		<fieldset class="dm_adminform">
    	<legend><?php echo _DML_DESCRIPTION ?></legend>
        <table class="dm_admintable">
		<tr>
			<td class="dm_key">
				<label><?php echo _DML_TITLE; ?></label>
			</td>
			<td>
				<input class="inputbox" type="text" name="dmname" size="50" maxlength="100" value="<?php echo $row->dmname;?>" />
			</td>
		</tr>
		<tr>
			<td class="dm_key">
				<label for="catid"><?php echo _DML_CATEGORY;?></label>
			</td>
			<td>
				<?php echo $lists['catid'];?>
			</td>
		</tr>
		<?php if (!$row->approved && $_DMUSER->canApprove()) : ?>
		<tr>
			<td class="dm_key">
				<label><?php echo _DML_APPROVED;?></label>
			</td>
			<td>
				<?php echo $lists['approved']; ?>
			</td>
		</tr>
		<?php endif; ?>
		<?php if ($row->approved && $_DMUSER->canPublish()) : ?>
		<tr>
			<td class="dm_key">
				<label><?php echo _DML_PUBLISHED;?></label>
			</td>
			<td>
				<?php echo $lists['published']; ?>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
		<td class="dm_key">
				<label><?php echo _DML_DESCRIPTION; ?></label>
			</td>
			<td>
				<?php
				// parameters : areaname, content, hidden field, width, height, rows, cols
				DOCMAN_Compat::editorArea('editor1', $row->dmdescription, 'dmdescription', '100%', '250', '50', '10');
				?>
			</td>
		</tr>
		</table>
		</fieldset>

        <?php
        jimport('joomla.html.pane');
        $tabs = JPane::getInstance('tabs', array('useCookies' => false));

        echo $tabs->startPane("content-pane");
        echo $tabs->startPanel(_DML_DOCUMENT, "document-page");

        HTML_DMDocuments::_showTabDocument($row, $lists, $last, $created);

        echo $tabs->endPanel();
        echo $tabs->startPanel(_DML_TAB_PERMISSIONS, "permissions-page");

        HTML_DMDocuments::_showTabPermissions($row, $lists, $last, $created);

        echo $tabs->endPanel();
        echo $tabs->startPanel(_DML_TAB_LICENSE, "license-page");

        HTML_DMDocuments::_showTabLicense($row, $lists, $last, $created);

       	if(isset($params)) :
        echo $tabs->endPanel();
        echo $tabs->startPanel(_DML_TAB_DETAILS, "details-page");

        HTML_DMDocuments::_showTabDetails($row, $lists, $last, $created, $params);
        endif;

        echo $tabs->endPanel();
        echo $tabs->endPane();
        ?>

        <input type="hidden" name="goodexit" value="0" />
		<input type="hidden" name="id" value="<?php echo $row->id;?>" />
		<input type="hidden" name="option" value="com_docman" />
		<input type="hidden" name="task" value="doc_save" />
		<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
        <input type="hidden" name="dmcounter" value="<?php echo $row->dmcounter;?>" />
        <?php echo DOCMAN_token::render();?>
		</form>
        <?php
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    function _showTabDocument(&$row, &$lists, $last, $created)
    {
    	global $_DOCMAN, $_DMUSER;
        DOCMAN_Compat::calendarJS();

    	?>
		<fieldset class="dm_adminform">
        <table class="dm_admintable">
		<tr>
			<td class="dm_key">
				<label for="dmthumbnail"><?php echo _DML_THUMBNAIL;?></label>
			</td>
			<td>
				<?php echo $lists['dmthumbnail'];?>
				<?php $previewfull = $lists['dmthumbnail_preview'] ? "images/stories/".$lists['dmthumbnail_preview'] : "images/M_images/blank.png";?>
				<img src="<?php echo $previewfull ?> " id="dmthumbnail_preview" alt="Preview" />
			</td>
		</tr>
		<tr>
			<td class="dm_key">
				<label for="dmdate_published"><?php echo _DML_DATE;?></label>
			</td>
			<td>
				<?php DOCMAN_Compat::calendar('dmdate_published', $row->dmdate_published);?>
			</td>
		</tr>
		<tr>
			<td class="dm_key">
				<label for="dmfilename"><?php echo _DML_FILE;?></label>
			</td>
			<td>
				<?php echo $lists['dmfilename'];?>
			</td>
		</tr>

		<?php if (isset($row->dmlink)) : ?>
		<tr>
			<td class="dm_key">
				<label for="dmfilename" class="hasTip" title="<?php echo _DML_DOCURL.'::'._DML_DOCURL_TOOLTIP; ?>"><?php echo _DML_DOCURL;?></label>
			</td>
			<td>
				<input class="inputbox" type="text" name="document_url" size="50" maxlength="200" value="<?php echo $row->dmlink ?>" />
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td class="dm_key">
				<label for="dmurl" class="hasTip" title="<?php echo _DML_HOMEPAGE.'::'._DML_HOMEPAGE_TOOLTIP; ?>"><?php echo _DML_HOMEPAGE;?></label>
			</td>
			<td>
				<input class="inputbox" type="text" name="dmurl" size="50" maxlength="200" value="<?php echo $row->dmurl ?>" />
				<div><i>(<?php echo _DML_MAKE_SURE;?>)</i></div>
			</td>
		</tr>
		</table>
		</fieldset>
        <?php
    }

    function _showTabPermissions(&$row, &$lists, $last, $created)
    {
    	global $_DOCMAN, $_DMUSER;

    	?>
    	<fieldset class="dm_adminform">
	    	<table class="dm_admintable">
	    	<tr>
				<td class="dm_key">
					<label for="dmowner" class="hasTip" title="<?php echo _DML_OWNER.'::'._DML_OWNER_TOOLTIP; ?>"><?php echo _DML_OWNER;?></label>
				</td>
				<td>
					<?php echo $lists['viewer'];?>
				</td>
			</tr>
			<tr>
				<td class="dm_key">
					<label for="dmmaintainedby" class="hasTip" title="<?php echo _DML_MAINTAINER.'::'._DML_MANT_TOOLTIP; ?>"><?php echo _DML_MAINTAINER;?></label>
				</td>
				<td>
					<?php echo $lists['maintainer']; ?>
				</td>
			</tr>
			<tr>
				<td class="dm_key">
					<label for="dmcreatedby"><?php echo _DML_CREATED_BY;?></label>
				</td>
				<td>
					[<?php echo $created[0]->name;?>]&nbsp;
					<i>
					<?php echo _DML_ON . "&nbsp;"; ?>
					<?php
		        	if ($row->dmdate_published) {
		           	 	echo JHTML::_('date', $row->dmdate_published);
		        	} else {
		            	$date = date("Y-m-d H:i:s", time("Y-m-d g:i:s"));
		            	echo  JHTML::_('date', $row->dmdate_published, JText::_('DATE_FORMAT_LC1'));
		        	}
		        	?>
	   				</i>
				</td>
			</tr>
			<tr>
				<td class="dm_key">
					<label for="dmupdatedby"><?php echo _DML_UPDATED_BY;?></label>
				</td>
				<td>
					[<?php echo $created[0]->name;?>]&nbsp;
					<?php
		        	if ($row->dmlastupdateon) {
		            	echo "<i>" . _DML_ON . "&nbsp;" . JHTML::_('date', $row->dmlastupdateon, JText::_('DATE_FORMAT_LC1')) ."</i>" ;
		        	} ?>
				</td>
			</tr>
			</table>
  		</fieldset>
  		<?php
    }

    function _showTabLicense(&$row, &$lists, $last, $created)
    {
    	global $_DOCMAN, $_DMUSER;

    	?>
    	<fieldset class="dm_adminform">
    	<table class="dm_admintable">
    	<tr>
			<td class="dm_key">
				<label for="dmlicense_id" class="hasTip" title="<?php echo _DML_LICENSE_TYPE.'::'._DML_LICENSE_TOOLTIP; ?>"><?php echo _DML_LICENSE_TYPE;?></label>
			</td>
			<td>
				<?php echo $lists['licenses']; ?>
			</td>
		</tr>
    	<tr>
			<td class="dm_key">
				<label for="dmlicense_display" class="hasTip" title="<?php echo _DML_DISPLAY_LIC.'::'._DML_DISPLAY_LIC_TOOLTIP; ?>"><?php echo _DML_DISPLAY_LICENSE;?></label>
			</td>
			<td>
				<?php echo $lists['licenses_display']; ?>
			</td>
		</tr>
		</table>
        </fieldset>
        <?php
    }

    function _showTabDetails(&$row, &$lists, $last, $created, &$params)
    {
    	global $_DOCMAN, $_DMUSER;

    	?>
    	<fieldset class="dm_adminform">
		<?php echo $params->render('params');?>
    	</fieldset>
    	<?php
    }

    function moveDocumentForm($lists, $links, $paths, $data)
    {
        $action = _taskLink('doc_move_process', $data->id);

		ob_start();
        ?>
		<form action="<?php echo DOCMAN_Compat::sefRelToAbs($action) ?>" method="post" id="dm_frmmove" class="dm_form" >
		<fieldset class="dm_adminform">
		<table class="dm_admintable">
		<tr>
			<td class="dm_key">
				<label for="name"><?php echo _DML_DOC;?></label>
			</td>
			<td>
				<span id="name"><?php echo $data->dmname;?> (<?php echo $data->filename;?>)</span>
			</td>
		</tr>
		<tr>
			<td class="dm_key">
				<label for="catid"><?php echo _DML_MOVETO;?></label>
			</td>
			<td>
				<?php echo $lists['categories'];?>
			</td>
		</tr>
		</table>
		</fieldset>
		<fieldset class="dm_button">
 			<p>
 				<input name="submit" class="button" value="<?php echo _DML_MOVETHEFILES;?>" type="submit" />
 			</p>
 		</fieldset>
        <?php echo DOCMAN_token::render();?>
 		</form>
 		<?php

 		$html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}