<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<script type="text/javascript">
<!--
	Window.onDomReady(function(){
		document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);
	});
// -->
</script>

<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="userform" autocomplete="off" class="form-validate">
	<div class="page-header">
		<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
	</div>
	<p>
		<label for="username"><?php echo JText::_( 'User Name: ' ); ?></label>
		<?php echo $this->user->get('username');?>
	</p>
	<p>	
		<label for="name"><?php echo JText::_( 'Your Name: ' ); ?></label><br />
		<input class="text-input required" type="text" id="name" name="name" value="<?php echo $this->user->get('name');?>" size="40" />
	</p>
	<p>
		<label for="email"><?php echo JText::_( 'Email' ); ?></label><br />
		<input class="text-input required validate-email" type="text" id="email" name="email" value="<?php echo $this->user->get('email');?>" size="40" />
	</p>
	<?php if($this->user->get('password')) : ?>
	<p>
		<label for="password"><?php echo JText::_( 'Password: ' ); ?></label><br />
		<input class="text-input validate-password" type="password" id="password" name="password" value="" size="40" />
	</p>
	<p>
		<label for="password2"><?php echo JText::_( 'Verify Password: ' ); ?></label><br />
		<input class="validate-passverify" type="password" id="password2" name="password2" size="40" />
	</p>
	<?php endif; ?>
		
	<?php if(isset($this->params)) : $this->params->render( 'params' ); endif; ?>
	<button class="validate" type="submit" onclick="submitbutton( this.form );return false;"><?php echo JText::_('Save'); ?></button>
	<input type="hidden" name="username" value="<?php echo $this->user->get('username');?>" />
	<input type="hidden" name="id" value="<?php echo $this->user->get('id');?>" />
	<input type="hidden" name="gid" value="<?php echo $this->user->get('gid');?>" />
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="save" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>