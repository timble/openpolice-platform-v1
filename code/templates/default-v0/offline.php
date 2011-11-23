<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$version = '12';
$language = explode("-", $this->language);
$language = $language[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
	<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/layout.min.css?version=<?php echo $version ?>" type="text/css" />
	
	<script type="text/javascript">
	 var _gaq = _gaq || [];
	 _gaq.push(['_setAccount', 'UA-20242887-1']);
	 _gaq.push(['_setCookiePath', '/<?php echo JFactory::getApplication()->getSite(); ?>/']);
	 _gaq.push(['_trackPageview']);
	
	 (function() {
	   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	 })();
	</script>
</head>
<body>
	<div id="header">
		<div id="banner" class="container_12 clearfix inner <?php echo $language; ?>">
			<div class="grid_4 alpha">
				<div class="contact">
					<jdoc:include type="modules" name="call" style="call" />
				</div>
				<div id="sitename">
	                <?php $home = JSite::getMenu()->getDefault() ?>
					<a href="<?php echo JRoute::_($home->link.'&Itemid='.$home->id) ?>"><jdoc:include type="modules" name="sitename" style="sitename" /></a>
				</div>
			</div>
			<?php if($this->countModules('user4')) : ?>
			<div id="search" class="grid_3 push_5">
				<jdoc:include type="modules" name="user4" style="search" />
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div id="main">
		<div class="container_16 clearfix inner">
			<div id="maincol" class="grid_12 push_2">
				<jdoc:include type="message" />
				<div id="component" class="outline">
					<h1>
						<?php echo $mainframe->getCfg('offline_message'); ?>
					</h1>
					<form action="index.php" method="post" name="login" id="form-login">
					<fieldset class="input">
						<p id="form-login-username">
							<label for="username"><?php echo JText::_('Username') ?></label><br />
							<input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_('Username') ?>" size="18" />
						</p>
						<p id="form-login-password">
							<label for="passwd"><?php echo JText::_('Password') ?></label><br />
							<input type="password" name="passwd" class="inputbox" size="18" alt="<?php echo JText::_('Password') ?>" id="passwd" />
						</p>
						<p id="form-login-remember">
							<label for="remember"><?php echo JText::_('Remember me') ?></label>
							<input type="checkbox" name="remember" class="inputbox" value="yes" alt="<?php echo JText::_('Remember me') ?>" id="remember" />
						</p>
						<input type="submit" name="Submit" class="button" value="<?php echo JText::_('LOGIN') ?>" />
					</fieldset>
					<input type="hidden" name="option" value="com_user" />
					<input type="hidden" name="task" value="login" />
					<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
					<?php echo JHTML::_( 'form.token' ); ?>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="footer" class="container_12 clearfix">
		<div class="grid_12">
			<ul>
				<li>Copyright - <?php echo JText::_('Local Police'); ?> - <jdoc:include type="modules" name="sitename" style="sitename" /> <?php echo date("Y"); ?>©</li>
				<li><a target="_blank" href="http://www.lokalepolitie.be/portal/<?php echo $language == 'de' ? 'nl' : $language; ?>/disclaimer.html">Disclaimer</a></li>
				<li><a target="_blank" href="http://www.lokalepolitie.be/portal/<?php echo $language == 'de' ? 'nl' : $language; ?>/privacy.html">Privacy</a></li>
				<li><a target="_blank" href="http://www.belgium.be"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/icon_belgium.gif" border="0"></a></li>
			</ul>
		</div>
	</div>
</body>
</html>