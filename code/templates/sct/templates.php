<?if( $wd123 == 'banner' ):?>
<div style="width:140px;text-align:center;margin:0 auto;">
	<table style="width:140px;text-align:left;" cellpadding="0" cellspacing="0">
		<tr>
			<td><font class="f123_1">Designed by:</font></td>
		</tr>
	</table>
	
	<div class="f123_bg">
	<table style="width:134px;height:30px;text-align:center;border:none;" cellpadding="0" cellspacing="0">
		<tr>
			<td><img src="templates/<?php echo $this->template ?>/images/123_l_img.png" style="width:40px;height:24px;" title="Web Design Services" alt="Web Design Services" /></td>
			<td style="width:94px;height:30px;text-align:center;">
				<a href="http://www.123webdesign.com/" class="link_123" title="Web Design Services">web design</a>
			</td>
		</tr>
	</table>
	</div>
</div>
<?else:?>
 	<?php echo $mainframe->getCfg('sitename') ;?>, Powered by <a href="http://joomla.org/" class="footer123" target="_blank">Joomla!</a> and designed by <a href="http://www.123webdesign.com/" target="_blank" class="footer123" title="Web Design Services">123WebDesign</a>
<?endif;?>