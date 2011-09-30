<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<form action="<?php echo JRoute::_( 'index.php', true, $this->params->get('usesecure')); ?>" method="post" name="com-login">
	<div class="page-header">
		<h1><?php echo JText::_('Login'); ?></h1>
	</div>
	
	<?php if ( $this->params->get( 'description_login' ) ) : ?>
		<p class="login-description"><?php echo $this->params->get( 'description_login_text' ); ?></p>
	<?php endif; ?>
	
	<fieldset>
		<p>
			<label for="username"><?php echo JText::_('Username') ?></label><br />
			<input name="username" type="text" alt="username" />
		</p>
		<p>
			<label for="passwd"><?php echo JText::_('Password') ?></label><br />
			<input type="password" name="passwd" alt="password" />
		</p>
		<?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
		<p>
			<input type="checkbox" id="remember" name="remember" class="inputbox" value="yes" alt="Remember Me" />
			<label for="remember"><?php echo JText::_('Remember me') ?></label>
		</p>
		<?php endif; ?>
		<input type="submit" name="Submit" class="button" value="<?php echo JText::_('LOGIN') ?>" />
	</fieldset>
	<ul>
		<li class="forgot-pass">
			<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=reset' ); ?>">
			<?php echo JText::_('FORGOT_YOUR_PASSWORD'); ?></a>
		</li>
		<li class="forgot-user">
			<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=remind' ); ?>">
			<?php echo JText::_('FORGOT_YOUR_USERNAME'); ?></a>
		</li>
		<?php
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		if ($usersConfig->get('allowUserRegistration')) : ?>
		<li class="register-link">
			<a href="<?php echo JRoute::_( 'index.php?option=com_user&task=register' ); ?>">
				<?php echo JText::_('REGISTER'); ?></a>
		</li>
		<?php endif; ?>
	</ul>

	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />
	<input type="hidden" name="return" value="<?php echo $this->return; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>