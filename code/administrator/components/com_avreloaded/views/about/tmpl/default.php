<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="editcell">
<?php readfile($this->welcome); ?>
</div>
<div id="changelogs">
<a href="#" onclick="window.open('<?php echo $this->changelog; ?>','maincl','status=no,toolbar=no,scrollbars=yes,titlebar=yes,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no');"><strong>Component ChangeLog</strong></a>
</div>
