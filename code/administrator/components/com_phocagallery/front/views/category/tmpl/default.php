<?php defined('_JEXEC') or die('Restricted access'); ?>
<!-- <div><a>www.phoca.cz - Begin Category -->
<?php
// Heading
$heading = '';
if ($this->params->get( 'page_title' ) != '') {
	$heading .= $this->params->get( 'page_title' );
}
// Category Name Title
if ( $this->tmpl['displaycatnametitle'] == 1) {
	if ($this->category->title != '') {
		if ($heading != '') {
			$heading .= ' - ';
		}
		$heading .= $this->category->title;
	}
}
// Pagetitle
if ($this->tmpl['showpagetitle'] != 0) {
	if ( $heading != '') {
	    echo '<div class="componentheading'.$this->params->get( 'pageclass_sfx' ).'">'.$heading.'</div>'. "\n";
	} 
}
// Image, description
echo '<div class="contentpane'.$this->params->get( 'pageclass_sfx' ).'">';
if ( @$this->tmpl['image'] || @$this->category->description ) {
	echo '<div class="contentdescription'.$this->params->get( 'pageclass_sfx' ).'">';
	if ( isset($this->tmpl['image']) ) {
		echo $this->tmpl['image'];
	}
	echo $this->category->description.'</div>'. "\n";
}
echo '</div>';

// Phoca Gallery Width
if ($this->tmpl['phocagallerywidth'] != '') {
	$centerPage = '';
	if ($this->tmpl['phocagallerycenter'] == 1 || $this->tmpl['phocagallerycenter'] == 3) {
		$centerPage = 'margin: auto;';
	}
	echo '<div id="phocagallery" style="width:'. $this->tmpl['phocagallerywidth'].'px;'.$centerPage.'">'. "\n";
} else {
	echo '<div id="phocagallery">'. "\n";
}



// Detail Window
if ($this->tmpl['detailwindow'] == 7 || $this->tmpl['display_comment_nopup'] == 1) {
	$tmplCom	= '';
} else {
	$tmplCom 	= '&tmpl=component';
}
// Switch image
$noBaseImg 	= false;
$noBaseImg	= preg_match("/phoca_thumb_l_no_image/i", $this->tmpl['basicimage']);
if ($this->tmpl['switchimage'] == 1 && $noBaseImg == false) {
	$switchImage = PhocaGalleryImage::correctSwitchSize($this->tmpl['switchheight'], $this->tmpl['switchwidth']);
	echo '<div class="main-switch-image"><center>'
		.'<table border="0" cellspacing="5" cellpadding="5" class="main-switch-image-table">'
		.'<tr>'
		.'<td align="center" valign="middle" style="text-align:center;'
		.'width: '.$switchImage['width'].'px;'
		.'height: '.$switchImage['height'].'px;'
		.'background: url(\''.$this->tmpl['waitimage'].'\') '
		.$switchImage['centerw'] .'px '
		.$switchImage['centerh'].'px no-repeat;margin:0px;padding:0px;">'
		.$this->tmpl['basicimage'] .'</td>'
		.'</tr></table></center></div>'. "\n";
}

// Categories View in Category View -
if ($this->tmpl['displaycategoriescv']) {
	echo $this->loadTemplate('categories');
}
// - - - - - - - - - - - - - - - - - 

// Height of all boxes
$imageHeight 			= PhocaGalleryImage::correctSize($this->tmpl['imageheight'], 100, 100, 0);
$imageWidth 			= PhocaGalleryImage::correctSize($this->tmpl['imagewidth'], 100, 120, 20);
$imageHeight['boxsize']	= PhocaGalleryImage::setBoxSize(
	$imageHeight,
	$imageWidth, 
	$this->tmpl['displayname'], 
	$this->tmpl['displayicondetail'], 
	$this->tmpl['displayicondownload'], 
	$this->tmpl['displayiconvmbox'], 
	$this->tmpl['startpiclens'], 
	$this->tmpl['trash'], 
	$this->tmpl['publishunpublish'], 
	$this->tmpl['displayicongeobox'], 
	$this->tmpl['displaycamerainfo'], 
	$this->tmpl['displayiconextlink1box'], 
	$this->tmpl['displayiconextlink2box'], 
	$this->tmpl['categoryboxspace'], 
	$this->tmpl['displayimageshadow'], 
	$this->tmpl['displayratingimg'],  
	$this->tmpl['displayiconfolder'], 
	$this->tmpl['imgdescboxheight'], 
	$this->tmpl['approvednotapproved'], 
	$this->tmpl['displayiconcommentimgbox']);
	
