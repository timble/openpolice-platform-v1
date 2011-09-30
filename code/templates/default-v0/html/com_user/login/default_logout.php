<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<form action="index.php" method="post" name="login">
	<div class="page-header">
		<h1><?php echo JText::_('Login'); ?></h1>
	</div>
	<?php if ($this->params->get('description_logout')) : ?>
		<p><?php echo $this->params->get('description_logout_text'); ?></p>
	<?php endif; ?>

	<input type="submit" name="Submit" value="<?php echo JText::_( 'Logout' ); ?>" />
	
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="logout" />
	<input type="hidden" name="return" value="<?php echo $this->return; ?>" />
</form>