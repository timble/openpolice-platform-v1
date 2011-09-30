<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="page-header">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>
<p><?php echo JText::_('RESET_PASSWORD_REQUEST_DESCRIPTION'); ?></p>
<form action="<?php echo JRoute::_( 'index.php?option=com_user&task=requestreset' ); ?>" method="post" class="form-validate">
	<p>
		<label for="email"><?php echo JText::_('Email Address'); ?>:</label>
		<input name="email" id="email" type="text" class="required validate-email" />
	</p>
	<input type="submit" name="Submit" class="validate" value="<?php echo JText::_('Submit') ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>