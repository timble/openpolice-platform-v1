<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<h1><?php echo JText::_('Confirm your Account'); ?></h1>
<p><?php echo JText::_('RESET_PASSWORD_CONFIRM_DESCRIPTION'); ?></p>
<form action="<?php echo JRoute::_( 'index.php?option=com_user&amp;task=confirmreset' ); ?>" method="post" class="form-validate">
	<p>
		<label for="token"><?php echo JText::_('Token'); ?>:</label><br />
		<input id="token" name="token" type="text" class="required" size="36" />
	</p>
	<button type="submit" class="validate"><?php echo JText::_('Submit'); ?></button>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>