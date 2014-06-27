<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
if (!isset($this->error)) {
	$this->error = JError::raiseWarning( 403, JText::_('ALERTNOTAUTH') );
	$this->debug = false; 
}

$version = '34';
$language = explode("-", $this->language);
$language = $language[0];

$site = JFactory::getApplication()->getSite();
//$site = null;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->error->code ?> - <?php echo $this->title; ?></title>
	
	<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/layout.min.css?version=<?php echo $version ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/print.css?version=<?php echo $version ?>" type="text/css" media="print" />
	
	<!--[if lt IE 7]>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie6.css?version=<?php echo $version ?>" type="text/css" />
	<![endif]-->
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie7.css?version=<?php echo $version ?>" type="text/css" />
	<![endif]-->
	
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-20242887-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body>
	<div id="top">
		<div class="container_12 clearfix inner">
			<div class="grid_12">
				<div class="module">
					<ul>
                        <?php $home = JSite::getMenu()->getDefault() ?>
						<li><a href="<?php echo JRoute::_($home->link.'&Itemid='.$home->id) ?>">Home</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="header">
		<div id="banner" class="container_12 clearfix inner site<?php echo $site; ?> <?php echo $language; ?>">
			<div class="grid_12 alpha">
				<div class="contact">
					
				</div>
				<div id="sitename">
					<a href="<?php echo JRoute::_($home->link.'&Itemid='.$home->id) ?>"><?php echo substr(JFactory::getApplication()->getCfg('sitename'), 0, 30) ?></a>
				</div>
			</div>
		</div>
	</div>
	<div id="main">
		<div class="container_12 clearfix inner">
			<div id="maincol" class="grid_12">
				<div id="component" class="grid_7 push_3">
					<h1><?php echo $this->error->code ?> - <?php echo $this->error->message ?></h1>
					<p><strong><?php echo JText::_('You may not be able to visit this page because of:'); ?></strong></p>
						<ol>
							<li><?php echo JText::_('An out-of-date bookmark/favourite'); ?></li>
							<li><?php echo JText::_('A search engine that has an out-of-date listing for this site'); ?></li>
							<li><?php echo JText::_('A mis-typed address'); ?></li>
							<li><?php echo JText::_('You have no access to this page'); ?></li>
							<li><?php echo JText::_('The requested resource was not found'); ?></li>
							<li><?php echo JText::_('An error has occurred while processing your request.'); ?></li>
						</ol>
					<p><strong><?php echo JText::_('Please try one of the following pages:'); ?></strong></p>
					<p>
						<ul>
							<li><a href="<?php echo JRoute::_($home->link.'&Itemid='.$home->id) ?>" title="<?php echo JText::_('Go to the home page'); ?>"><?php echo JText::_('Home Page'); ?></a></li>
						</ul>
					</p>
					<div id="techinfo">
					<p>
						<?php if($this->debug) :
							echo $this->renderBacktrace();
						endif; ?>
					</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="footer" class="container_12">
		<div class="grid_12">
			<ul>
				<li>Copyright <?php echo JFactory::getApplication()->getCfg('sitename') ?> <?php echo date('Y') ?>©</li>
			</ul>	
		</div>
	</div>
</body>
</html>
