<?php
/**
 * @version		$Id: toolbar.docman.class.php 1012 2009-12-05 14:43:24Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
* MenuBar class
* @package DOCman_1.5
* */
class dmToolBar 
{
    function logo()
    {
    	?>
        <td width="250"><img src="<?php echo JURI::root(true); ?>/administrator/components/com_docman/images/dm_logo_small.png" alt="DOCman" /></td>
        <?php
    }

	/**
	* Writes the start of the button bar table
	*/
	function startTable() {
		?>
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function MM_swapImgRestore() { //v3.0
		var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
		}
		//-->
		</script>
		<style>
		<?php if(!class_exists('joomlaVersion')) { ?>
			table#toolbar {
				margin-right: 10px;
			}

			table#toolbar a.toolbar {
				color : #808080;
				text-decoration : none;
				display: block;
				border: 1px solid #DDD;
				width: 55px;
				padding: 2px 1px 2px 1px;
			}
			table#toolbar a.toolbar:hover {
				color : grey;
				border: 1px solid grey;
				background-color: #DDD;
				padding: 3px 0px 1px 2px;
			}
			table#toolbar a.toolbar:active {
				color : #FF9900;
			}
		<?php } ?>
		</style>
		<table id="toolbar" cellpadding="3" cellspacing="0" border="0">
		<tr height="60" valign="middle" align="center">
		<?php
	}

	/**
	* Writes a spacer cell
	* @param string The width for the cell
	*/
	function spacer( $width='' ) {
		?>
		<td width="<?php echo $width;?>">&nbsp;</td>
		<?php
	}

	/**
	* Write a divider between menu buttons
	*/
	function divider() {
		$image =  JHTML::_('image.administrator', 'menu_divider.png', '/administrator/images/' );
		?>
		<td>
		<?php echo $image; ?>
		</td>
		<?php
	}

	/**
	* Writes the end of the menu bar table
	*/
	function endTable() {
		?>
		</tr>
		</table>
		<?php
	}

	/**
	* Writes a common icon button
	* @param string The task
	* @param string The alt text
	* @param string The icon name
	*/
	function icon( $task, $alt, $icon, $path = "/administrator/images/") 
	{
        $icon = JURI::root(true).$path.$icon.'.png';

		?>
		<td>
		<a class="toolbar" href="javascript:submitbutton('<?php echo $task;?>');">
		<img name="<?php echo $task;?>" width="32" height="32" src="<?php echo $icon;?>" alt="<?php echo $alt;?>" border="0" align="middle" /><br />
		<?php echo $alt; ?>
		</a>
		</td>
		<?php
	}

	function save($task='save', $alt=_DML_TOOLBAR_SAVE) {
    	dmToolBar::icon($task, $alt, 'save_f2');
    }
    function apply($task='apply', $alt=_DML_TOOLBAR_APPLY) {
        dmToolBar::icon($task, $alt, 'apply_f2');
    }

    function cancel($task='cancel', $alt=_DML_TOOLBAR_CANCEL) {
    	dmToolBar::icon($task, $alt, 'cancel_f2');
    }

   	function addNew($task = 'new', $alt = _DML_TOOLBAR_NEW, $icon = 'dm_newdocument_32', $path = _DM_ICONPATH) {
   		dmToolBar::icon($task, $alt, $icon, $path);
   	}
    function addNewDocument($task = 'new', $alt = _DML_TOOLBAR_NEW_DOC, $icon = 'dm_newdocument_32', $path = _DM_ICONPATH) {
        dmToolBar::iconList($task, $alt, $icon, $path );

    }

    function cpanel() {
        dmToolBar::icon('cpanel', _DML_TOOLBAR_HOME, 'dm_cpanel_32', _DM_ICONPATH);
    }

    function upload($task = 'upload', $alt = _DML_TOOLBAR_UPLOAD) {
    	dmToolBar::icon($task, $alt, 'dm_upload_32', _DM_ICONPATH);
    }

    function move($task = 'move', $alt = _DML_TOOLBAR_MOVE) {
    	dmToolBar::icon($task, $alt, 'move_f2');
    }

    function copy($task = 'copy', $alt = _DML_TOOLBAR_COPY) {
        dmToolBar::icon($task, $alt, 'copy_f2');
    }

    function sendEmail(){
    	dmToolBar::icon('sendemail', _DML_TOOLBAR_SEND, 'dm_sendemail_32', _DM_ICONPATH );
    }

    /**
	* Writes a cancel button that will go back to the previous page without doing
	* any other operation
	*/
	function back($task = 'back', $alt = _DML_TOOLBAR_BACK, $href="javascript:window.history.back();") {
		?>
		<td>
		<a class="toolbar" href="<?php echo $href;?>">
		<img name="<?php echo $task;?>" width="32" height="32" src="images/back_f2.png" alt="<?php echo $alt;?>" border="0" align="middle" /><br />
		<?php echo $alt; ?>
		</a>
		</td>
		<?php
    }

	/**
	* Writes a common icon button for a list of records
	* @param string The task
	* @param string The alt text
	* @param string The icon name
	*/
	function iconList( $task, $alt, $icon, $path = "/administrator/images/" ) 
	{
        $icon = JURI::root(true).$path.$icon.'.png';
		?>
     	<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo _DML_MAKE_SELECTION?>'); } else {submitbutton('<?php echo $task;?>', '');}" >
		<img name="<?php echo $task;?>" width="32" height="32" src="<?php echo $icon;?>" alt="<?php echo $alt;?>" border="0" align="middle" /><br />
		<?php echo $alt; ?>
		</a>
		</td>
     	<?php
	}

    function iconListConfirm( $task, $alt, $icon, $path = "/administrator/images/" ) 
    {
        $icon = JURI::root(true).$path.$icon.'.png';
        ?>
        <td>
        <a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo _DML_MAKE_SELECTION?>'); } else if (confirm('<?php echo _DML_ARE_YOU_SURE?>')) {submitbutton('<?php echo $task;?>', '');}" >
        <img name="<?php echo $task;?>" width="32" height="32" src="<?php echo $icon;?>" alt="<?php echo $alt;?>" border="0" align="middle" /><br />
        <?php echo $alt; ?>
        </a>
        </td>
        <?php
    }

	function publishList($task='publish', $alt=_DML_TOOLBAR_PUBLISH) {
		dmToolBar::iconList($task, $alt, 'publish_f2');
	}

	function unpublishList($task='unpublish', $alt=_DML_TOOLBAR_UNPUBLISH) {
		dmToolBar::iconList($task, $alt, 'unpublish_f2');
	}

	function deleteList($task='remove', $alt=_DML_TOOLBAR_DELETE) {
		dmToolBar::iconListConfirm($task, $alt, 'delete_f2');
	}
    function clear($task='remove', $alt=_DML_TOOLBAR_CLEAR) {
        dmToolBar::iconListConfirm($task, $alt, 'dm_cleardata_32', _DM_ICONPATH);
    }
	function editList($task='edit', $alt=_DML_TOOLBAR_EDIT) {
		dmToolBar::iconList($task, $alt, 'dm_edit_32', _DM_ICONPATH );
	}

	function editCss( $task='edit_css', $alt=_DML_TOOLBAR_EDIT_CSS) {
		dmToolBar::iconList($task, $alt, 'css_f2');
	}

    function help()
    {
        ?>
    	<td>
            <a class="toolbar" href="#" onClick="window.open('<?php echo _DM_HELP_URL?>', 'docman_help', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=580,height=450,directories=no,location=no');return false;" >
                <img src="<?php echo JURI::root(true)._DM_ICONPATH?>dm_help_32.png" alt="Help" border="0" name="help" align="middle">
                <?php echo defined('_DML_HELP') ? _DML_HELP : 'Help';?>
            </a>
        </td>
        <?php
    }
}