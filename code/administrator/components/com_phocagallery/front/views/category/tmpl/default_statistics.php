<?php defined('_JEXEC') or die('Restricted access');

?><div id="phocagallery-statistics">
<?php
echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';//because of IE bug
	
	if ($this->tmpl['displaymaincatstat']) {
		echo '<fieldset>'
			.'<legend>'.JText::_('Category').'</legend>'
			.'<table>'
			.'<tr><td>'.JText::_('Number of published images in category') .': </td>'
			.'<td>'.$this->tmpl['numberimgpub'].'</td></tr>'
			.'<tr><td>'.JText::_('Number of unpublished images in category') .': </td>'
			.'<td>'.$this->tmpl['numberimgunpub'].'</td></tr>'
			.'<tr><td>'.JText::_('Category viewed') .': </td>'
			.'<td>'.$this->tmpl['categoryviewed'].' x</td></tr>'
			.'</table>'
			.'</fieldset>';
	}	

// MOST VIEWED			
if ($this->tmpl['displaymostviewedcatstat']) {
	
	echo '<fieldset><legend>'.JText::_('Most viewed images in category').'</legend>';
		
	if (!empty($this->tmpl['mostviewedimg'])) {
		foreach($this->tmpl['mostviewedimg'] as $key => $value) {
			
			$imageHeightMV 			= PhocaGalleryImage::correctSize($this->tmpl['imageheight'], 100, 100, 0);
			$imageWidthMV 			= PhocaGalleryImage::correctSize($this->tmpl['imagewidth'], 100, 120, 20);
			$imageHeightMV['boxsize']	= PhocaGalleryImage::setBoxSize($imageHeightMV,$imageWidthMV, $this->tmpl['displayname'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $this->tmpl['displayimageshadow'], 1, 0, 0, 0, 0);
			if ( $this->tmpl['displayimageshadow'] != 'none' ) {		
				$imageHeightMV['size']	= $imageHeightMV['size'] + 18;
				$imageWidthMV['size'] 	= $imageWidthMV['size'] + 18;
			}
			
			if (isset($value->extid) && $value->extid != '') {
				$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($value->extw, $value->exth, $this->tmpl['picasa_correct_width_m'], $this->tmpl['picasa_correct_height_m']);
			}
				
			?>
			<div class="phocagallery-box-file" style="height:<?php echo $imageHeightMV['boxsize']; ?>px; width:<?php echo $imageWidthMV['boxsize']; ?>px">
				
					<div class="phocagallery-box-file-first" style="height:<?php echo $imageHeightMV['size']; ?>px;width:<?php echo $imageWidthMV['size']; ?>px;margin:auto">
						<div class="phocagallery-box-file-second">
							<div class="phocagallery-box-file-third">
								
								<a class="<?php echo $value->buttonother->methodname; ?>"<?php
								
								echo ' href="'. $value->link.'"';
								
								if ($this->tmpl['detailwindow'] == 1) {
									echo ' onclick="'. $value->button->options.'"';
								} else if ($this->tmpl['detailwindow'] == 2) {
									echo ' rel="'. $value->button->options.'"';
								} else if ($this->tmpl['detailwindow'] == 4) {
									echo ' onclick="'. $this->tmpl['highslideonclick'].'"';
								} else if ($this->tmpl['detailwindow'] == 5) {
									echo ' onclick="'. $this->tmpl['highslideonclick2'].'"';
								} else if ($this->tmpl['detailwindow'] == 8) {
									echo ' rel="lightbox-'.$this->category->alias.'-mv" ';
								}  else {
									echo ' rel="'. $value->buttonother->options.'"';
								}
								echo ' >';
								if (isset($value->extid) && $value->extid != '') {
									echo JHTML::_( 'image', $value->linkthumbnailpath, $value->altvalue, array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']));
								} else {
									echo JHTML::_( 'image.site', $value->linkthumbnailpath, '', '', '', $value->altvalue );
								}

								?></a>
								
							</div>
						</div>
					</div>
				
				
			<?php
			
			// subfolder
			if ($value->type == 1) {
				if ($value->displayname == 1 || $value->displayname == 2) {
					echo '<div class="phocaname" style="font-size:'.$this->tmpl['fontsizename'].'px">'
					.PhocaGalleryText::wordDelete($value->title, $this->tmpl['charlengthname'], '...').'</div>';
				}
			}
			// image
			if ($value->type == 2) {
				if ($value->displayname == 1) {
					echo '<div class="phocaname" style="font-size:'.$this->tmpl['fontsizename'].'px">'
					.PhocaGalleryText::wordDelete($value->title, $this->tmpl['charlengthname'], '...').'</div>';
				}
				if ($value->displayname == 2) {
					echo '<div class="phocaname" style="font-size:'.$this->tmpl['fontsizename'].'px">&nbsp;</div>';
				}
			}

			echo '<div class="detail" style="margin-top:2px;text-align:left">';
					
			
			echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-viewed.'.$this->tmpl['formaticon'], JText::_('Image Detail'));
			echo '&nbsp;&nbsp; '.$value->hits.' x';
		
			echo '</div>';
			echo '<div style="clear:both"></div>';
			
			echo '</div>';
		}
	}
		
	echo '</fieldset>';

} // END MOST VIEWED

// LAST ADDED	
if ($this->tmpl['displaylastaddedcatstat']) {		

	
	echo '<fieldset>'
		.'<legend>'.JText::_('Last added images in category').'</legend>';
		
	if (!empty($this->tmpl['lastaddedimg'])) {
		
		foreach($this->tmpl['lastaddedimg'] as $key => $value) {
			
			$imageHeightLA 			= PhocaGalleryImage::correctSize($this->tmpl['imageheight'], 100, 100, 0);
			$imageWidthLA 			= PhocaGalleryImage::correctSize($this->tmpl['imagewidth'], 100, 120, 20);
			$imageHeightLA['boxsize']	= PhocaGalleryImage::setBoxSize($imageHeightLA,$imageWidthLA, $this->tmpl['displayname'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $this->tmpl['displayimageshadow'], 1, 0, 0, 0, 0);
			if ( $this->tmpl['displayimageshadow'] != 'none' ) {		
				$imageHeightLA['size']	= $imageHeightLA['size'] + 18;
				$imageWidthLA['size'] 	= $imageWidthLA['size'] + 18;
			}
			if (isset($value->extid) && $value->extid != '') {
				$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($value->extw, $value->exth, $this->tmpl['picasa_correct_width_m'], $this->tmpl['picasa_correct_height_m']);
			}
				
			?>
			<div class="phocagallery-box-file" style="height:<?php echo $imageHeightLA['boxsize']; ?>px; width:<?php echo $imageWidthLA['boxsize']; ?>px">
				
					<div class="phocagallery-box-file-first" style="height:<?php echo $imageHeightLA['size']; ?>px;width:<?php echo $imageWidthLA['size']; ?>px;margin:auto">
						<div class="phocagallery-box-file-second">
							<div class="phocagallery-box-file-third">
								
								<a class="<?php echo $value->buttonother->methodname; ?>"<?php
								
								echo ' href="'. $value->link.'"';
								
								if ($this->tmpl['detailwindow'] == 1) {
									echo ' onclick="'. $value->button->options.'"';
								} else if ($this->tmpl['detailwindow'] == 2) {
									echo ' rel="'. $value->button->options.'"';
								} else if ($this->tmpl['detailwindow'] == 4) {
									echo ' onclick="'. $this->tmpl['highslideonclick'].'"';
								} else if ($this->tmpl['detailwindow'] == 5) {
									echo ' onclick="'. $this->tmpl['highslideonclick2'].'"';
								} else if ($this->tmpl['detailwindow'] == 8) {
									echo ' rel="lightbox-'.$this->category->alias.'-la" ';
								} else {
									echo ' rel="'. $value->buttonother->options.'"';
								}
								
								echo ' >';
								if (isset($value->extid) && $value->extid != '') {
									echo JHTML::_( 'image', $value->linkthumbnailpath, $value->altvalue, array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']));
								} else {
									echo JHTML::_( 'image.site', $value->linkthumbnailpath, '', '', '', $value->altvalue );
								}
								?></a>
								
							</div>
						</div>
					</div>
				
				
			<?php
			
			// subfolder
			if ($value->type == 1) {
				if ($value->displayname == 1 || $value->displayname == 2) {
					echo '<div class="phocaname" style="font-size:'.$this->tmpl['fontsizename'].'px">'
					.PhocaGalleryText::wordDelete($value->title, $this->tmpl['charlengthname'], '...').'</div>';
				}
			}
			// image
			if ($value->type == 2) {
				if ($value->displayname == 1) {
					echo '<div class="phocaname" style="font-size:'.$this->tmpl['fontsizename'].'px">'
					.PhocaGalleryText::wordDelete($value->title, $this->tmpl['charlengthname'], '...').'</div>';
				}
				if ($value->displayname == 2) {
					echo '<div class="phocaname" style="font-size:'.$this->tmpl['fontsizename'].'px">&nbsp;</div>';
				}
			}

			echo '<div class="detail" style="margin-top:2px;text-align:left">';
					
			echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-date.'.$this->tmpl['formaticon'], JText::_('Image Detail'));
			echo '&nbsp;&nbsp; '.JHTML::Date($value->date, "%d. %m. %Y");
			
		
			echo '</div>';
			echo '<div style="clear:both"></div>';
			
			echo '</div>';
		}
	}

	echo '</fieldset>';

}// END MOST VIEWED	
?>
</div>
