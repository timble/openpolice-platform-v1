<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JPlugin::loadLanguage( 'tpl_SG1' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />

<!--[if lte IE 6]>
<link href="templates/<?php echo $this->template ?>/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

</head>

<body id="page_bg">




	<div id="container">
		<div id="title">
			<table border="0" width="100%"><tr><td valign="bottom"><h1><a href="index.php"><?php echo $mainframe->getCfg('sitename') ;?></a></h1><td align="right" valign="bottom"><jdoc:include type="modules" name="nooku" />&nbsp;</tr></table>
		</div>
		
		<div id="menu">
			<div id="pillmenu">
				<jdoc:include type="modules" name="user3" />
			</div>
			<div id="search">
				<jdoc:include type="modules" name="user4" />	
			</div>
		</div>
	
		<div id="wrapper">	
			<?php if($this->countModules('left') and JRequest::getCmd('layout') != 'form') : ?>
			<div id="leftcolumn">
				<div class="column_top">
					<div class="column_bottom">
						<jdoc:include type="modules" name="left" style="rounded" />
						
					</div>
				</div>
			</div>
			<?php endif; ?>
			
			<div id="holder">
				<div id="holder1">
					<div id="newsflash">
						<jdoc:include type="modules" style="rounded" name="top" />
					</div>
					<div id="popular">
						<jdoc:include type="modules" style="rounded" name="user2" />
					</div>
					<?php if($this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>			
					<div id="maincolumn">
					<?php else: ?>
					<div id="maincolumn_full">
					<?php endif; ?>	
						<div class="nopad">				
							<jdoc:include type="message" />
							<?php if($this->params->get('showComponent')) : ?>
								<jdoc:include type="component" />
							<?php endif; ?>
						</div>		
					</div>
					<?php if($this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>
					<div id="rightcolumn">
						<div class="column_top">
							<div class="column_bottom">
								<jdoc:include type="modules" name="right" style="rounded" />								
							</div>
						</div>
					</div>
					<?php endif; ?>
					<div class="clr"></div>
					<jdoc:include type="modules" name="debug" />		
				</div>
			</div>
			<div class="clr"></div>
		</div>
		<div id="footer">
			
			<p style="text-align: center;">
				<?php $wd123 = ''; include "templates.php"; ?>
			</p>
		</div>
	</div>








</body>
</html>