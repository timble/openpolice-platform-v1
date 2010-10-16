<?php
/**
 * @version		$Id: page_docedit.tpl.php 1048 2009-12-12 20:37:26Z tom $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');


/*
* Display the move document form (required)
*
* This template is called when u user preform a move operation on a document.
*
* General variables  :
*	$this->theme->path (string) : template path
*	$this->theme->name (string) : template name
*	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Preformatted variables :
*	$this->html->docedit (string)(hardcoded, can change in future versions)
*/
?>

<?php $this->splugin('pagetitle', _DML_TPL_TITLE_EDIT ) ?>

<?php echo $this->plugin('stylesheet', $this->theme->path."css/theme.css") ?>
<?php echo $this->plugin('overlib'); ?>
<?php echo $this->plugin('calendar'); ?>
<?php echo $this->plugin('validator'); ?>

<?php echo $this->html->menu; ?>

<h2 id="dm_title"><?php echo _DML_TPL_TITLE_EDIT;?></h2>

<ul class="dm_toolbar">
<li><a title="Cancel" class="dm_btn_cancel" href="javascript:submitbutton('cancel');" ><?php echo _DML_CANCEL?></a></li>
<li><a title="Save"   class="dm_btn_save"   href="javascript:submitbutton('save');"><?php echo _DML_SAVE?></a></li>
</ul>

<?php echo $this->html->docedit ?>

<ul class="dm_toolbar">
<li><a title="Cancel" class="dm_btn_cancel" href="javascript:submitbutton('cancel');" ><?php echo _DML_CANCEL?></a></li>
<li><a title="Save"   class="dm_btn_save"   href="javascript:submitbutton('save');"><?php echo _DML_SAVE?></a></li>
</ul>

<div class="clr"></div>

<script language="javascript" type="text/javascript">
<!--
	list = document.getElementById('dmthumbnail');
	img  = document.getElementById('dmthumbnail_preview');
	list.onchange = function() {
		var index = list.selectedIndex;
		if(list.options[index].value!='') {
			img.src = '<?php echo JURI::root(true); ?>' + '/images/stories/' + list.options[index].value;
		} else {
			img.src = '<?php echo JURI::root(true); ?>' + '/images/blank.png';
		}
	}
//-->
</script>


