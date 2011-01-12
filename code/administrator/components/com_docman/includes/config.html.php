<?php
/**
 * @version		$Id: config.html.php 1372 2010-06-11 14:22:50Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMConfig
{
    function configuration(&$lists)
    {
        global $_DOCMAN;
        jimport('joomla.html.pane');
        $tabs =& JPane::getInstance('Tabs', array('useCookies' => true));

        JHTML::_('behavior.tooltip');
        ?>

        <script language="JavaScript" src="<?php echo JURI::root(true);?>/includes/js/overlib_mini.js" type="text/javascript"></script>

		<style>
			.dmtitle { background-color: #EEE; font-weight:  bold; border-bottom: 1px solid #BBB; }
			.checkList label { padding-left: 10px; }
			select option.label { background-color: #EEE; border: 1px solid #DDD; color : #333; }
		</style>

        <?php dmHTML::adminHeading( _DML_CONFIGURATION, 'config' )?>

        <div class="dm_filters">
            <span class="componentheading">docman.config.php:
			 <?php echo is_writable(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_docman'.DS.'docman.config.php') ? '<b><font color="green">'._DML_WRITABLE.'</font></b>' : '<b><font color="red">'._DML_UNWRITABLE.'</font></b>' ?>
			</span>
        </div>

        <script language="javascript" type="text/javascript">
            function submitbutton(pressbutton) {
                var form = document.adminForm;
                if (pressbutton == 'cancel') {
                    submitform( pressbutton );
                    return;
                }
		  $msg = "";
          if (form.dmpath.value == ""){
			$msg = "\n<?php echo _DML_CFG_ERR_DOCPATH ;?>";
		  }
		  if( isNaN( parseInt( form.perpage.value ) ) ||
			  parseInt( form.perpage.value ) < 1 ) {
			$msg += "\n<?php echo _DML_CFG_ERR_PERPAGE;?>";
		  }
		  if( isNaN( parseInt( form.days_for_new.value ) ) ||
			  parseInt( form.days_for_new.value ) < 0 ) {
			$msg += "\n<?php echo _DML_CFG_ERR_NEW;?>";
		  }
		  if( isNaN( parseInt( form.hot.value ) ) ||
			  parseInt( form.hot.value ) < 0 ) {
			$msg += "\n<?php echo _DML_CFG_ERR_HOT;?>";
		  }
		  if( form.user_upload.value == "<?php echo _DM_PERMIT_NOOWNER;?>"){
			$msg += "\n<?php echo _DML_CFG_ERR_UPLOAD;?>";
		  }
		  if( form.user_approve.value == "<?php echo _DM_PERMIT_NOOWNER;?>" ){
			$msg += "\n<?php echo _DML_CFG_ERR_APPROVE;?>";
		  }
		  if( form.default_viewer.value == "<?php echo _DM_PERMIT_NOOWNER;?>" ){
			$msg += "\n<?php echo _DML_CFG_ERR_DOWNLOAD;?>";
		  }
		  if( form.default_editor.value == "<?php echo _DM_PERMIT_NOOWNER;?>" ){
			$msg += "\n<?php echo _DML_CFG_ERR_EDIT;?>";
		  }

          if ( $msg != "" ){
                $msghdr = "<?php echo _DML_ENTRY_ERRORS;?>";
                $msghdr += '\n=================================';
                alert( $msghdr+$msg+'\n' );

          } else {
        	   submitform( pressbutton );
          }
        }

        /* Make sure the user can only use 0-9 and K, M, G */
        function dmFilesize(f) {
        	var re = /[0-9KMGkmg]*/;
            f.value = f.value.match(re);
        }
        </script>

        <form action="index.php?option=com_docman&amp;task=saveconfig" method="post" name="adminForm" id="adminForm">
        <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>

        <?php
        echo $tabs->startPane("configPane");
        echo $tabs->startPanel(_DML_GENERAL, "general-page");
        ?>
	    <fieldset class="adminform">
	    <table class="admintable">
	        <tr>
	            <td class="key">
	            	<?php echo _DML_VERSION;?>
	            </td>
	            <td><?php echo _DM_VERSION;?></td>
	            <td>&nbsp;</td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_PATHFORSTORING .'::'. _DML_CFG_PATHTT ?>"><?php echo _DML_CFG_PATHFORSTORING;?></label>
	            </td>
	            <td>
	                <?php
	                $newpath = JPATH_ROOT.DS._DM_DEFAULT_DATA_FOLDER;
	                $path = $_DOCMAN->getCfg('dmpath', $newpath);
	                ?>
	                <input size="50" type="text" name="dmpath" value="<?php echo $path?>" />
	            </td>
				<td>
	                <input type="button" value="<?php echo _DML_RESETDEFAULT;?>" name="Reset" onclick="document.adminForm.dmpath.value='<?php echo addslashes($newpath);?>';" />
	            </td>
	        </tr>
	    </table>
	    </fieldset>
        <?php
        echo $tabs->endPanel();
        echo $tabs->startPanel(_DML_FRONTEND, "frontend-page");
        ?>
    	<fieldset class="adminform">
    	<legend><?php echo _DML_CFG_GENERALSET;?></legend>
	    <table class="admintable">
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_SECTIONISDOWN.'::'._DML_CFG_SECTIONTT ?>"><?php echo _DML_CFG_SECTIONISDOWN;?></label>
	            </td>
	            <td><?php echo $lists['isDown'];?></td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_EXTENSIONSVIEWING .'::'. _DML_CFG_EXTENSIONSVIEWINGTT; ?>"><?php echo _DML_CFG_EXTENSIONSVIEWING;?>:</label>
	            </td>
	            <td><input type="text" name="viewtypes" value="<?php
	        echo $_DOCMAN->getCfg('viewtypes', "pdf|doc|txt|jpg|jpeg|gif|png")?>" style="width: 200px" /></td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_NUMBEROFDOCS.'::'._DML_CFG_NUMBERTT ?>"><?php echo _DML_CFG_NUMBEROFDOCS;?></label>
	            </td>
	            <td><?php echo $lists['perpage'];?></td>
	        </tr>
	         <tr>
	            <td class="key">
	            	<label><?php echo _DML_CFG_DEFAULTLISTING;?></label>
	            </td>
	            <td><?php echo $lists['default_order'];?> <?php echo $lists['default_order2'];?></td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_EMAILGROUP.'::'._DML_CFG_EMAILGROUPTT ?>"><?php echo _DML_CFG_EMAILGROUP;?></label>
	            </td>
	            <td><?php echo $lists['emailgroups'];?></td>
	        </tr>
	    </table>
	    </fieldset>
	    <fieldset class="adminform">
    	<legend><?php echo _DML_CFG_THEMES;?></legend>
	    <table class="admintable">
	        <tr>
	            <td class="key">
	            	<label><?php echo _DML_CFG_ICONSIZE;?></label>
	            </td>
	            <td><?php echo $lists['icon_size'];?></td>
	        </tr>
	         <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_TRIMWHITESPACE.'::'._DML_CFG_TRIMWHITESPACETT ?>"><?php echo _DML_CFG_TRIMWHITESPACE;?></label>
	            </td>
	            <td><?php echo $lists['trimwhitespace'];?></td>
	        </tr>
	     </table>
	    </fieldset>
	    <fieldset class="adminform">
    	<legend><?php echo _DML_CFG_EXTRADOCINFO;?></legend>
	    <table class="admintable">
	         <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_DAYSFORNEW.'::'._DML_CFG_DAYSFORNEWTT ?>"><?php echo _DML_CFG_DAYSFORNEW;?></label>
	            </td>
	            <td><input type="text" name="days_for_new" value="<?php echo $_DOCMAN->getCfg('days_for_new', 5);?>" /></td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_HOT.'::'._DML_CFG_HOTTT ?>"><?php echo _DML_CFG_HOT;?></label>
	            </td>
	            <td><input type="text" name="hot" value="<?php echo $_DOCMAN->getCfg('hot', 100);?>" /></td>
	        </tr>
	        <tr >
	            <td class="key">
	            	<label></label>
	            	<?php echo _DML_CFG_DISPLAYLICENSES;?></td>
	            <td><?php echo $lists['display_license'];?></td>
	        </tr>
	         <tr >
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_PROCESS_BOTS.'::'._DML_CFG_PROCESS_BOTSTT ?>"></label>
	            	<?php echo _DML_CFG_PROCESS_BOTS;?></td>
	            <td><?php echo $lists['process_bots'];?></td>
	        </tr>
	    </table>
	    </fieldset>
        <?php
        echo $tabs->endPanel();
        echo $tabs->startPanel(_DML_PERMISSIONS, "permissions-page");
        ?>
        <fieldset class="adminform">
    	<legend><?php echo _DML_CFG_GUESTPERM;?></legend>
	    <table class="admintable">
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_GUEST.'::'._DML_CFG_GUEST_TT ?>"><?php echo _DML_CFG_GUEST ;?></label>
	            </td>
	            <td><?php echo $lists['guest'];?></td>
	        </tr>
	    </table>
	    </fieldset>
	    <fieldset class="adminform">
    	<legend><?php echo _DML_CFG_FRONTPERM;?></legend>
	    <table class="admintable">
	         <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_UPLOAD.'::'._DML_CFG_UPLOADTT ?>"><?php echo _DML_CFG_UPLOAD;?></label>
	            </td>
	            <td><?php echo $lists['user_upload']->toHtml();;?></td>
	        </tr>
	         <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_APPROVE.'::'._DML_CFG_APPROVETT ?>"><?php echo _DML_CFG_APPROVE;?></label>
	            </td>
	            <td><?php echo $lists['user_approve']->toHtml();?></td>
	        </tr>
	         <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_PUBLISH.'::'._DML_CFG_PUBLISHTT ?>"><?php echo _DML_CFG_PUBLISH;?></label>
	            </td>
	            <td><?php echo $lists['user_publish']->toHtml();?></td>
	        </tr>
    	</table>
    	</fieldset>
	    <fieldset class="adminform">
    	<legend><?php echo _DML_CFG_DOCPERM;?></legend>
	    <table class="admintable">
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_VIEW.'::'._DML_CFG_VIEWTT ?>"><?php echo _DML_CFG_VIEW;?></label>
	            </td>
	            <td><?php echo $lists['default_viewer']->toHtml();?></td>
	        </tr>
	         <?php
	        $author_checked = '';
	        $editor_checked = '';
	        $assign = $_DOCMAN->getCfg('reader_assign');
	        if (($assign == 1) || ($assign == 3)) {
	            $author_checked = 'checked';
	        }
	        if (($assign == 2) || ($assign == 3)) {
	            $editor_checked = 'checked';
	        }
	        ?>
			<tr>
				<td class="key">
					<label class="hasTip" title="<?php echo _DML_CFG_WHOCANAREADER.'::'._DML_CFG_WHOCANAREADERTT ?>"><?php echo _DML_CFG_OVERRIDEVIEW;?></label>
				</td>
				<td class="checkList">
					<input type="checkbox" name="assign_download_author" id="assign_download_author" <?php echo $author_checked;?> /><label for="assign_download_author"><?php echo _DML_CREATOR ?></label><br />
					<input type="checkbox" name="assign_download_editor" id="assign_download_editor" <?php echo $editor_checked;?> /><label for="assign_download_editor"><?php echo _DML_EDITOR ?></label><br />
				</td>
			</tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_MAINTAIN.'::'._DML_CFG_MAINTAINTT ?>"><?php echo _DML_CFG_MAINTAIN;?></label>
	            </td>
	            <td><?php echo $lists['default_maintainer']->toHtml();?></td>
	        </tr>
	        <?php
	        $author_checked = '';
	        $editor_checked = '';
	        $assign = $_DOCMAN->getCfg('editor_assign');
	        if (($assign == 1) || ($assign == 3)) {
	            $author_checked = 'checked';
	        }
	        if (($assign == 2) || ($assign == 3)) {
	            $editor_checked = 'checked';
	        }

	        ?>

			<tr>
				<td class="key">
					<label class="hasTip" title="<?php echo _DML_CFG_WHOCANAEDITOR.'::'._DML_CFG_WHOCANAEDITORTT ?>"><?php echo _DML_CFG_OVERRIDEMANT;?></label>
				</td>
				<td class="checkList">
					<input type="checkbox" name="assign_edit_author" id="assign_edit_author" <?php echo $author_checked;?> /><label for="assign_edit_author"><?php echo _DML_CREATOR ?></label><br />
					<input type="checkbox" name="assign_edit_editor" id="assign_edit_editor" <?php echo $editor_checked;?> /><label for="assign_edit_editor"><?php echo _DML_EDITOR ?></label><br />
				</td>
			</tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_INDIVIDUAL_PERM.'::'._DML_CFG_INDIVIDUAL_PERMTT ?>"><?php echo _DML_CFG_INDIVIDUAL_PERM;?></label>
	           	</td>
	            <td><?php echo $lists['individual_perm'];?></td>
	        </tr>
		</table>
   		</fieldset>
	    <fieldset class="adminform">
    	<legend><?php echo _DML_CFG_CREATORPERM;?></legend>
	    <table class="admintable">
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_CREATORS_PERM.'::'._DML_CFG_CREATORSPERMTT ?>"><?php echo _DML_CFG_CREATORS_PERM;?></label>
	            </td>
	            <td><?php echo $lists['creator_can'];?></td>
	        </tr>
    	</table>
    	</fieldset>
        <?php
        echo $tabs->endPanel();
        echo $tabs->startPanel(_DML_UPLOAD, "upload-page");
        ?>
	    <fieldset class="adminform">
    	<legend><?php echo _DML_CFG_GENERALSET;?></legend>
	    <table class="admintable">
	        <tr>
				<td class="key">
					<label class="hasTip" title="<?php echo _DML_CFG_UPMETHODS.'::'._DML_CFG_UPMETHODSTT ?>"><?php echo _DML_CFG_UPMETHODS;?></label>
				</td>
				<td><?php echo $lists['methods'];?></td>
			</tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_MAXFILESIZE.'::'._DML_CFG_MAXFILESIZETT . ini_get('upload_max_filesize') ?>"><?php echo _DML_CFG_MAXFILESIZE;?></label>
	            </td>
	            <td><input type="text" name="maxAllowed" onkeyup="javascript:dmFilesize(this)" value="<?php echo DOCMAN_Utils::number2text($_DOCMAN->getCfg('maxAllowed', 1024000));?>" /> <small><?php echo JText::_('Maximum')?>: <?php echo $lists['maxini']?></small></td>
	        </tr>
	         <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_OVERWRITEFILES.'::'._DML_CFG_OVERWRITEFILESTT ?>"><?php echo _DML_CFG_OVERWRITEFILES;?></label>
	            </td>
	            <td><?php echo $lists['overwrite'];?></td>
	        </tr>
	    </table>
   		</fieldset>
	    <fieldset class="adminform">
    	<legend><?php echo _DML_CFG_FILEXTENSIONS;?></legend>
	    <table class="admintable">
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_EXTALLOWED.'::'._DML_CFG_EXTALLOWEDTT ?>"><?php echo _DML_CFG_EXTALLOWED;?></label>
	            </td>
	            <td><input type="text" name="extensions" value="<?php echo $_DOCMAN->getCfg('extensions', "zip|rar|pdf|txt")?>" /></td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_USERCANUPLOAD.'::'._DML_CFG_USERCANUPLOADTT ?>"><?php echo _DML_CFG_USERCANUPLOAD;?></label>
	            </td>
	            <td><?php echo $lists['user_all'];?></td>
	        </tr>
	    </table>
   		</fieldset>
	    <fieldset class="adminform">
    	<legend><?php echo _DML_CFG_FILENAMES;?></legend>
	    <table class="admintable">
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_LOWERCASE.'::'._DML_CFG_LOWERCASETT ?>"><?php echo _DML_CFG_LOWERCASE;?></label>
	            </td>
	            <td><?php echo $lists['fname_lc'];?></td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_FILENAMEBLANKS.'::'._DML_CFG_FILENAMEBLANKSTT ?>"><?php echo _DML_CFG_FILENAMEBLANKS;?>:</label>
	            </td>
	            <td><?php echo $lists['fname_blank'];?></td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_REJECTFILENAMES.'::'._DML_CFG_REJECTFILENAMESTT ?>"><?php echo _DML_CFG_REJECTFILENAMES;?>:</label>
	            </td>
	            <td><input type="text" name="fname_reject" value="<?php echo htmlentities( $_DOCMAN->getCfg('fname_reject', ''), ENT_QUOTES);?>" /></td>
	        </tr>
	    </table>
	    </fieldset>
        <?php
        echo $tabs->endPanel();
        echo $tabs->startPanel(_DML_SECURITY, "security-page");
        ?>
	    <fieldset class="adminform">
	    <table class="admintable">
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_ANTILEECH.'::'._DML_CFG_ANTILEECHTT ?>"><?php echo _DML_CFG_ANTILEECH;?></label>
	            </td>
	            <td><?php echo $lists['security_anti_leech'];?></td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_ALLOWEDHOSTS.'::'._DML_CFG_ALLOWEDHOSTSTT ?>"><?php echo _DML_CFG_ALLOWEDHOSTS;?></label>
	            </td>
	            <td><input type="text" name="security_allowed_hosts" value="<?php echo $_DOCMAN->getCfg('security_allowed_hosts' , $_SERVER["HTTP_HOST"])?>" /></td>
	            <td>
	            <input type="button" value="<?php echo _DML_RESETDEFAULT;?>" name="Reset" onclick="document.adminForm.security_allowed_hosts.value='<?php echo $_SERVER['HTTP_HOST'];?>';" />
	            </td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_LOG.'::'._DML_CFG_LOGTT ?>"><?php echo _DML_CFG_LOG;?></label>
	            </td>
	            <td><?php echo $lists['log'];?></td>
	        </tr>
	        <tr>
	            <td class="key">
	            	<label class="hasTip" title="<?php echo _DML_CFG_HIDE_REMOTE.'::'._DML_CFG_HIDE_REMOTETT ?>"><?php echo _DML_CFG_HIDE_REMOTE;?></label>
	            </td>
	            <td><?php echo $lists['hide_remote'];?></td>
	        </tr>
	    </table>
	    </fieldset>

        <?php
        echo $tabs->endPanel();
        echo $tabs->endPane();
        ?>
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="option" value="com_docman" />
        <input type="hidden" name="section" value="config" />
        <input type="hidden" name="docman_version" value="<?php echo _DM_VERSION;?>" />
        <?php echo DOCMAN_token::render();?>
    </form>

    <?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php'); ?>

    <?php }
}