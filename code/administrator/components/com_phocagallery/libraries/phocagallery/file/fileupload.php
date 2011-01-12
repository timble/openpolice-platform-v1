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
jimport( 'joomla.filesystem.folder' ); 
jimport( 'joomla.filesystem.file' );
phocagalleryimport( 'phocagallery.image.image');
class PhocaGalleryFileUpload
{
	function canUpload( $file, &$errUploadMsg ) {
		
		$params 	= &JComponentHelper::getParams( 'com_phocagallery' );
		$paramsL 	= array();
		$paramsL['upload_extensions'] 	= 'gif,jpg,png,jpeg';
		$paramsL['image_extensions'] 	= 'gif,jpg,png,jpeg';
		$paramsL['upload_mime']			= 'image/jpeg,image/gif,image/png';
		$paramsL['upload_mime_illegal']	='application/x-shockwave-flash,application/msword,application/excel,application/pdf,application/powerpoint,text/plain,application/x-zip,text/html';
		
		// The file doesn't exist
		if(empty($file['name'])) {
			$errUploadMsg = 'Please input a file for upload';
			return false;
		}

		// Not safe file
		jimport('joomla.filesystem.file');
		if ($file['name'] !== JFile::makesafe($file['name'])) {
			$errUploadMsg = 'WARNFILENAME';
			return false;
		}

		$format = strtolower(JFile::getExt($file['name']));

		// Allowable extension
		$allowable = explode( ',', $paramsL['upload_extensions']);
		if (!in_array($format, $allowable)) {
			$errUploadMsg = 'WARNFILETYPE';
			return false;
		}
		
		// Max Resolution
		$imgSize		= PhocaGalleryImage::getImageSize($file['tmp_name']);
		$maxResWidth 	= $params->get( 'upload_maxres_width', 3072 );
		$maxResHeight 	= $params->get( 'upload_maxres_height', 2304 );
		if (((int)$maxResWidth > 0 && (int)$maxResHeight > 0) 
		&& ((int)$imgSize[0] > (int)$maxResWidth || (int)$imgSize[1] > (int)$maxResHeight)) {
			$errUploadMsg = 'PHOCAGALLERY_WARNFILETOOLARGERESOLUTION';
			return false;
		}
		// Max size of image
		$maxSize = $params->get( 'upload_maxsize', 3145728 );
		if ((int)$maxSize > 0 && (int)$file['size'] > (int)$maxSize) {
			$errUploadMsg = 'WARNFILETOOLARGE';
			return false;
		}

		$user = JFactory::getUser();
		$imginfo = null;
		
		
		// Image check
		$images = explode( ',', $paramsL['image_extensions']);
		if(in_array($format, $images)) { // if its an image run it through getimagesize
			if(($imginfo = getimagesize($file['tmp_name'])) === FALSE) {
				$errUploadMsg = 'WARNINVALIDIMG';
				return false;
			}
		} else if(!in_array($format, $images)) {
			// if its not an image...and we're not ignoring it
			$allowed_mime = explode(',', $paramsL['upload_mime']);
			$illegal_mime = explode(',', $paramsL['upload_mime_illegal']);
			if(function_exists('finfo_open')) {
				// We have fileinfo
				$finfo = finfo_open(FILEINFO_MIME);
				$type = finfo_file($finfo, $file['tmp_name']);
				if(strlen($type) && !in_array($type, $allowed_mime) && in_array($type, $illegal_mime)) {
					$errUploadMsg = 'WARNINVALIDMIME';
					return false;
				}
				finfo_close($finfo);
			} else if(function_exists('mime_content_type')) {
				// we have mime magic
				$type = mime_content_type($file['tmp_name']);
				if(strlen($type) && !in_array($type, $allowed_mime) && in_array($type, $illegal_mime)) {
					$errUploadMsg = 'WARNINVALIDMIME';
					return false;
				}
			}/* else if(!$user->authorize( 'login', 'administrator' )) {
				$errUploadMsg =  = 'WARNNOTADMIN';
				return false;
			}*/
		}
		
		// XSS Check
		$xss_check =  JFile::read($file['tmp_name'],false,256);
		$html_tags = array('abbr','acronym','address','applet','area','audioscope','base','basefont','bdo','bgsound','big','blackface','blink','blockquote','body','bq','br','button','caption','center','cite','code','col','colgroup','comment','custom','dd','del','dfn','dir','div','dl','dt','em','embed','fieldset','fn','font','form','frame','frameset','h1','h2','h3','h4','h5','h6','head','hr','html','iframe','ilayer','img','input','ins','isindex','keygen','kbd','label','layer','legend','li','limittext','link','listing','map','marquee','menu','meta','multicol','nobr','noembed','noframes','noscript','nosmartquotes','object','ol','optgroup','option','param','plaintext','pre','rt','ruby','s','samp','script','select','server','shadow','sidebar','small','spacer','span','strike','strong','style','sub','sup','table','tbody','td','textarea','tfoot','th','thead','title','tr','tt','ul','var','wbr','xml','xmp','!DOCTYPE', '!--');
		foreach($html_tags as $tag) {
			// A tag is '<tagname ', so we need to add < and a space or '<tagname>'
			if(stristr($xss_check, '<'.$tag.' ') || stristr($xss_check, '<'.$tag.'>')) {
				$errUploadMsg = 'WARNIEXSS';
				return false;
			}
		}
		return true;
	}
	
