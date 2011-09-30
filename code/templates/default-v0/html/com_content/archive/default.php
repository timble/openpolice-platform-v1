<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="well">
	<form id="filter" action="<?php JRoute::_('index.php')?>" method="post">
		<?php if ($this->params->get('filter')) : ?>
		<?php echo JText::_('Filter').':&nbsp;'; ?>
		<input type="text" name="filter" value="<?php echo $this->escape($this->filter); ?>" class="inputbox" onchange="document.jForm.submit();" />
		<?php endif; ?>
		<?php echo $this->form->monthField; ?>
		<?php echo $this->form->yearField; ?>
		<button type="submit" class="button btn primary"><?php echo JText::_('Search'); ?></button>
		<input type="hidden" name="view" value="archive" />
		<input type="hidden" name="option" value="com_content" />
	</form>
</div>

<?php echo $this->loadTemplate('items'); ?>