if ( $this->tmpl['displayimageshadow'] != 'none' ) {		
	$imageHeight['size']	= $imageHeight['size'] + 18;
	$imageWidth['size'] 	= $imageWidth['size'] + 18;
}

//$miniHS = '';

// Images	

if (!empty($this->items)) {
	foreach($this->items as $key => $value) {
		echo "\n\n";
		echo '<div class="phocagallery-box-file" style="height:'. $imageHeight['boxsize'].'px; width:'.$imageWidth['boxsize'].'px;">';
		echo '<div class="phocagallery-box-file-first" style="height:'.$imageHeight['size'].'px;width:'.$imageWidth['size'].'px;margin: auto">';
		echo '<div class="phocagallery-box-file-second">';
		echo '<div class="phocagallery-box-file-third">';
		
		echo '<a class="'.$value->button->methodname.'"';
		if ($value->type == 2) {
			if ($value->overlib == 0) {
				echo ' title="'. $value->title.'"';
			}
		}
		echo ' href="'. $value->link.'"';
							
		// Correct size for external Image (Picasa) - subcategory
		if (isset($value->extpic) && $value->extpic != '') {
			$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($value->extw, $value->exth, $this->tmpl['picasa_correct_width_m'], $this->tmpl['picasa_correct_height_m']);
		}
							
		// Image
		if ($value->type == 2) {
			// Correct size for picasa - image
			if (isset($value->extid) && $value->extid != '') {
				$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($value->extw, $value->exth, $this->tmpl['picasa_correct_width_m'], $this->tmpl['picasa_correct_height_m']);
			}
		
			if ($this->tmpl['detailwindow'] == 1) {
				echo ' onclick="'. $value->button->options.'"';
			} else if ($this->tmpl['detailwindow'] == 4 || $this->tmpl['detailwindow'] == 5) {
				$highSlideOnClick = str_replace('[phocahsfullimg]',$value->linkorig, $this->tmpl['highslideonclick']);
				echo ' onclick="'. $highSlideOnClick.'"';
			} else if ($this->tmpl['detailwindow'] == 6 ) {
				echo ' onclick="gjaks.show('.$value->linknr.'); return false;"';
			} else if ($this->tmpl['detailwindow'] == 7 ) {
				echo '';
			} else if ($this->tmpl['detailwindow'] == 8) {
				echo ' rel="lightbox-'.$this->category->alias.'" ';
			} else {
				echo ' rel="'.$value->button->options.'"';
			}
		
			// SWITCH OR OVERLIB 
			if ($this->tmpl['switchimage'] == 1) {
				// Picasa
				if ($value->extl != '') {
					if ((int)$this->tmpl['switchwidth'] > 0 && (int)$this->tmpl['switchheight'] > 0 && $this->tmpl['switchfixedsize'] == 1) {
						// Custom Size
						echo ' onmouseover="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''. $value->extl.'\', '.$this->tmpl['switchwidth'].', '.$this->tmpl['switchheight'].');" ';
					} else {
						// Picasa Size
						$correctImageResL = PhocaGalleryPicasa::correctSizeWithRate($value->extwswitch, $value->exthswitch, $this->tmpl['switchwidth'], $this->tmpl['switchheight']);
						echo ' onmouseover="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''. $value->extl.'\', '.$correctImageResL['width'].', '.$correctImageResL['height'].');" '; 
						// onmouseout="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''.$value->extl.'\');"
					}
				} else {
					$switchImg = str_replace('phoca_thumb_m_','phoca_thumb_l_',JURI::base(true).'/'. $value->linkthumbnailpath);
					if ((int)$this->tmpl['switchwidth'] > 0 && (int)$this->tmpl['switchheight'] > 0 && $this->tmpl['switchfixedsize'] == 1) {
						echo ' onmouseover="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''. $switchImg.'\', '.$this->tmpl['switchwidth'].', '.$this->tmpl['switchheight'].');" ';
					} else {
						echo ' onmouseover="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''. $switchImg.'\');" ';
						// onmouseout="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''.$switchImg.'\');"
					}
				}
			} else {
				echo $value->overlib_value;					
			}
			echo ' >';

			if ($value->overlib == 0) {
				if (isset($value->extid) && $value->extid != '') {
					echo JHTML::_( 'image', $value->extm, $value->altvalue, array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']));
				} else {
					echo JHTML::_( 'image.site', $value->linkthumbnailpath, '', '', '', $value->altvalue );
				}
			} else {
				if (isset($value->extid) && $value->extid != '') {
					echo JHTML::_( 'image', $value->extm, $value->altvalue, array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']));
				} else {
					echo JHTML::_( 'image.site', $value->linkthumbnailpath, '', '', '', $value->altvalue, array('class' => 'pimo') );
				}
			}

			if ($value->enable_piclens == 1) {
				if ($value->extid != '') {
					echo '<span class="mbf-item">#phocagallerypiclens '.$value->catid.'-phocagallerypiclenscode-'.$value->extid.'</span>';
				} else {
					echo '<span class="mbf-item">#phocagallerypiclens '.$value->catid.'-phocagallerypiclenscode-'.$value->filename.'</span>';
				}
			}
		} else {
			echo ' >'; 
			if (isset($value->extpic) && $value->extpic != '') {
				echo JHTML::_( 'image', $value->extm, $value->altvalue, array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']));
			} else {
				echo JHTML::_( 'image.site', $value->linkthumbnailpath, '', '', '', $value->altvalue );
			}
			
		} // if type 2 else type 0, 1 (image, category, folder)
			
		echo '</a>';
		if ( $this->tmpl['detailwindow'] == 5) {
			if ($this->tmpl['displaytitleindescription'] == 1) {
				echo '<div class="highslide-heading">';
				echo $value->title;
				echo '</div>';
			}
			if ($this->tmpl['displaydescriptiondetail'] == 1) {
				echo '<div class="highslide-caption">';
				echo $value->description;
				echo '</div>';
			}
		}
		
		// hotnew
		if ($value->type == 2) {
			echo PhocaGalleryRenderFront::getOverImageIcons($value->date, $value->hits);
			
		}
		echo '</div>';
		
		echo '</div></div>'. "\n\n";
		
			
			
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
		
		// Rate Image
		if($value->item_type == 'image' && $this->tmpl['displayratingimg'] == 1) {
			echo '<div><a class="'.$value->buttonother->methodname.'" title="'.JText::_('Rate Image').'"'
				.' href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$this->category->slug.'&id='.$value->slug.$tmplCom.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
				
			if ($this->tmpl['detailwindow'] == 1) {
				echo ' onclick="'. $value->buttonother->optionsrating.'"';
			} else if ($this->tmpl['detailwindow'] == 4 ) {
				echo ' onclick="'. $this->tmpl['highslideonclick'].'"';
			} else if ($this->tmpl['detailwindow'] == 5 ) {
				echo ' onclick="'. $this->tmpl['highslideonclick2'].'"';
			} else if ($this->tmpl['detailwindow'] == 7 ) {
				echo '';
			} 	else {
				echo ' rel="'. $value->buttonother->optionsrating.'"';
			}
			echo ' >';
					
			echo '<div><ul class="star-rating-small">'
			.'<li class="current-rating" style="width:'.$value->voteswidthimg.'px"></li>'
			.'<li><span class="star1"></span></li>';
			for ($iV = 2;$iV < 6;$iV++) {
				echo '<li><span class="stars'.$iV.'"></span></li>';
			}
			echo '</ul></div>';
			echo '</a></div>';
		}

		if ($value->displayicondetail == 1 ||
		$value->displayicondownload > 0 || 
		$value->displayiconfolder == 1 || 
		$value->displayiconvm || 
		$value->startpiclens == 1 || 
		$value->trash == 1 || 
		$value->publishunpublish == 1 || 
		$value->displayicongeo == 1 || 
		$value->camerainfo == 1 || 
		$value->displayiconextlink1   == 1 ||
		$value->displayiconextlink2   == 1 ||
		$value->displayiconcommentimg == 1 ||
		$value->camerainfo == 1) {
			
			echo '<div class="detail" style="margin-top:2px">';
			
			if ($value->startpiclens == 1) {							
				echo '<a href="javascript:PicLensLite.start({feedUrl:\''.JURI::base(true) . '/images/phocagallery/'
		. $value->catid .'.rss'.'\'});" title="Cooliris" >';
				echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-cooliris.'.$this->tmpl['formaticon'], 'Cooliris');
				echo '</a>';
			}
		//Detail Icon	
			if ($value->displayicondetail == 1) {
				echo ' <a class="'.$value->button2->methodname.'" title="'. JText::_('Image Detail').'"'
					.' href="'.$value->link2.'"';
					if ($this->tmpl['detailwindow'] == 1) {
						echo ' onclick="'. $value->button2->options.'"';
					} else if ($this->tmpl['detailwindow'] == 2) {
						echo ' rel="'. $value->button2->options.'"';
					} else if ($this->tmpl['detailwindow'] == 4 ) {
						echo ' onclick="'. $this->tmpl['highslideonclick'].'"';
					} else if ($this->tmpl['detailwindow'] == 5 ) {
						echo ' onclick="'. $this->tmpl['highslideonclick2'].'"';
					} else if ($this->tmpl['detailwindow'] == 6) {
						echo ' onclick="gjaks.show('.$value->linknr.'); return false;"';
					} else if ($this->tmpl['detailwindow'] == 7 ) {
						echo '';
					} else if ($this->tmpl['detailwindow'] == 8) {
						echo ' rel="lightbox-'.$this->category->alias.'2" ';
					} else {
						echo ' rel="'.$value->button2->options.'"';
					}
					
					echo ' >';
					echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-view.'.$this->tmpl['formaticon'], JText::_('Image Detail'));
					echo '</a>';
			}
			
			if ($value->displayiconfolder == 1) {
				//echo ' <a class="'.$value->buttonother->methodname.'" title="'.JText::_('Sub category').'"'
				echo ' <a title="'.JText::_('Sub category').'"'
					.' href="'.$value->link.'">';
				echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-folder-small.'.$this->tmpl['formaticon'], $value->title);	
				echo '</a>';
			}
			
			if ($value->displayicondownload > 0) {
				// Direct Download but not if there is a youtube
				if ($value->displayicondownload == 2 && $value->videocode == '') {
					echo ' <a title="'. JText::_('Image Download').'"'
						.' href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$this->category->slug.'&id='.$value->slug. $tmplCom.'&phocadownload='.$value->displayicondownload.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
				} else { 
					echo ' <a class="'.$value->buttonother->methodname.'" title="'.JText::_('Image Download').'"'
						.' href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$this->category->slug.'&id='.$value->slug. $tmplCom.'&phocadownload='.(int)$value->displayicondownload.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
					
					if ($this->tmpl['detailwindow'] == 1) {
						echo ' onclick="'. $value->buttonother->options.'"';
					} else if ($this->tmpl['detailwindow'] == 4 ) {
						echo ' onclick="'. $this->tmpl['highslideonclick'].'"';
					} else if ($this->tmpl['detailwindow'] == 5 ) {
						echo ' onclick="'. $this->tmpl['highslideonclick2'].'"';
					} else if ($this->tmpl['detailwindow'] == 7 ) {
						echo '';
					} else {
						echo ' rel="'. $value->buttonother->options.'"';
					}
				}
				echo ' >';
				echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-download.'.$this->tmpl['formaticon'], JText::_('Image Download'));
				echo '</a>';
			}
			
			if ($value->displayicongeo == 1) {
				echo ' <a class="'.$value->buttonother->methodname.'" title="'.JText::_('Geotagging').'"'
					.' href="'. JRoute::_('index.php?option=com_phocagallery&view=map&catid='.$this->category->slug.'&id='.$value->slug.$tmplCom.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
					if ($this->tmpl['detailwindow'] == 1) {
						echo ' onclick="'. $value->buttonother->options.'"';
					} else if ($this->tmpl['detailwindow'] == 4 ) {
						echo ' onclick="'. $this->tmpl['highslideonclick'].'"';
					} else if ($this->tmpl['detailwindow'] == 5 ) {
						echo ' onclick="'. $this->tmpl['highslideonclick2'].'"';
					} else if ($this->tmpl['detailwindow'] == 7 ) {
						echo '';
					} else {
						echo ' rel="'. $value->buttonother->options.'"';
					}
					echo ' >';
					echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-geo.'.$this->tmpl['formaticon'], JText::_('Geotagging'));
					echo '</a>';
			}
			
			if ($value->camerainfo == 1) {
				echo ' <a class="'.$value->buttonother->methodname.'" title="'.JText::_('Camera Info').'"'
					.' href="'.JRoute::_('index.php?option=com_phocagallery&view=info&catid='.$this->category->slug.'&id='.$value->slug.$tmplCom.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
					if ($this->tmpl['detailwindow'] == 1) {
						echo ' onclick="'. $value->buttonother->options.'"';
					} else if ($this->tmpl['detailwindow'] == 4 ) {
						echo ' onclick="'. $this->tmpl['highslideonclick'].'"';
					} else if ($this->tmpl['detailwindow'] == 5 ) {
						echo ' onclick="'. $this->tmpl['highslideonclick2'].'"';
					} else if ($this->tmpl['detailwindow'] == 7 ) {
						echo '';
					} else {
						echo ' rel="'. $value->buttonother->options.'"';
					}
					echo ' >';
					echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-info.'.$this->tmpl['formaticon'], JText::_('Camera Info'));
					echo '</a>';
			}
			
			if ($value->displayiconcommentimg == 1) {
				
				if ($this->tmpl['detailwindow'] == 7 || $this->tmpl['display_comment_nopup'] == 1) {
					$tmplClass	= '';
				} else {
					$tmplClass 	= 'class="'.$value->buttonother->methodname.'"';
				}
			
				echo ' <a '.$tmplClass.' title="'.JText::_('PHOCAGALLERY_COMMENT_IMAGE').'"'
					.' href="'. JRoute::_('index.php?option=com_phocagallery&view=comment&catid='.$this->category->slug.'&id='.$value->slug.$tmplCom.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
				
				if ($this->tmpl['display_comment_nopup'] == 1) {
					echo '';
				} else {
				
					if ($this->tmpl['detailwindow'] == 1) {
						echo ' onclick="'. $value->buttonother->options.'"';
					} else if ($this->tmpl['detailwindow'] == 4 ) {
						echo ' onclick="'. $this->tmpl['highslideonclick'].'"';
					} else if ($this->tmpl['detailwindow'] == 5 ) {
						echo ' onclick="'. $this->tmpl['highslideonclick2'].'"';
					} else if ($this->tmpl['detailwindow'] == 7 ) {
						echo '';
					} else {
						echo ' rel="'. $value->buttonother->options.'"';
					}
				}
				echo ' >';
				// If you go from RSS or administration (e.g. jcomments) to category view, you will see already commented image (animated icon)
				$cimgid = JRequest::getVar( 'cimgid', 0, '', 'int');
				if($cimgid > 0) {
					echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-comment-a.gif', JText::_('PHOCAGALLERY_COMMENT_IMAGE'));
				} else {
					
					$commentImg = ($this->tmpl['externalcommentsystem'] == 2) ? 'icon-comment-fb-small' : 'icon-comment';
					echo JHTML::_('image', 'components/com_phocagallery/assets/images/'.$commentImg.'.'.$this->tmpl['formaticon'], JText::_('PHOCAGALLERY_COMMENT_IMAGE'));
				}
				echo '</a>';	
			}
			
			if ($value->displayiconextlink1 == 1) {
				echo ' <a title="'.$value->extlink1[1] .'"'
					.' href="http://'.$value->extlink1[0] .'" target="'.$value->extlink1[2] .'" '.$value->extlink1[5].'>'
					.$value->extlink1[4].'</a>';
				
			}
			if ($value->displayiconextlink2 == 1) {
				echo ' <a title="'.$value->extlink2[1] .'"'
					.' href="http://'.$value->extlink2[0] .'" target="'.$value->extlink2[2] .'" '.$value->extlink2[5].'>'
					.$value->extlink2[4].'</a>';
				
			}
			
			// VirtueMart Link
			if ($value->displayiconvm == 1) {
				echo ' <a title="'.JText::_('Eshop').'" href="'. JRoute::_($value->vmlink).'">';
				echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-cart.'.$this->tmpl['formaticon'], JText::_('Eshop'));
				echo '</a>';
			}
			
			// Trash for private categories
			if ($value->trash == 1) {
				echo ' <a onclick="return confirm(\''.JText::_('WARNWANTDELLISTEDITEMS').'\')" title="'.JText::_('Delete').'" href="'. JRoute::_('index.php?option=com_phocagallery&view=category&catid='.$this->category->slug.'&id='.$value->slug.'&controller=category&task=remove'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).$this->tmpl['limitstarturl'].'">';
					echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-trash.'.$this->tmpl['formaticon'], JText::_('Delete'));
					echo '</a>';
			}
			
			// Publish Unpublish for private categories
			if ($value->publishunpublish == 1) {
				if ($value->published == 1) {
					echo ' <a title="'.JText::_('Unpublish').'" href="'. JRoute::_('index.php?option=com_phocagallery&view=category&catid='.$this->category->slug.'&id='.$value->slug.'&&controller=category&task=unpublish'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).$this->tmpl['limitstarturl'].'">';
					echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-publish.'.$this->tmpl['formaticon'], JText::_('Unpublish'));
					echo '</a>';
				}
				if ($value->published == 0) {
					echo ' <a title="'.JText::_('Publish').'" href="'. JRoute::_('index.php?option=com_phocagallery&view=category&catid='.$this->category->slug.'&id='.$value->slug.'&controller=category&task=publish'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).$this->tmpl['limitstarturl'].'">';
					echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-unpublish.'.$this->tmpl['formaticon'], JText::_('Publish'));
					echo '</a>';
				
				}
			}
			
			if ($value->approvednotapproved == 1) {
				// Display the information about Approving too:
				if ($value->approved == 1) {
					echo ' <a href="#" title="'.JText::_('PHOCAGALLERY_IMAGE_APPROVED').'">'.JHTML::_('image', 'components/com_phocagallery/assets/images/icon-publish.'.$this->tmpl['formaticon'], JText::_('PHOCAGALLERY_APPROVED')).'</a>';
				}
				if ($value->approved == 0) {
					echo ' <a href="#" title="'.JText::_('PHOCAGALLERY_IMAGE_NOT_APPROVED').'">'.JHTML::_('image', 'components/com_phocagallery/assets/images/icon-unpublish.'.$this->tmpl['formaticon'], JText::_('PHOCAGALLERY_NOT_APPROVED')).'</a>';
				
				}
			}
		
			echo '</div>'. "\n";
			echo '<div style="clear:both"></div>'. "\n";
		}
		

		
		if ($this->tmpl['displayimgdescbox'] == 1  && $value->description != '') {
			echo '<div class="phocaimgdesc" style="font-size:'.$this->tmpl['fontsizeimgdesc'].'px">'. strip_tags(PhocaGalleryText::wordDelete($value->description, $this->tmpl['charlengthimgdesc'], '...')).'</div>';
		} else if ($this->tmpl['displayimgdescbox'] == 2  && $value->description != '') {	
			echo '<div class="phocaimgdeschtml">' .(JHTML::_('content.prepare', $value->description)).'</div>';
		}
		
		echo '</div>';

	}

} else {
	// Will be not displayed
	//echo JText::_('There is no image in this category');
}

echo '<div style="clear:both"></div>';
echo '<div>&nbsp;</div>';

// Form
echo '<form action="'.$this->tmpl['action'].'" method="post" name="adminForm">'. "\n";

if (count($this->items)) {
	echo '<div class="pgcenter">';
	if ($this->params->get('show_pagination_limit_category')) {
		
		echo '<div class="pginline">'
			.JText::_('Display Num') .'&nbsp;'
			.$this->tmpl['pagination']->getLimitBox()
			.'</div>';
	}
	
	if ($this->params->get('show_pagination_category')) {
	
		echo '<div style="margin:0 10px 0 10px;display:inline;" class="sectiontablefooter'.$this->params->get( 'pageclass_sfx' ).'" >'
			.$this->tmpl['pagination']->getPagesLinks()
			.'</div>'
		
			.'<div style="margin:0 10px 0 10px;display:inline;" class="pagecounter">'
			.$this->tmpl['pagination']->getPagesCounter()
			.'</div>';
	}
	echo '</div>'. "\n";
}
echo '<input type="hidden" name="controller" value="category" />';
echo JHTML::_( 'form.token' );
echo '</form>';

echo '</div>'. "\n";
echo '<div>&nbsp;</div>'. "\n";


if ($this->tmpl['displaytabs'] > 0) {
	echo '<div id="phocagallery-pane">';
	$pane =& JPane::getInstance('Tabs', array('startOffset'=> $this->tmpl['tab']));
	echo $pane->startPane( 'pane' );
	
	if ((int)$this->tmpl['displayrating'] == 1) {
		echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocagallery/assets/images/icon-vote.'.$this->tmpl['formaticon'],'', '', '', '', '') . '&nbsp;'.JText::_('Rating'), 'pgvotes' );
		echo $this->loadTemplate('rating');
		echo $pane->endPanel();
	}

	if ((int)$this->tmpl['displaycomment'] == 1) {
		$commentImg = ($this->tmpl['externalcommentsystem'] == 2) ? 'icon-comment-fb' : 'icon-comment';
		
		echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocagallery/assets/images/'.$commentImg.'.'.$this->tmpl['formaticon'],'', '', '', '', '') . '&nbsp;'.JText::_('Comments'), 'pgcomments' );
		
	
		if (JComponentHelper::isEnabled('com_jcomments', true) && $this->tmpl['externalcommentsystem'] == 1) {
			include_once(JPATH_BASE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php');
			echo JComments::showComments($this->category->id, 'com_phocagallery', JText::_('PHOCAGALLERY_CATEGORY') .' '. $this->category->title);
		} else if($this->tmpl['externalcommentsystem'] == 2) {
			echo $this->loadTemplate('comments-fb');
		} else {
			echo $this->loadTemplate('comments');
		}
		echo $pane->endPanel();
	}

	if ((int)$this->tmpl['displaycategorystatistics'] == 1) {
		echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocagallery/assets/images/icon-statistics.'.$this->tmpl['formaticon'],'', '', '', '', '') . '&nbsp;'.JText::_('Statistics'), 'pgstatistics' );
		echo $this->loadTemplate('statistics');
		echo $pane->endPanel();
	}
	
	if ((int)$this->tmpl['displaycategorygeotagging'] == 1) {
		
		if ($this->map['longitude'] == '' || $this->map['latitude'] == '') {
			//echo '<p>' . JText::_('Google Maps Error Front') . '</p>';
		} else {
			echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocagallery/assets/images/icon-geo.'.$this->tmpl['formaticon'],'', '', '', '', '') . '&nbsp;'.JText::_('Geotagging'), 'pggeotagging' );
			echo $this->loadTemplate('geotagging');
			echo $pane->endPanel();
		}
	}
	
	if ((int)$this->tmpl['displayupload'] == 1) {
		echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocagallery/assets/images/icon-upload.'.$this->tmpl['formaticon'],'', '', '', '', '') . '&nbsp;'.JText::_('Upload'), 'pgupload' );
		echo $this->loadTemplate('upload');
		echo $pane->endPanel();
	}

	echo $pane->endPane();
	echo '</div>'. "\n";// end phocagallery-pane
}

if ($this->tmpl['detailwindow'] == 6) {
	?><script type="text/javascript">
	var gjaks = new SZN.LightBox(dataJakJs, optgjaks);
	</script><?php
}
echo '<div>&nbsp;</div>';
// Phoca Gallery Width
?>
<!-- End Category </a></div> -->
