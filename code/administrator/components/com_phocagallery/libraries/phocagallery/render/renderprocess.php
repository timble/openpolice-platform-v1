<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class PhocaGalleryRenderProcess
{	
	var $stopThumbnailsCreating = null; // display the posibility (link) to disable the thumbnails creating
	var $headerAdded			= null;// HTML Header was added by Stop Thumbnails creating, don't add it into a site again;


	function getProcessPage ( $filename, $thumbInfo, $refresh_url, $errorMsg = '' ) {
		
		$countImg 		= (int)JRequest::getVar( 'countimg', 0, 'get', 'INT' );
		$currentImg 	= (int)JRequest::getVar( 'currentimg',0, 'get','INT' );
		
		if ($currentImg == 0) {
			$currentImg = 1;
		}
		$nextImg = $currentImg + 1;
		
		if (!isset($this->headerAdded) || (isset($this->headerAdded) && $this->headerAdded == 0)) {
			
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
			echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-en" lang="en-en" dir="ltr" >'. "\n";
			echo '<head>'. "\n";
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'. "\n\n";
			echo '<title>'.JText::_( 'Creating of Thumbnail').'</title>'. "\n";
			echo '<link rel="stylesheet" href="'.JURI::base(true).'/components/com_phocagallery/assets/phocagallery.css" type="text/css" />';
			echo '</head>'. "\n";
			echo '<body>'. "\n";
			
		}
		echo '<center><div style="width:70%;border:5px solid #FFE699; margin-top:30px;font-family: sans-serif, Arial;font-weight:normal;color:#666;font-size:14px;padding:10px">';
		echo '<span>'. JText::_( 'Creating of thumbnail Please Wait' ) . '</span>';
		
		if ( $errorMsg == '' ) {
			echo '<p>' .JText::_( 'Creating of thumbnail' ) 
			.' <span style="color:#0066cc;">'. $filename . '</span>' 
			.' ... <b style="color:#009900">'.JText::_( 'OK' ).'</b><br />'
			.'(<span style="color:#0066cc;">' . $thumbInfo . '</span>)</p>';
		} else {
			echo '<p>' .JText::_( 'Creating of thumbnail' ) 
			.' <span style="color:#0066cc;padding:0;margin:0"> '. $filename . '</span>' 
			.' ... <b style="color:#fc0000">'.JText::_( 'Error' ).'</b><br />'
			.'(<span style="color:#0066cc;">' . $thumbInfo . '</span>)</p>';
			
		}
	
		if ($countImg == 0) {
			// BEGIN ---------------------------------------------------------------------------
			echo '<div class="loading">'. JHTML::_('image.site',  'icon-loading.gif', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_('Loading') ) .'  '. JText::_('Rebuilding Process') . '</div>';
			// END -----------------------------------------------------------------------------
		} else {
			// Creating thumbnails info
			$per = 0; // display percents
			if ($countImg > 0) {
				$per = round(($currentImg / $countImg)*100, 0);
			}
			$perCSS = ($per * 400/100) - 400;
			$bgCSS = 'background: url(\''.JURI::base(true).'/components/com_phocagallery/assets/images/process.png\') '.$perCSS.'px 0 repeat-y;';
			
			// BEGIN -----------------------------------------------------------------------
			echo '<p>' . JText::_('Creating'). ': <span style="color:#0066cc">'. $currentImg .'</span> '.JText::_('From'). ' <span style="color:#0066cc">'. $countImg .'</span> '.JText::_('Thumbnail(s)').'</p>';
			
			//echo '<p>'.$per.' &#37;</p>';
			echo '<div style="width:400px;height:20px;font-size:20px;border-top:2px solid #666;border-left:2px solid #666;border-bottom:2px solid #ccc;border-right:2px solid #ccc;'.$bgCSS.'"><span style="font-size:10px;font-weight:bold">'.$per.' &#37;</div>';
			// END -------------------------------------------------------------------------
		}

		if ( $errorMsg != '' ) {
		
			$errorMessage = '';
			switch ($errorMsg) {
				case 'ErrorNotSupportedImage':
				$errorMessage = JText::_('ErrorNotSupportedImage');
				break;
				
				case 'ErrorNoJPGFunction':
				$errorMessage = JText::_('ErrorNoJPGFunction');
				break;
				
				case 'ErrorNoPNGFunction':
				$errorMessage = JText::_('ErrorNoPNGFunction');
				break;
				
				case 'ErrorNoGIFFunction':
				$errorMessage = JText::_('ErrorNoGIFFunction');
				break;
				
				case 'ErrorNoWBMPFunction':
				$errorMessage = JText::_('ErrorNoWBMPFunction');
				break;
				
				case 'ErrorWriteFile':
				$errorMessage = JText::_('ErrorWriteFile');
				break;
				
				case 'ErrorFileOriginalNotExists':
				$errorMessage = JText::_('ErrorFileOriginalNotExists');
				break;

				case 'ErrorCreatingFolder':
				$errorMessage = JText::_('ErrorCreatingFolder');
				break;
				
				case 'ErrorNoImageCreateTruecolor':
				$errorMessage = JText::_('ErrorNoImageCreateTruecolor');
				break;
				
				case 'Error1':
				case 'Error2':
				case 'Error3':
				case 'Error4':
				case 'Error5':
				default:
					$errorMessage = JText::_('ErrorWhileCreatingThumb') . ' ('.$errorMsg.')';
				break;	
			}
			
			$positioni = strpos($refresh_url, "view=phocagalleryi");
			$positiond = strpos($refresh_url, "view=phocagalleryd");
			
			if ($positioni === false && $positiond === false)//we are in whole window - not in modal box
			{
			
				echo '<div style="text-align:left;margin: 10px 5px">';
				echo '<table border="0" cellpadding="7"><tr><td>'.JText::_('Error Message').':</td><td><span style="color:#fc0000">'.$errorMessage.'</span></td></tr>';
				
				echo '<tr><td colspan="1" rowspan="4" valign="top" >'.JText::_('What to do now').' :</td>';
				
				echo '<td>&raquo; ' .JText::_( 'PG Solution Begin' ).' <br /><ul><li>'.JText::_( 'PG Solution Image' ).'</li><li>'.JText::_( 'PG Solution GD' ).'</li><li>'.JText::_( 'PG Solution Permission' ).'</li></ul>'.JText::_( 'PG Solution End' ).'<br /> <a href="'.$refresh_url.'&countimg='.$countImg.'&currentimg='.$currentImg .'">' .JText::_( 'Phoca Gallery Back' ).'</a><hr /></td></tr>';
				
				echo '<tr><td>&raquo; ' .JText::_( 'Disable Creating Thumbnails Solution' ).' <br /> <a href="index.php?option=com_phocagallery&controller=phocagallery&task=disablethumbs">' .JText::_( 'Phoca Gallery Back Disable Thumbnails Creating' ).'</a> <br />'.JText::_( 'Enable Thumbnails Creating in Default Settings' ).'<hr /></td></tr>';
				
				echo '<tr><td>&raquo; ' .JText::_( 'Media Manager Solution' ).' <br /> <a href="index.php?option=com_media">' .JText::_( 'Media Manager link' ).'</a><hr /></td></tr>';
				
				echo '<tr><td>&raquo; <a href="http://www.phoca.cz/documentation/" target="_blank">' .JText::_( 'Go to Phoca Gallery User Manual' ).'</a></td></tr>';
				
				echo '</table>';
				echo '</div>';

			}
			else //we are in modal box
			{
				echo '<div style="text-align:left">';
				echo '<table border="0" cellpadding="3"
			cellspacing="3"><tr><td>'.JText::_('Error Message').':</td><td><span style="color:#fc0000">'.$errorMessage.'</span></td></tr>';
				
				echo '<tr><td colspan="1" rowspan="3" valign="top">'.JText::_('What to do now').' :</td>';
				
				echo '<td>&raquo; ' .JText::_( 'PG Solution Begin' ).' <br /><ul><li>'.JText::_( 'PG Solution Image' ).'</li><li>'.JText::_( 'PG Solution GD' ).'</li><li>'.JText::_( 'PG Solution Permission' ).'</li></ul>'.JText::_( 'PG Solution End' ).'<br /> <a href="'.$refresh_url.'&countimg='.$countImg.'&currentimg='.$currentImg .'">' .JText::_( 'Phoca Gallery Back' ).'</a><hr /></td></tr>';
				
				echo '<td>&raquo; ' .JText::_( 'No Solution' ).' <br /> <a href="#" onclick="window.parent.document.getElementById(\'sbox-window\').close();">' .JText::_( 'Phoca Gallery Back' ).'</a></td></tr>';
				
				echo '</table>';
				echo '</div>';
			}
			
			echo '</div></center></body></html>';
			exit;
		}
		
			
		if ($countImg ==  $currentImg || $currentImg > $countImg) {
			echo '<meta http-equiv="refresh" content="1;url='.$refresh_url.'&imagesid='.md5(time()).'" />';
		} else {
			echo '<meta http-equiv="refresh" content="0;url='.$refresh_url.'&countimg='.$countImg.'&currentimg='.$nextImg.'" />';
		}
		
		echo '</div></center></body></html>';
		exit;
	}
	
	
	function displayStopThumbnailsCreating() {
		
		// 1 ... link was displayed
		// 0 ... display the link "Stop ThumbnailsCreation
		
		$uri 		= & JFactory::getURI();
		$positioni = strpos($uri->toString(), "view=phocagalleryi");
		$positiond = strpos($uri->toString(), "view=phocagalleryd");
			
		//we are in whole window - not in modal box
		if ($positioni === false && $positiond === false) {
			if (!isset($this->stopThumbnailsCreating) || (isset($this->stopThumbnailsCreating) && $this->stopThumbnailsCreating == 0)) {
				// Add stop thumbnails creation in case e.g. of Fatal Error which returns 'ImageCreateFromJPEG'
				// test utf-8 ä, ö, ü, č, ř, ž, ß
				$stopText = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
				$stopText .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-en" lang="en-en" dir="ltr" >'. "\n";
				$stopText .= '<head>'. "\n";
				$stopText .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'. "\n\n";
				$stopText .= '<title>'.JText::_( 'Creating of Thumbnail').'</title>'. "\n";
				$stopText .= '</head>'. "\n";
				$stopText .= '<body>'. "\n";
				
				
				$stopText .= '<div style="text-align:right;padding:10px"><a style="font-family: sans-serif, Arial;font-weight:bold;color:#fc0000;font-size:14px;" href="index.php?option=com_phocagallery&controller=phocagallery&task=disablethumbs">' .JText::_( 'Stop Thumbnails Creation' ).'</a></div>';
				$this->stopThumbnailsCreating = 1;// it was added to the site, don't add the same code (because there are 3 thumnails - small, medium, large)
				$this->headerAdded = 1;
				return $stopText;
				
			} else {
				return '';
			}
		} else {
			$this->stopThumbnailsCreating = 1;
		}
	}			
}
?>