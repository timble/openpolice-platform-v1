<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<h1><?php echo JText::_('Reset your Password'); ?></h1>
<p><?php echo JText::_('RESET_PASSWORD_COMPLETE_DESCRIPTION'); ?></p>

<form action="<?php echo JRoute::_( 'index.php?option=com_user&task=completereset' ); ?>" method="post" class="form-validate">
	<p>
		<label for="password1"><?php echo JText::_('Password'); ?>:</label><br />
		<input id="password1" name="password1" type="password" class="required validate-password" />
	</p>
	<p>
		<label for="password2"><?php echo JText::_('Verify Password'); ?>:</label><br />
		<input id="password2" name="password2" type="password" class="required validate-password" />
	</p>
	<button type="submit" class="validate"><?php echo JText::_('Submit'); ?></button>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>