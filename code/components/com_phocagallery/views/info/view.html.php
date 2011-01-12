<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view');
class PhocaGalleryViewInfo extends JView
{
	function display($tpl = null) {
		global $mainframe;
		$tmpl = array();
		
		// PLUGIN WINDOW - we get information from plugin
		$get			= '';
		$get['info']	= JRequest::getVar( 'info', '', 'get', 'string' );
		
		$document	= & JFactory::getDocument();		
		$params		= &$mainframe->getParams();
		
		// START CSS
		$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/phocagallery.css');
		
		// PARAMS - Open window parameters - modal popup box or standard popup window
		$detail_window = $params->get( 'detail_window', 0 );
		
		// Plugin information
		if (isset($get['info']) && $get['info'] != '') {
			$detail_window = $get['info'];
		}
		
		
		// Standard popup window
		if ($detail_window == 1) {
			$detail_window_close 	= 'window.close();';
			$detail_window_reload	= 'window.location.reload(true);';
		} else {//modal popup window
			$detail_window_close 	= 'window.parent.document.getElementById(\'sbox-window\').close();';
			$detail_window_reload	= 'window.location.reload(true);';
		}
		
		// PARAMS - Display Description in Detail window - set the font color
		$tmpl['detailwindowbackgroundcolor']= $params->get( 'detail_window_background_color', '#ffffff' );
		$tmpl['detailwindow']			 	= $params->get( 'detail_window', 0 );
		$description_lightbox_font_color 	= $params->get( 'description_lightbox_font_color', '#ffffff' );
		$description_lightbox_bg_color 		= $params->get( 'description_lightbox_bg_color', '#000000' );
		$description_lightbox_font_size 	= $params->get( 'description_lightbox_font_size', 12 );
		$tmpl['stm'] 						= PhocaGalleryRenderFront::getString();
		$tmpl['gallerymetakey'] 			= $params->get( 'gallery_metakey', '' );
		$tmpl['gallerymetadesc'] 			= $params->get( 'gallery_metadesc', '' );
		$tmpl['pgl'] 						= PhocaGalleryRenderInfo::getPhocaIc((int)$params->get( 'display_phoca_info', 1 ));
		
		if ($tmpl['gallerymetakey'] != '') {
			$mainframe->addMetaTag('keywords', $tmpl['gallerymetakey']);
		}
		if ($tmpl['gallerymetadesc'] != '') {
			$mainframe->addMetaTag('description', $tmpl['gallerymetadesc']);
		}

		// NO SCROLLBAR IN DETAIL WINDOW
/*		$document->addCustomTag( "<style type=\"text/css\"> \n" 
			." html,body, .contentpane{overflow:hidden;background:".$tmpl['detailwindowbackgroundcolor'].";} \n" 
			." center, table {background:".$tmpl['detailwindowbackgroundcolor'].";} \n" 
			." #sbox-window {background-color:#fff;padding:5px} \n" 
			." </style> \n");
*/	
		
		// PARAMS - Get image height and width
		$tmpl['boxlargewidth']		= $params->get( 'front_modal_box_width', 680 );
		$tmpl['boxlargeheight'] 	= $params->get( 'front_modal_box_height', 560 );
		$front_popup_window_width 	= $tmpl['boxlargewidth'];//since version 2.2
		$front_popup_window_height 	= $tmpl['boxlargeheight'];//since version 2.2
		
		if ($detail_window == 1) {
			$tmpl['windowwidth']	= $front_popup_window_width;
			$tmpl['windowheight']	= $front_popup_window_height;
		} else {//modal popup window
			$tmpl['windowwidth']	= $tmpl['boxlargewidth'];
			$tmpl['windowheight']	= $tmpl['boxlargeheight'];
		}
		
		$tmpl['largemapwidth']		= (int)$tmpl['windowwidth'] - 20;
		$tmpl['largemapheight']		= (int)$tmpl['windowheight'] - 20;
		$tmpl['googlemapsapikey']	= $params->get( 'google_maps_api_key', '' );
		
		$tmpl['exifinformation']	= $params->get( 'exif_information', 'FILE.FileName;FILE.FileDateTime;FILE.FileSize;FILE.MimeType;COMPUTED.Height;COMPUTED.Width;COMPUTED.IsColor;COMPUTED.ApertureFNumber;IFD0.Make;IFD0.Model;IFD0.Orientation;IFD0.XResolution;IFD0.YResolution;IFD0.ResolutionUnit;IFD0.Software;IFD0.DateTime;IFD0.Exif_IFD_Pointer;IFD0.GPS_IFD_Pointer;EXIF.ExposureTime;EXIF.FNumber;EXIF.ExposureProgram;EXIF.ISOSpeedRatings;EXIF.ExifVersion;EXIF.DateTimeOriginal;EXIF.DateTimeDigitized;EXIF.ShutterSpeedValue;EXIF.ApertureValue;EXIF.ExposureBiasValue;EXIF.MaxApertureValue;EXIF.MeteringMode;EXIF.LightSource;EXIF.Flash;EXIF.FocalLength;EXIF.SubSecTimeOriginal;EXIF.SubSecTimeDigitized;EXIF.ColorSpace;EXIF.ExifImageWidth;EXIF.ExifImageLength;EXIF.SensingMethod;EXIF.CustomRendered;EXIF.ExposureMode;EXIF.WhiteBalance;EXIF.DigitalZoomRatio;EXIF.FocalLengthIn35mmFilm;EXIF.SceneCaptureType;EXIF.GainControl;EXIF.Contrast;EXIF.Saturation;EXIF.Sharpness;EXIF.SubjectDistanceRange;GPS.GPSLatitudeRef;GPS.GPSLatitude;GPS.GPSLongitudeRef;GPS.GPSLongitude;GPS.GPSAltitudeRef;GPS.GPSAltitude;GPS.GPSTimeStamp;GPS.GPSStatus;GPS.GPSMapDatum;GPS.GPSDateStamp' );
			
		// MODEL
		$model	= &$this->getModel();
		$info	= $model->getData();
		
		// Back button
		$tmpl['backbutton'] = '';
		if ($tmpl['detailwindow'] == 7) {
			phocagalleryimport('phocagallery.image.image');
			$formatIcon = &PhocaGalleryImage::getFormatIcon();
			$tmpl['backbutton'] = '<div><a href="'.JRoute::_('index.php?option=com_phocagallery&view=category&id='. $info->catslug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')).'"'
				.' title="'.JText::_( 'Back to category' ).'">'
				. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-up-images.' . $formatIcon, JText::_( 'Back to category' )).'</a></div>';
		}
		
		// EXIF DATA
		$outputExif 	= '';
		$originalFile 	= '';
		if (isset($info->extid) && $info->extid != '' && isset($info->exto) && $info->exto != '') {
			$originalFile = $info->exto;
		} else {
			if (isset($info->filename)) {
				$originalFile = PhocaGalleryFile::getFileOriginal($info->filename);
			}
		}
		
		if ($originalFile != '' && function_exists('exif_read_data')) {
			
			$exif = @exif_read_data( $originalFile, 'IFD0');
		
			if ($exif === false) {
				$outputExif .= JText::_('No header data found');
			}
			
			$setExif 		= $tmpl['exifinformation'];
			$setExifArray	= explode(";", $setExif, 200);
			$exif 			= @exif_read_data($originalFile, 0, true);
			
		/*	$infoOutput = '';
			foreach ($exif as $key => $section) {
				foreach ($section as $name => $val) {
					$infoOutput .= strtoupper($key.'.'.$name).'='.$name.'<br />';
					$infoOutput .= $key.'.'.$name.';';
				}
			}*/
		
			
			$infoOutput	= '';
			$i 			= 0;
			foreach ($setExifArray as $ks => $vs) {
			
				if ($i%2==0) {
					$class = 'class="first"';
				} else {
					$class = 'class="second"';
				}
			
				if ($vs != '') {
					$vsValues	= explode(".", $vs, 2);
					if (isset($vsValues[0])) {
						$section = $vsValues[0];
					} else {
						$section = '';
					}
					if (isset($vsValues[1])) {
						$name = $vsValues[1];
					} else {
						$name = '';
					}
				
				
					if ($section != '' && $name != '') {
						
						if (isset($exif[$section][$name])) {
						
							switch ($name) {
								case 'FileDateTime':
									jimport( 'joomla.utilities.date');
									$date		= new JDate($exif[$section][$name]);
									$exifValue 	= $date->toFormat('%d %B %Y, %H:%M');
								break;
								
								case 'FileSize':
									$exifValue	= PhocaGalleryFile::getFileSizeReadable($exif[$section][$name]);
								break;
								
								case 'Height':
								case 'Width':
								case 'ExifImageWidth':
								case 'ExifImageLength':
									$exifValue	= $exif[$section][$name] . ' px';
								break;
								
								case 'IsColor':
									switch((int)$exif[$section][$name]) {
										case 0:
											$exifValue = JText::_('No');
										break;
										default:
											$exifValue = JText::_('Yes');
										break;
									}
								break;
								
								
								
								case 'ResolutionUnit':
									switch((int)$exif[$section][$name]) {
										case 2:
											$exifValue = JText::_('Inch');
										break;
										case 3:
											$exifValue = JText::_('Cm');
										break;
										case 4:
											$exifValue = JText::_('Mm');
										break;
										case 5:
											$exifValue = JText::_('Micro');
										break;
										case 0:
										case 1:
										default:
											$exifValue = '?';
										break;
									}
								break;
								
								case 'ExposureProgram':
									switch((int)$exif[$section][$name]) {
										case 1:
											$exifValue = JText::_('Manual');
										break;
										case 2:
											$exifValue = JText::_('Normal Program');
										break;
										case 3:
											$exifValue = JText::_('Aperture priority');
										break;
										case 4:
											$exifValue = JText::_('Shutter priority');
										break;
										case 5:
											$exifValue = JText::_('Creative program');
										break;
										case 6:
											$exifValue = JText::_('Action program');
										break;
										case 7:
											$exifValue = JText::_('Portrait mode');
										break;
										case 8:
											$exifValue = JText::_('Landscape mode');
										break;
										case 0:
										default:
											$exifValue = JText::_('Not defined');
										break;
									}
								break;
								
								case 'MeteringMode':
									switch((int)$exif[$section][$name]) {
										case 0:
											$exifValue = JText::_('Unknown');
										break;
										case 1:
											$exifValue = JText::_('Average');
										break;
										case 2:
											$exifValue = JText::_('CenterWeightedAverage');
										break;
										case 3:
											$exifValue = JText::_('Spot');
										break;
										case 4:
											$exifValue = JText::_('MultiSpot');
										break;
										case 5:
											$exifValue = JText::_('Pattern');
										break;
										case 6:
											$exifValue = JText::_('Partial');
										break;
										
										case 255:
										default:
											$exifValue = JText::_('Other');
										break;
									}
								break;
								
								
								case 'LightSource':
									switch((int)$exif[$section][$name]) {
										case 0:
											$exifValue = JText::_('Unknown');
										break;
										case 1:
											$exifValue = JText::_('Daylight');
										break;
										case 2:
											$exifValue = JText::_('Fluorescent');
										break;
										case 3:
											$exifValue = JText::_('Tungsten');
										break;
										case 4:
											$exifValue = JText::_('Flash');
										break;
										case 9:
											$exifValue = JText::_('Fineweather');
										break;
										case 10:
											$exifValue = JText::_('Cloudyweather');
										break;
										
										case 11:
											$exifValue = JText::_('Shade');
										break;
										case 12:
											$exifValue = JText::_('Daylightfluorescent');
										break;
										case 13:
											$exifValue = JText::_('Daywhitefluorescent');
										break;
										case 14:
											$exifValue = JText::_('Coolwhitefluorescent');
										break;
										case 15:
											$exifValue = JText::_('Whitefluorescent');
										break;
										case 17:
											$exifValue = JText::_('StandardlightA');
										break;
										case 18:
											$exifValue = JText::_('StandardlightB');
										break;
										case 19:
											$exifValue = JText::_('StandardlightC');
										break;
										case 20:
											$exifValue = JText::_('D55');
										break;
										case 21:
											$exifValue = JText::_('D65');
										break;
										case 22:
											$exifValue = JText::_('D75');
										break;
										case 23:
											$exifValue = JText::_('D50');
										break;
										case 24:
											$exifValue = JText::_('ISOstudiotungsten');
										break;
										
										case 255:
										default:
											$exifValue = JText::_('otherlightsource');
										break;
									}
								break;
								
								case 'SensingMethod':
									switch((int)$exif[$section][$name]) {
									
										case 2:
											$exifValue = JText::_('One-chip color area sensor');
										break;
										case 3:
											$exifValue = JText::_('Two-chip color area sensor');
										break;
										case 4:
											$exifValue = JText::_('Three-chip color area sensor');
										break;
										case 5:
											$exifValue = JText::_('Color sequential area sensor');
										break;
										case 7:
											$exifValue = JText::_('Trilinear sensor');
										break;
										case 8:
											$exifValue = JText::_('Color sequential linear sensor');
										break;
										
										case 1:
										default:
											$exifValue = JText::_('Not Defined');
										break;
									}
								break;
								
								case 'CustomRendered':
									switch((int)$exif[$section][$name]) {
									
										case 1:
											$exifValue = JText::_('Custom process');
										break;
										
										case 0:
										default:
											$exifValue = JText::_('Normal process');
										break;
									}
								break;
								
								case 'ExposureMode':
									switch((int)$exif[$section][$name]) {
									
										case 1:
											$exifValue = JText::_('Manual exposure');
										break;
										
										case 2:
											$exifValue = JText::_('Auto bracket');
										break;
										
										case 0:
										default:
											$exifValue = JText::_('Auto exposure');
										break;
									}
								break;
								
								case 'WhiteBalance':
									switch((int)$exif[$section][$name]) {
									
										case 1:
											$exifValue = JText::_('Manual white balance');
										break;
										
										case 0:
										default:
											$exifValue = JText::_('Auto white balance');
										break;
									}
								break;
								
								
								case 'SceneCaptureType':
									switch((int)$exif[$section][$name]) {
									
										case 1:
											$exifValue = JText::_('Landscape');
										break;
										case 2:
											$exifValue = JText::_('Portrait');
										break;
										case 3:
											$exifValue = JText::_('Night scene');
										break;
										
										case 0:
										default:
											$exifValue = JText::_('Standard');
										break;
									}
								break;
								
								case 'GainControl':
									switch((int)$exif[$section][$name]) {
									
										case 1:
											$exifValue = JText::_('Low gain up');
										break;
										case 2:
											$exifValue = JText::_('High gain up');
										break;
										case 3:
											$exifValue = JText::_('Low gain down');
										break;
										
										case 4:
											$exifValue = JText::_('High gain down');
										break;
										
										case 0:
										default:
											$exifValue = JText::_('None');
										break;
									}
								break;
				
								case 'ColorSpace':
									switch((int)$exif[$section][$name]) {
									
										case 1:
											$exifValue = JText::_('sRGB');
										break;
										case 'FFFF.H':
											$exifValue = JText::_('Uncalibrated');
										break;
						
										case 0:
										default:
											$exifValue = '-';
										break;
									}
								break;
				
				
								case 'Contrast':
								case 'Sharpness':
									switch((int)$exif[$section][$name]) {
									
										case 1:
											$exifValue = JText::_('Soft');
										break;
										case 2:
											$exifValue = JText::_('Hard');
										break;
						
										case 0:
										default:
											$exifValue = JText::_('Normal');
										break;
									}
								break;
								
								case 'Saturation':
									switch((int)$exif[$section][$name]) {
									
										case 1:
											$exifValue = JText::_('Low saturation');
										break;
										case 2:
											$exifValue = JText::_('High saturation');
										break;
						
										case 0:
										default:
											$exifValue = JText::_('Normal');
										break;
									}
								break;
				
								case 'SubjectDistanceRange':
									switch((int)$exif[$section][$name]) {
									
										case 1:
											$exifValue = JText::_('Macro');
										break;
										case 2:
											$exifValue = JText::_('Close View');
										break;
										
										case 3:
											$exifValue = JText::_('Distant View');
										break;
						
										case 0:
										default:
											$exifValue = JText::_('Unknown');
										break;
									}
								break;
								
								case 'GPSLatitude':
								case 'GPSLongitude':
									$exifValue = '';
									if (isset($exif[$section][$name][0])) {
										list($l,$r)	= explode("/",$exif[$section][$name][0]);
										$d			= ($l/$r);
										$exifValue 	.= $d . '&deg; ';
									}
									
									if (isset($exif[$section][$name][1])) {
										list($l,$r)	= explode("/",$exif[$section][$name][1]);
										$m			= ($l/$r);
										
										if ($l%$r>0) {
											$sNoInt = ($l/$r);
											$sInt 	= ($l/$r);
											$s 		= ($sNoInt - (int)$sInt)*60;
											$exifValue 	.= (int)$m . '\' ' . $s . '" ';
										} else {
											$exifValue 	.= $m . '\' ';
											if (isset($exif[$section][$name][2])) {
												list($l,$r)	= explode("/",$exif[$section][$name][2]);
												$s			= ($l/$r);
												$exifValue 	.= $s . '" ';
											}
										}
									}
								break;
								
								case 'GPSTimeStamp':
									$exifValue = '';
									if (isset($exif[$section][$name][0])) {
										list($l,$r)	= explode("/",$exif[$section][$name][0]);
										$h			= ($l/$r);
										$exifValue 	.= $h . ' h ';
									}
									
									if (isset($exif[$section][$name][1])) {
										list($l,$r)	= explode("/",$exif[$section][$name][1]);
										$m			= ($l/$r);
										$exifValue 	.= $m . ' m ';
									}
									if (isset($exif[$section][$name][2])) {
										list($l,$r)	= explode("/",$exif[$section][$name][2]);
										$s			= ($l/$r);
										$exifValue 	.= $s . ' s ';
									}

								break;
				
								
								case 'ExifVersion':
									if (is_numeric($exif[$section][$name])) {
										$exifValue = (int)$exif[$section][$name]/100;
									} else {
										$exifValue = $exif[$section][$name];
									}
								break;
								
								case 'FocalLength':
									if (isset($exif[$section][$name]) && $exif[$section][$name] != '') {
										$focalLength = explode ('/', $exif[$section][$name]);
										if (isset($focalLength[0]) && (int)$focalLength[0] > 0
										&& isset($focalLength[1]) && (int)$focalLength[1] > 0 ) {
											$exifValue = (int)$focalLength[0] / (int)$focalLength[1];
											$exifValue = $exifValue . ' mm';
										}
									
									}
								break;
								
								case 'ExposureTime':
									if (isset($exif[$section][$name]) && $exif[$section][$name] != '') {
										$exposureTime = explode ('/', $exif[$section][$name]);
										if (isset($exposureTime[0]) && (int)$exposureTime[0] > 0
										&& isset($exposureTime[1]) && (int)$exposureTime[1] > 1 ) {
										
											if ((int)$exposureTime[1] > (int)$exposureTime[0]) {
												$exifValue = (int)$exposureTime[1] / (int)$exposureTime[0];
												$exifValue = '1/'. $exifValue . ' sec';
											} 
										}
									
									}
								break;
								
								case 'ShutterSpeedValue':
									if (isset($exif[$section][$name]) && $exif[$section][$name] != '') {
										$shutterSpeedValue = explode ('/', $exif[$section][$name]);
										if (isset($shutterSpeedValue[0]) && (int)$shutterSpeedValue[0] > 0
										&& isset($shutterSpeedValue[1]) && (int)$shutterSpeedValue[1] > 1 ) {
										
											if ((int)$shutterSpeedValue[1] > (int)$shutterSpeedValue[0]) {
												$exifValue = (int)$shutterSpeedValue[1] / (int)$shutterSpeedValue[0];
												$exifValue = '1/'. $exifValue . ' sec';
											} 
										}
									
									}
								break;

								
								default:
									$exifValue = $exif[$section][$name];
								break;
							}
							
							
							$infoOutput .= '<tr '.$class.'>'
							//.'<td>'. JText::_($vs) . '('.$section.' '.$name.')</td>'
							.'<td>'. JText::_($vs) . '</td>'
							.'<td>'.$exifValue. '</td>'
							.'</tr>';
						}

					}
				}
				$i++;
			}

		}	

		// ASIGN
		$this->assignRef( 'tmpl', $tmpl );
		$this->assignRef( 'infooutput', $infoOutput );
	//	$this->assignRef( 'infooutput', $infoOutput );
		parent::display($tpl);
	}
}
