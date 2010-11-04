<?php
/**
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
* Basis stuff
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/rhuk_milkyway_police/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/rhuk_milkyway_police/css/<?php echo $this->params->get('colorVariation'); ?>.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/rhuk_milkyway_police/css/<?php echo $this->params->get('backgroundVariation'); ?>_bg.css" type="text/css" />
<!--[if lte IE 6]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
<![endif]-->
<?php if($this->direction == 'rtl') : ?>
	<link href="<?php echo $this->baseurl ?>/templates/rhuk_milkyway_police/css/template_rtl.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

<?php if($site = JFactory::getApplication()->getSite()) : ?>
<style>
div#logo {
	background-image: url(/sites/<?php echo $site; ?>/logo.png);
}
</style>
<?php endif; ?>
</head>
<body id="page_bg" class="color_<?php echo $this->params->get('colorVariation'); ?> bg_<?php echo $this->params->get('backgroundVariation'); ?> width_<?php echo $this->params->get('widthStyle'); ?>">
<a name="up" id="up"></a>
<div class="center" align="center">


	<div id="wrapper">
		<div id="wrapper_r">
			<div id="header">
				<div id="header_l">
					<div id="header_r">
						<div id="logo"></div>
						<jdoc:include type="modules" name="top" />
					</div>
				</div>
			</div>

			<div id="tabarea">
				<div id="tabarea_l">
					<div id="tabarea_r">
						<div id="tabmenu">
						<table cellpadding="0" cellspacing="0" class="pill" border="0">
							<tr>
								<td class="pill_l">&nbsp;</td>
								<td class="pill_m">
									<div id="pillmenu">
									<jdoc:include type="modules" name="user3" />
									</div>
								</td>

								<td class="pill_r">&nbsp;</td>
								<td width="25">&nbsp;</td>
								<td>
									<div id="search">
									<jdoc:include type="modules" name="user4" />
									</div>
								</td>
							</tr>
							</table>
						</div>
					</div>
				</div>
			</div>

<table align="center" border="0" width="980" height="120">
     <tr>
          <td valign="middle">

               <jdoc:include type="modules" name="banner" />
                       </td>
     </tr>
</table>
		

			<div id="pathway">
				<jdoc:include type="module" name="breadcrumbs" />
			</div>

			<div class="clr"></div>

			<div id="whitebox">
				<div id="whitebox_t">
					<div id="whitebox_tl">
						<div id="whitebox_tr"></div>
					</div>
				</div>

				<div id="whitebox_m"><jdoc:include type="message" />
					<div id="area">
						<div id="leftcolumn">
						<?php if($this->countModules('left')) : ?>
							<jdoc:include type="modules" name="left" style="rounded" />
						<?php endif; ?>
						</div>

						<?php if($this->countModules('left')) : ?>
						<div id="maincolumn">
						<?php else: ?>
						<div id="maincolumn_full">
						<?php endif; ?>
							<?php if($this->countModules('user1 or user2')) : ?>
								<table class="nopad user1user2">
									<tr valign="top">
										<?php if($this->countModules('user1')) : ?>
											<td>
												<jdoc:include type="modules" name="user1" style="xhtml" />
											</td>
										<?php endif; ?>
										<?php if($this->countModules('user1 and user2')) : ?>
											<td class="greyline">&nbsp;</td>
										<?php endif; ?>
										<?php if($this->countModules('user2')) : ?>
											<td>
												<jdoc:include type="modules" name="user2" style="xhtml" />
											</td>
										<?php endif; ?>
									</tr>
								</table>

								<div id="maindivider"></div>
							<?php endif; ?>

							<table border="0" class="nopad">
								<tr valign="top">
									<td>
										<?php if($this->params->get('showComponent')) : ?>
											<jdoc:include type="component" />
										<?php endif; ?>
									</td>
									<?php if($this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>
										<td class="greyline">&nbsp;</td>
										<td width="170">
											<jdoc:include type="modules" name="right" style="xhtml"/>
										</td>
									<?php endif; ?>
								</tr>
							</table>

						</div>
						<div class="clr"></div>
					</div>
					<div class="clr"></div>
				</div>

				<div id="whitebox_b">
					<div id="whitebox_bl">
						<div id="whitebox_br"></div>
					</div>
				</div>
			</div>

			<div id="footerspacer"></div>
		</div>

		<div id="footer">
			<div id="footer_l">
				<div id="footer_r">
					<p style="float:left; padding-left: 25px;">
						<jdoc:include type="modules" name="syndicate" />
					</p>
				<p style="float:right; padding-right: 25px;">
     				 	 <table border="0" align="right" valign="top"><tr><td>Copyright VCLP-CPPL <?php echo date("Y") ?><sup>&copy;</sup> | <a href="http://217.21.184.146/5415/index.php?option=com_content&view=article&id=308&Itemid=94" target="_self">Disclaimer</a> | <a href="http://217.21.184.146/5415/index.php?option=com_content&view=article&id=504&Itemid=93" target="_self">Privacy</a><td><a href="http://www.belgium.be" target="_blank"><img src="templates/rhuk_milkyway_police/images/smallbe.gif" border="0"></a><td><jdoc:include type="modules" name="counter" /></tr></table>


    				</p>
				</div>
			</div>
		</div>
	</div>
</div>
<jdoc:include type="modules" name="debug" />

<script type="text/javascript">
var clicky = { log: function(){ return; }, goal: function(){ return; }};
var clicky_site_id = 207804;
(function() {
  var s = document.createElement('script');
  s.type = 'text/javascript';
  s.async = true;
  s.src = ( document.location.protocol == 'https:' ? 'https://static.getclicky.com' : 'http://static.getclicky.com' ) + '/js';
  ( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( s );
})();
</script>
<a title="Real Time Web Analytics" href="http://getclicky.com/207804"></a>
<noscript><p><img alt="Clicky" width="1" height="1" src="http://in.getclicky.com/207804ns.gif" /></p></noscript>

</body>
</html>