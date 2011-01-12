<?php
/**
 * @version		$Id: step_3.tpl.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the
 				original copyright holder. This file is not licensed under the GPL.
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/*
* Display the upload document form (required)
*
* This template is called when u user preform a upload operation on a document.
*
* General variables  :
*	$this->theme->path (string) : template path
*	$this->theme->name (string) : template name
*	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Template variables :
*	$this->step (number)  : holds the current step
*
* Preformatted variables :
*	$this->html->docupload (string)(hardcoded, can change in future versions)
*
*/
?>
<?php /*
<script><?php include $this->loadTemplate('scripts'.DS.'form_docedit.tpl.php'); ?></script>
*/ ?>

<?php echo $this->plugin('calendar'); ?>
<?php echo $this->plugin('validator', array('step' => $this->step)); ?>

<style>
	select option.label { background-color: #EEE; border: 1px solid #DDD; color : #333; }
</style>

<p><?php echo _DML_TPL_UPLOAD_STEP." ".$this->step." "._DML_TPL_UPLOAD_OF." 3" ;?></p>

<ul class="dm_toolbar">
<li><a title="Cancel" class="dm_btn_cancel" href="javascript:submitbutton('cancel');" ><?php echo _DML_CANCEL?></a></li>
<li><a title="Save"   class="dm_btn_save"   href="javascript:submitbutton('save');"><?php echo _DML_SAVE?></a></li>
</ul>

<?php echo $this->html->docupload ?>

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
			img.src = 'images/stories/' + list.options[index].value;
		} else {
			img.src = 'images/blank.png';
		}
	}
//-->
</script>

