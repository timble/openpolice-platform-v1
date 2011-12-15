<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once("includes/grid.php");

$version = '17';
$language = explode("-", $this->language);
$language = $language[0];

$site = JFactory::getApplication()->getSite();
//$site = null;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD xhtmls 1.0 Transitional//EN" "http://www.w3.org/TR/xhtmls1/DTD/xhtmls1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtmls" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
	<jdoc:include type="head" />
	
	<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/layout.min.css?version=<?php echo $version ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/print.css?version=<?php echo $version ?>" type="text/css" media="print" />
	
	<?php JHTML::_('behavior.modal'); ?>
	
	<!--[if lt IE 7]>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie6.css?version=<?php echo $version ?>" type="text/css" />
	<![endif]-->
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie7.css?version=<?php echo $version ?>" type="text/css" />
	<![endif]-->
	
	<?php if(substr($_SERVER['HTTP_USER_AGENT'], 25, 8) != "MSIE 6.0" && JRequest::getCmd('option') == 'com_content' && JRequest::getCmd('view') == 'article') : ?>
	<script type="text/javascript">var switchTo5x=true;</script><script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'91c73e48-a5e0-43ea-988f-57d099f878c7'});</script>
	<?php endif; ?>
	
	<?php if($site) : ?>
	<script type="text/javascript">
	 var _gaq = _gaq || [];
	 _gaq.push(['_setAccount', 'UA-20242887-1']);
	 _gaq.push(['_setCookiePath', '/<?php echo $site ?>/']);
	 _gaq.push(['_trackPageview']);
	
	 (function() {
	   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	 })();
	</script>
	<?php endif; ?>
</head>
<body>
	<?php if($this->countModules('user3') || $this->countModules('language')) : ?>
	<div id="top">
		<div class="container_12 clearfix inner">
			<div class="grid_<?php echo $this->countModules('language') ? '9' : '12' ?>">
				<jdoc:include type="modules" name="user3" style="user3" />
			</div>
			<?php if($this->countModules('language')) : ?>
			<div class="grid_3">
				<jdoc:include type="modules" name="language" style="language" />
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<div id="header">
		<div id="banner" class="container_12 clearfix inner site<?php echo $site; ?> <?php echo $language; ?>">
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
			<div id="left" class="grid_4">
				<div class="boxed">
					<jdoc:include type="modules" name="left" style="xhtmls" />
				</div>
				<div class="unboxed">
					<jdoc:include type="modules" name="top" style="xhtmls" />
				</div>
			</div>
			<div id="maincol" class="grid_12">
				<?php if($this->countModules('breadcrumbs')) : ?>
				<div id="breadcrumbs" class="grid_12 alpha">
					<jdoc:include type="modules" name="breadcrumbs" style="notitle" />
				</div>
				<?php endif; ?>
				<?php if($this->countModules('user1 or user2')) : ?>
				<div id="pre-component" class="clearfix">
					<?php if($this->countModules('user1')) : ?>
					<div class="grid_<?php echo $this->countModules('user2') ? '6' : '12' ?> <?php echo $this->countModules('user2') ? 'alpha' : 'alpha omega' ?>">
						<jdoc:include type="modules" name="user1" style="xhtmls" />
					</div>
					<?php endif; ?>
					<?php if($this->countModules('user2')) : ?>
					<div class="grid_<?php echo $this->countModules('user1') ? '6' : '12' ?> <?php echo $this->countModules('user1') ? 'omega' : 'alpha omega' ?>">
						<jdoc:include type="modules" name="user2" style="xhtmls" />
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<div id="component" class="grid_<?php echo $main_component ?> alpha">
					<jdoc:include type="message" />
					<jdoc:include type="component" />
				</div>
				<?php if($this->countModules('right')) : ?>
				<div id="right" class="grid_<?php echo $main_right ?> omega">
					<jdoc:include type="modules" name="right" style="xhtmls" />
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div id="footer" class="container_12 clearfix">
		<div class="grid_12">
			<jdoc:include type="modules" name="syndicate" style="syndicate" />
			<ul>
				<li>Copyright - <?php echo JText::_('Local Police'); ?> - <jdoc:include type="modules" name="sitename" style="sitename" /> <?php echo date("Y"); ?>©</li>
				<li><a target="_blank" href="http://www.lokalepolitie.be/portal/<?php echo $language == 'de' ? 'nl' : $language; ?>/disclaimer.html">Disclaimer</a></li>
				<li><a target="_blank" href="http://www.lokalepolitie.be/portal/<?php echo $language == 'de' ? 'nl' : $language; ?>/privacy.html">Privacy</a></li>
				<li><a target="_blank" href="http://www.belgium.be"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/icon_belgium.gif" border="0"></a></li>
			</ul>
		</div>
	</div>
	<jdoc:include type="modules" name="debug" />
</body>
</html>