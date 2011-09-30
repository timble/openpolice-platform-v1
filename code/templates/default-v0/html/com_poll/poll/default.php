<?php // no direct access
defined('_JEXEC') or die('Restricted access');
?>

<?php JHTML::_('stylesheet', 'poll_bars.css', 'components/com_poll/assets/'); ?>

<div class="page-header">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>

<form action="index.php" method="post" name="poll" id="filter">
	<div class="contentpane<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<label for="id">
			<?php echo JText::_('Select Poll').':&nbsp;'; ?>
			<?php echo $this->lists['polls']; ?>
		</label>
	</div>
</form>

<div class="contentpane<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php echo $this->loadTemplate('graph'); ?>
</div>