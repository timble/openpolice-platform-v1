<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<script type="text/javascript">
<!--
	Window.onDomReady(function(){
		document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);
	});
// -->
</script>

<?php
	if(isset($this->message)){
		$this->display('message');
	}
?>
<div class="page-header">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>
<p><?php echo JText::_( 'REGISTER_REQUIRED' ); ?></p>

<form action="<?php echo JRoute::_( 'index.php?option=com_user' ); ?>" method="post" id="josForm" name="josForm" class="form-validate">
	<p>
		<label for="name"><?php echo JText::_( 'Name' ); ?> <span class="req">*</span> </label><br />
  		<input type="text" name="name" id="name" size="40" value="<?php echo $this->user->get( 'name' );?>" class="required" maxlength="50" />
  	</p>
	<p>
		<label for="username"><?php echo JText::_( 'User name' ); ?> <span class="req">*</span> </label><br />
		<input type="text" id="username" name="username" size="40" value="<?php echo $this->user->get( 'username' );?>" class="required validate-username" maxlength="25" />
	</p>
	<p>
		<label for="email"><?php echo JText::_( 'Email' ); ?> <span class="req">*</span> </label><br />
		<input type="text" id="email" name="email" size="40" value="<?php echo $this->user->get( 'email' );?>" class="required validate-email" maxlength="100" />
	</p>
	<p>
		<label for="password"><?php echo JText::_( 'Password' ); ?> <span class="req">*</span> </label><br />
  		<input class="required validate-password" type="password" id="password" name="password" size="40" value="" />
  	</p>
	<p>
		<label for="password2"><?php echo JText::_( 'Verify Password' ); ?> <span class="req">*</span> </label><br />
		<input class="required validate-passverify" type="password" id="password2" name="password2" size="40" value="" />
	</p>
	<button class="button validate" type="submit"><?php echo JText::_('Register'); ?></button>
	<input type="hidden" name="task" value="register_save" />
	<input type="hidden" name="id" value="0" />
	<input type="hidden" name="gid" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>