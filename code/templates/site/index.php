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
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/site/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/site/css/<?php echo $this->params->get('colorVariation'); ?>.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/site/css/<?php echo $this->params->get('backgroundVariation'); ?>_bg.css" type="text/css" />
<!--[if lte IE 6]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
<![endif]-->

<?php if($site = JFactory::getApplication()->getSite()) : ?>
<style>
div#logo {
	background-image: url(/sites/<?php echo $site; ?>/logo.png);
}
</style>
<?php endif; ?>

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
						<jdoc:include type="modules" name="language" style="rounded" />
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
										<jdoc:include type="component" />
									</td>
									<?php if($this->countModules('right') and JRequest::getCmd('task') != 'edit') : ?>
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
     				 	 <table border="0" align="right" valign="top"><tr><td>Copyright VCLP-CPPL <?php echo date("Y") ?><sup>&copy;</sup> | <a>Disclaimer</a> | <a>Privacy</a><td><a href="http://www.belgium.be" target="_blank"><img src="templates/site/images/smallbe.gif" border="0"></a><td></tr></table>
    				</p>
				</div>
			</div>
		</div>
	</div>
</div>
<jdoc:include type="modules" name="debug" />
</body>
</html>