	function uploader($id='file-upload', $params = array()) {
		
		$path = 'administrator/components/com_phocagallery/assets/upload/';
		JHTML::script('swf.js', $path, false ); // mootools are loaded yet
		JHTML::script('uploader.js', $path, false );// mootools are loaded yet

		static $uploaders;

		if (!isset($uploaders)) {
			$uploaders = array();
		}

		if (isset($uploaders[$id]) && ($uploaders[$id])) {
			return;
		}

		// Setup options object
		$opt['url']					= (isset($params['targetURL'])) ? $params['targetURL'] : null ;
		$opt['swf']					= (isset($params['swf'])) ? $params['swf'] : JURI::root(true).'/media/system/swf/uploader.swf';
		$opt['multiple']			= (isset($params['multiple']) && !($params['multiple'])) ? '\\false' : '\\true';
		$opt['queued']				= (isset($params['queued']) && !($params['queued'])) ? '\\false' : '\\true';
		$opt['queueList']			= (isset($params['queueList'])) ? $params['queueList'] : 'upload-queue';
		$opt['instantStart']		= (isset($params['instantStart']) && ($params['instantStart'])) ? '\\true' : '\\false';
		$opt['allowDuplicates']		= (isset($params['allowDuplicates']) && !($params['allowDuplicates'])) ? '\\false' : '\\true';
		$opt['limitSize']			= (isset($params['limitSize']) && ($params['limitSize'])) ? (int)$params['limitSize'] : null;
		$opt['limitFiles']			= (isset($params['limitFiles']) && ($params['limitFiles'])) ? (int)$params['limitFiles'] : null;
		$opt['optionFxDuration']	= (isset($params['optionFxDuration'])) ? (int)$params['optionFxDuration'] : null;
		$opt['container']			= (isset($params['container'])) ? '\\$('.$params['container'].')' : '\\$(\''.$id.'\').getParent()';
		$opt['types']				= (isset($params['types'])) ?'\\'.$params['types'] : '\\{\'All Files (*.*)\': \'*.*\'}';

		// Optional functions
		$opt['createReplacement']	= (isset($params['createReplacement'])) ? '\\'.$params['createReplacement'] : null;
		$opt['onComplete']			= (isset($params['onComplete'])) ? '\\'.$params['onComplete'] : null;
		$opt['onAllComplete']		= (isset($params['onAllComplete'])) ? '\\'.$params['onAllComplete'] : null;

/*  types: Object with (description: extension) pairs, default: Images (*.jpg; *.jpeg; *.gif; *.png)
 */

		$options = JHTMLBehavior::_getJSObject($opt);

		// Attach tooltips to document
		$document =& JFactory::getDocument();
		$uploaderInit = 'sBrowseCaption=\''.JText::_('Browse Files', true).'\';
				sRemoveToolTip=\''.JText::_('Remove from queue', true).'\';
				window.addEvent(\'load\', function(){
				var Uploader = new FancyUpload($(\''.$id.'\'), '.$options.');
				$(\'upload-clear\').adopt(new Element(\'input\', { type: \'button\', events: { click: Uploader.clearList.bind(Uploader, [false])}, value: \''.JText::_('Clear Completed').'\' }));				});';
		$document->addScriptDeclaration($uploaderInit);

		// Set static array
		$uploaders[$id] = true;
		return;
	}
	
	function renderFTPaccess() {
	
		$ftpOutput = '<fieldset title="'.JText::_('DESCFTPTITLE'). '">'
		.'<legend>'. JText::_('DESCFTPTITLE').'</legend>'
		.JText::_('DESCFTP2')
		.'<table class="adminform nospace">'
		.'<tr>'
		.'<td width="120"><label for="username">'. JText::_('Username').':</label></td>'
		.'<td><input type="text" id="username" name="username" class="input_box" size="70" value="" /></td>'
		.'</tr>'
		.'<tr>'
		.'<td width="120"><label for="password">'. JText::_('Password').':</label></td>'
		.'<td><input type="password" id="password" name="password" class="input_box" size="70" value="" /></td>'
		.'</tr></table></fieldset>';
		return $ftpOutput;
	}
	
	function renderCreateFolder($sessName, $sessId, $currentFolder, $viewBack) {
	
		$folderOutput = '<form action="'. JURI::base()
		.'index.php?option=com_phocagallery&controller=phocagalleryu&amp;'
		.'task=createfolder&amp;'. $sessName.'='.$sessId.'&amp;'
		.JUtility::getToken().'=1&amp;viewback='.$viewBack.'&amp;'
		.'folder='.$currentFolder.'" name="folderForm" id="folderForm" method="post">'
		.'<fieldset id="folderview">'
		.'<legend>'.JText::_( 'Folder' ).'</legend>'
		.'<div class="path">'
		.'<input class="inputbox" type="text" id="foldername" name="foldername"  />'
		.'<input class="update-folder" type="hidden" name="folderbase" id="folderbase" value="'.$currentFolder.'" />'
		.'<button type="submit">'. JText::_( 'Create Folder' ).'</button>'
		.'</div>'
	    .'</fieldset>'
		.JHTML::_( 'form.token' )
		.'</form>';
		return $folderOutput;
	}
}
?>