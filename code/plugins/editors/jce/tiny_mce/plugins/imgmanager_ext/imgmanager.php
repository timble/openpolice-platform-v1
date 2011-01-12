<?php
/**
* @version manager.php 2009-05-19
* @package JCE
* @copyright Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

$version = "1.5.7.4";

require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'editor.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'plugin.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'utils.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'manager.php' );

require_once( dirname( __FILE__ ) .DS. 'classes' .DS. 'imgmanager.php' );

$manager =& ImageManager::getInstance();
// check the user/group has editor permissions
$manager->checkPlugin() or die( 'Restricted access' );
// Load Plugin Parameters
$params	= $manager->getPluginParams();

if( $manager->canEdit() ){
	$manager->addAction( 'view-mode', '', 'this.switchMode', JText::_('Change Mode') );
	
	if( $params->get('imgmanager_ext_allow_resize', '1') || $params->get('imgmanager_ext_allow_rotate', '1') ){
		$manager->addButton( 'file', 'transform', '', 'this.transformImage', JText::_('Transform Image') );
		$manager->setXHR( array( &$manager, 'transformImage' ) );
	}
	if( $params->get('imgmanager_ext_allow_thumbnail', '1') ){
		$manager->addButton( 'file', 'thumb-create', '', 'this.createThumbnail', JText::_('Create Thumbnail'), false, true );
		$manager->addButton( 'file', 'thumb-delete', '', 'this.deleteThumbnail', JText::_('Delete Thumbnail'), false, true );
		
		$manager->setXHR( array( &$manager, 'createThumbnail' ) );
		$manager->setXHR( array( &$manager, 'deleteThumbnail' ) );
	}
}
// Setup plugin XHR callback functions 
$manager->setXHR( array( &$manager, 'getDimensions' ) );
$manager->setXHR( array( &$manager, 'getThumbnailDimensions' ) );
$manager->setXHR( array( &$manager, 'getThumbnails' ) );

// Set javascript file array
$manager->script( array( 'imgmanager' ), 'plugins' );
// Set css file array
$manager->css( array( 'imgmanager' ), 'plugins' );

// Load extensions if any
$manager->loadExtensions();
// Process requests
$manager->processXHR();

$manager->_debug = false;
$version .= $manager->_debug ? ' - debug' : '';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $manager->getLanguageTag();?>" lang="<?php echo $manager->getLanguageTag();?>" dir="<?php echo $manager->getLanguageDir();?>" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="IE=8" http-equiv="X-UA-Compatible">
	<title><?php echo JText::_('PLUGIN TITLE').' : '.$version;?></title>
<?php
$manager->printScripts();
$manager->printCss();
?>
	<script type="text/javascript">
		function initManager(src){
			// Create ImageManager (see imgmanager.js)
			return new ImageManager(src, {
				// Global parameters
				actions: <?php echo $manager->getActions();?>,
				buttons: <?php echo $manager->getButtons();?>,
				lang: '<?php echo $manager->getLanguage();?>',
				alerts: <?php echo $manager->getAlerts();?>,
				upload: {
					method: '<?php echo $manager->getEditorParam('editor_upload_method', 'flash'); ?>',
					conflict: '<?php echo $manager->getSharedParam('upload_conflict', 'overwrite|unique'); ?>',
					size: <?php echo $manager->getSharedParam('max_size', '1024'); ?>,
					types: <?php echo $manager->mapUploadFileTypes(); ?>
				},
				tree: <?php echo $manager->getEditorParam('editor_folder_tree', '1'); ?>,
				// Plugin parameters
				params: {
					// Relative base directory
					base: '<?php echo $manager->getBase(); ?>',
					// Default values
					defaults : {	
						'align': 				'<?php echo $params->get( 'imgmanager_ext_align', 'default' );?>',
						'border': 				'<?php echo $params->get( 'imgmanager_ext_border', '0' );?>',
						'border_width': 		'<?php echo $params->get( 'imgmanager_ext_border_width', 'default' );?>',
						'border_style': 		'<?php echo $params->get( 'imgmanager_ext_border_style', 'default' );?>',
						'border_color': 		'<?php echo $params->get( 'imgmanager_ext_border_color', '' );?>',
						'margin_top': 			'<?php echo $params->get( 'imgmanager_ext_margin_top', 'default' );?>',
						'margin_right': 		'<?php echo $params->get( 'imgmanager_ext_margin_right', 'default' );?>',
						'margin_bottom':		'<?php echo $params->get( 'imgmanager_ext_margin_bottom', 'default' );?>',
						'margin_left': 			'<?php echo $params->get( 'imgmanager_ext_margin_left', 'default' );?>',
						// Upload
						'allow-resize':			<?php echo $params->get('imgmanager_ext_allow_resize', '1');?>,
						'upload-resize': 		<?php echo $params->get( 'imgmanager_ext_upload_resize', '0');?>,
						'force-resize': 		<?php echo $params->get( 'imgmanager_ext_force_resize', '0');?>,
						'resize-width': 		'<?php echo $params->get( 'imgmanager_ext_resize_width', '640' );?>',
						'resize-height': 		'<?php echo $params->get( 'imgmanager_ext_resize_height', '480' );?>',
						'resize-width-type': 	'<?php echo $params->get( 'imgmanager_ext_resize_width_type', 'px' );?>',
						'resize-height-type':	'<?php echo $params->get( 'imgmanager_ext_resize_width_type', 'px' );?>',
						'resize-quality': 		'<?php echo $params->get( 'imgmanager_ext_resize_quality', '80' );?>',
						// Rotate
						'allow-rotate':			<?php echo $params->get('imgmanager_ext_allow_rotate', '1');?>,
						'upload-rotate': 		<?php echo $params->get( 'imgmanager_ext_upload_rotate', '0');?>,
						'force-rotate': 		<?php echo $params->get( 'imgmanager_ext_force_rotate', '0');?>,
						'rotate-angle': 		'<?php echo $params->get( 'imgmanager_ext_rotate_angle', '90' );?>',
						// Thumbnails
						'allow-thumbnail':		<?php echo $params->get('imgmanager_ext_allow_thumbnail', '1');?>,
						'upload-thumbnail': 	<?php echo $params->get( 'imgmanager_ext_upload_thumbnail', '0');?>,
						'force-thumbnail': 		<?php echo $params->get( 'imgmanager_ext_force_thumbnail', '0');?>,
						'thumbnail-size': 		'<?php echo $params->get( 'imgmanager_ext_thumbnail_size', '150' );?>',
						'thumbnail-size-type': 	'<?php echo $params->get( 'imgmanager_ext_thumbnail_size_type', 'px' );?>',
						'thumbnail-quality': 	'<?php echo $params->get( 'imgmanager_ext_thumbnail_quality', '80' );?>',
						'thumbnail-mode': 		'<?php echo $params->get( 'imgmanager_ext_thumbnail_mode', '0' );?>'
					},
					'mode': '<?php echo $params->get( 'imgmanager_ext_mode', 'list' );?>',
					'thumbnail-folder': '<?php echo $params->get( 'imgmanager_ext_thumbnail_folder', 'thumbnails' );?>',
					'thumbnail-prefix': '<?php echo $params->get( 'imgmanager_ext_thumbnail_prefix', 'thumb_' );?>',
					'canEdit': <?php echo $manager->canEdit();?>
				} 
			});
		}
	</script>
    <?php echo $manager->printHead();?>
</head>
<body lang="<?php echo $manager->getLanguage(); ?>" style="display: none;">
	<div class="tabs">
        <ul>
            <li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onMouseDown="return false;"><?php echo JText::_('Image');?></a></span></li>
            <li id="popup_tab"><span><a href="javascript:mcTabs.displayTab('popup_tab','popup_panel');" onMouseDown="return false;"><?php echo JText::_('Popup');?></a></span></li>
            <li id="swap_tab"><span><a href="javascript:mcTabs.displayTab('swap_tab','swap_panel');" onMouseDown="return false;"><?php echo JText::_('Rollover');?></a></span></li>
            <li id="tooltip_tab"><span><a href="javascript:mcTabs.displayTab('tooltip_tab','tooltip_panel');" onMouseDown="return false;"><?php echo JText::_('Tooltip');?></a></span></li>
            <li id="advanced_tab"><span><a href="javascript:mcTabs.displayTab('advanced_tab','advanced_panel');" onMouseDown="return false;"><?php echo JText::_('Advanced');?></a></span></li>
		</ul>
	</div>
    <div class="panel_wrapper">
        <div id="general_panel" class="panel current">
            <table>
                <tr>
                	<td style="vertical-align:top;width:75%;">
                        <fieldset>
                            <legend><?php echo JText::_('Properties');?></legend>
                            <table cellpadding="3" cellspacing="0" border="0" style="height:150px;">
                                <tr>
                                	<td><label for="src" class="hastip" title="<?php echo JText::_('URL DESC');?>"><?php echo JText::_('URL');?></label></td>
                                	<td colspan="3"><input type="text" id="src" value="" class="required" /></td>
                                </tr>
                                <tr>
                                	<td><label for="alt" class="hastip" title="<?php echo JText::_('ALT DESC');?>"><?php echo JText::_('ALT');?></label></td>
                               	 <td colspan="3"><input id="alt" type="text" value="" class="required" /></td>
                                </tr>
                                <tr>
                                	<td><label for="width" class="hastip" title="<?php echo JText::_('DIMENSIONS DESC');?>"><?php echo JText::_('DIMENSIONS');?></label></td>
                               		<td colspan="3">
                                		<table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                <input type="text" id="width" value="" onchange="ImageManagerDialog.setDimensions('width', 'height');" onblur="ImageManagerDialog.setDimensions('width', 'height');" /> x <input type="text" id="height" value="" onchange="ImageManagerDialog.setDimensions('height', 'width');" onblur="ImageManagerDialog.setDimensions('height', 'width');" />
                                                <input type="hidden" id="tmp_width" value=""  />
                                                <input type="hidden" id="tmp_height" value="" />
                                                </td>
                                                <td><input id="constrain" type="checkbox" class="checkbox" checked="checked" /><label for="constrain"><?php echo JText::_('Proportional');?></label></td>
                                                <td><div id="dim_loader">&nbsp;</div></td>
                                            </tr>
                            			</table>
                            		</td>
                            	</tr>
                            <tr>
                                <td><label for="align" class="hastip" title="<?php echo JText::_('ALIGN DESC');?>"><?php echo JText::_('ALIGN');?></label></td>
                                <td>
                                	<select id="align" onchange="ImageManagerDialog.updateStyles();">
                                		<option value=""><?php echo JText::_('Align Default');?></option>
                                		<option value="top"><?php echo JText::_('Align Top');?></option>
                                		<option value="middle"><?php echo JText::_('Align Middle');?></option>
                                        <option value="bottom"><?php echo JText::_('Align Bottom');?></option>
                                        <option value="left"><?php echo JText::_('Align Left');?></option>
                                        <option value="right"><?php echo JText::_('Align Right');?></option>
                                	</select>
                                    <label id="clearlabel" for="clear" class="disabled hastip" title="<?php echo JText::_('CLEAR DESC');?>"><?php echo JText::_('CLEAR');?></label>
                                    <select id="clear" disabled="disabled" onchange="ImageManagerDialog.updateStyles();">
                                        <option value=""><?php echo JText::_('Not Set');?></option>
                                        <option value="none"><?php echo JText::_('None');?></option>
                                        <option value="both"><?php echo JText::_('Both');?></option>
                                        <option value="left"><?php echo JText::_('Left');?></option>
                                        <option value="right"><?php echo JText::_('Right');?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="margin" class="hastip" title="<?php echo JText::_('MARGIN DESC');?>"><?php echo JText::_('Margin');?></label></td>
                                <td colspan="3">
                                	<label for="margin_top"><?php echo JText::_('Top');?></label><input type="text" id="margin_top" value="" size="4" maxlength="4" onChange="ImageManagerDialog.setMargins();" />
                                	<label for="margin_right"><?php echo JText::_('Right');?></label><input type="text" id="margin_right" value="" size="4" maxlength="4" onChange="ImageManagerDialog.setMargins();" />
                                	<label for="margin_bottom"><?php echo JText::_('Bottom');?></label><input type="text" id="margin_bottom" value="" size="4" maxlength="4" onChange="ImageManagerDialog.setMargins();" />
                                	<label for="margin_left"><?php echo JText::_('Left');?></label><input type="text" id="margin_left" value="" size="4" maxlength="4" onChange="ImageManagerDialog.setMargins();" />
                                	<input type="checkbox" class="checkbox" id="margin_check" onclick="ImageManagerDialog.setMargins();"><label><?php echo JText::_('Equal Values');?></label>
                                </td>
                            </tr>
                            <tr>
                            	<td><label for="border" class="hastip" title="<?php echo JText::_('BORDER DESC');?>"><?php echo JText::_('Border');?></label></td>
                            	<td colspan="3">
                            		<table cellpadding="0" cellspacing="0">
                            			<tr>
                            				<td><input type="checkbox" class="checkbox" id="border" onclick="ImageManagerDialog.setBorder();"></td>
                            				<td>
                                                <label for="border_width"><?php echo JText::_('Width');?></label>
                                                <select id="border_width" onchange="ImageManagerDialog.updateStyles();" class="mceEditableSelect">
                                                    <option value=""><?php echo JText::_('Not Set');?></option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="thin"><?php echo JText::_('BORDER THIN');?></option>
                                                    <option value="medium"><?php echo JText::_('BORDER MEDIUM');?></option>
                                                    <option value="thick"><?php echo JText::_('BORDER THICK');?></option>
                                                </select>
                                            </td>
                            				<td>
                                                <label for="border_style"><?php echo JText::_('Style');?></label>
                                                <select id="border_style" onchange="ImageManagerDialog.updateStyles();">
                                                    <option value=""><?php echo JText::_('Not Set');?></option>
                                                    <option value="none"><?php echo JText::_('BORDER NONE');?></option>
                                                    <option value="solid"><?php echo JText::_('BORDER SOLID');?></option>
                                                    <option value="dashed"><?php echo JText::_('BORDER DASHED');?></option>
                                                    <option value="dotted"><?php echo JText::_('BORDER DOTTED');?></option>
                                                    <option value="double"><?php echo JText::_('BORDER DOUBLE');?></option>
                                                    <option value="groove"><?php echo JText::_('BORDER GROOVE');?></option>
                                                    <option value="inset"><?php echo JText::_('BORDER INSET');?></option>
                                                    <option value="outset"><?php echo JText::_('BORDER OUTSET');?></option>
                                                    <option value="ridge"><?php echo JText::_('BORDER RIDGE');?></option>
                                                </select>
                                            </td>
                            				<td>
                            					<label for="border_color"><?php echo JText::_('Color');?></label>
                            					<input id="border_color" type="text" value="" size="9" onchange="TinyMCE_Utils.updateColor(this);ImageManagerDialog.updateStyles();" />
                            				</td>
                            				<td id="border_color_pickcontainer">&nbsp;</td>
                            			</tr>
                            		</table>
                            	</td>
                            </tr>
                        </table>
                    </fieldset>
            	</td>
            	<td style="vertical-align:top;">
            		<fieldset>
                        <legend><?php echo JText::_('Preview');?></legend>
                        <table cellpadding="3" cellspacing="0" border="0" style="height:150px;">
                            <tr>
                                <td style="vertical-align:top;">
                                	<div class="preview">
                                		<img id="sample" src="<?php echo $manager->image('sample.jpg', 'plugins');?>" alt="sample" />
                                		Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                                	</div>
                                </td>
                            </tr>
                        </table>
            		</fieldset>
            	</td>
            </tr>
		</table>
		</div>
            <div id="popup_panel" class="panel">
				<fieldset>
					<legend><input type="checkbox" id="popup_check" class="checkbox" /><label for="popup_check" class="hastip" title="<?php echo JText::_('POPUP ENABLE DESC');?>"><?php echo JText::_('ENABLE');?></label></legend>
					<table border="0" cellpadding="3" cellspacing="0">
							<tr>
								<td><label id="popup_typelabel" for="popup_type" class="hastip" title="<?php echo JText::_('POPUP TYPE DESC');?>"><?php echo JText::_('POPUP TYPE');?></label></td>
								<td colspan="3"><select id="popup_type" onChange="ImageManagerDialog.setPopupType(this.value);">
										<option value="jcepopup" selected="selected">JCE MediaBox</option>
										<option value="lightbox">Lightbox/Slimbox</option>
                                        <option value="thickbox">Thickbox</option>
                                        <option value="rokzoom">RokZoom</option>
                                        <option value="rokbox">RokBox</option>
										<option value="window">Window Popup</option>
									</select>
								</td>
                                <td id="popup_required">&nbsp;</td>
							</tr>
							<tr>
								<td><label for="popup_src" class="hastip" title="<?php echo JText::_('URL DESC');?>"><?php echo JText::_('URL');?></label></td>
								<td colspan="4"><input id="popup_src" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="popup_title" class="hastip" title="<?php echo JText::_('POPUP TITLE DESC');?>"><?php echo JText::_('POPUP TITLE');?></label></td>
								<td colspan="4"><input id="popup_title" type="text" value="" /></td>
							</tr>
							<tr id="popup_group_row">
								<td><label for="popup_group" class="hastip" title="<?php echo JText::_('POPUP GROUP DESC');?>"><?php echo JText::_('POPUP GROUP');?></label></td>
								<td colspan="4"><input id="popup_group" type="text" value="" /></td>
							</tr>
                            <tr id="popup_icon_row">
								<td><label for="popup_icon" class="hastip" title="<?php echo JText::_('POPUP ICON DESC');?>"><?php echo JText::_('POPUP ICON');?></label></td>
								<td><input id="popup_icon" type="checkbox" onclick="ImageManagerDialog.setPopupIcon();" disabled="disabled" checked="checked" /></td>
                                <td><label for="popup_icon_position" class="hastip" title="<?php echo JText::_('POPUP ICON POSITION DESC');?>"><?php echo JText::_('POPUP ICON POSITION');?></label></td>
								<td><select id="popup_icon_position" disabled="disabled">
                                		<option value=""><?php echo JText::_('NOT SET');?></option>
                                        <option value="icon-left"><?php echo JText::_('LEFT');?></option>
                                        <option value="icon-right"><?php echo JText::_('RIGHT');?></option>
                                        <option value="icon-top-left"><?php echo JText::_('TOP LEFT');?></option>
                                        <option value="icon-top-right"><?php echo JText::_('TOP RIGHT');?></option>                                        
                                        <option value="icon-bottom-left"><?php echo JText::_('BOTTOM LEFT');?></option>
                                        <option value="icon-bottom-right"><?php echo JText::_('BOTTOM RIGHT');?></option>
                                    </select>
                                </td>
							</tr>
                            <tr id="popup_dimensions_row" style="display:none;">
                            	<td><label for="popup_dimensions" class="hastip" title="<?php echo JText::_('DIMENSIONS DESC');?>"><?php echo JText::_('DIMENSIONS');?></label></td>
								<td colspan="4">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                            <input type="text" id="popup_width" value="" onchange="ImageManagerDialog.setDimensions('popup_width', 'popup_height');" onblur="ImageManagerDialog.setDimensions('popup_width', 'popup_height');" /> x <input type="text" id="popup_height" value="" onchange="ImageManagerDialog.setDimensions('popup_height', 'popup_width');" onblur="ImageManagerDialog.setDimensions('popup_height', 'popup_width');" /></td>
                                            <input type="hidden" id="tmp_popup_width" value=""  />
                                            <input type="hidden" id="tmp_popup_height" value="" />
                                            <td>&nbsp;&nbsp;<input id="popup_constrain" type="checkbox" class="check" checked="checked" /></td>
                                            <td><label for="popup_constrain"><?php echo JText::_('Proportional');?></label></td>
                                            <td><div id="popup_loader"></div></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr id="popup_mode_row" style="display:none;">
                                <td><label for="popup_mode" class="hastip" title="<?php echo JText::_('POPUP MODE DESC');?>"><?php echo JText::_('POPUP MODE');?></label></td>
                                <td colspan="4">
                                    <select id="popup_mode" onChange="ImageManagerDialog.setPopupMode(this.value);">
                                        <option value="0"><?php echo JText::_('Basic');?></option>
                                        <option value="1"><?php echo JText::_('Advanced');?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="popup_features_row" style="display:none;">
                                <td><label for="popup_features" class="hastip" title="<?php echo JText::_('POPUP FEATURES DESC');?>"><?php echo JText::_('POPUP FEATURES');?></label></td>
                                <td><input type="checkbox" id="popup_print" class="checkbox" disabled="disabled" /><label for="popup_print" class="hastip" title="<?php echo JText::_('POPUP PRINT DESC');?>"><?php echo JText::_('POPUP PRINT');?></label></td>
                                <td><input type="checkbox" id="popup_rightclick" class="checkbox" disabled="disabled" /><label for="popup_rightclick" class="hastip" title="<?php echo JText::_('POPUP CLICK DESC');?>"><?php echo JText::_('POPUP CLICK');?></label></td>
                                <td><input type="checkbox" id="popup_scrollbars" class="checkbox" disabled="disabled" /><label for="popup_scrollbars" class="hastip" title="<?php echo JText::_('POPUP SCROLLBARS DESC');?>"><?php echo JText::_('POPUP SCROLLBARS');?></label></td>
                                <td><input type="checkbox" id="popup_resizable" class="checkbox" disabled="disabled" /><label for="popup_resizable" class="hastip" title="<?php echo JText::_('POPUP RESIZABLE DESC');?>"><?php echo JText::_('POPUP RESIZABLE');?></label></td>
                            </tr>
					</table>
				</fieldset>
            </div>
            <div id="swap_panel" class="panel">
                <fieldset>
                    <legend><input type="checkbox" id="onmousemovecheck" class="checkbox" onclick="ImageManagerDialog.setSwapImage();" /><label for="onmousemovecheck" class="hastip" title="<?php echo JText::_('ROLLOVER ENABLE DESC');?>"><?php echo JText::_('ENABLE');?></label></legend>    
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                            <tr>
                                <td><label for="onmouseoversrc" class="hastip" title="<?php echo JText::_('MOUSEOVER DESC');?>"><?php echo JText::_('MOUSEOVER');?></label></td>
                                <td><input id="onmouseoversrc" type="text" value="" disabled="disabled" /></td>
                            </tr>
                            <tr>
                                <td><label for="onmouseoutsrc" class="hastip" title="<?php echo JText::_('MOUSEOUT DESC');?>"><?php echo JText::_('MOUSEOUT');?></label></td>
                                <td><input id="onmouseoutsrc" type="text" value="" disabled="disabled" /></td>
                            </tr>
                    </table>
                </fieldset>
            </div>
            <div id="tooltip_panel" class="panel">
				<fieldset>
					<legend><input type="checkbox" id="tooltip_check" class="checkbox" onclick="ImageManagerDialog.setTooltip();" /><label for="tooltip_check" class="hastip" title="<?php echo JText::_('TOOLTIP ENABLE DESC');?>"><?php echo JText::_('ENABLE');?></label></legend>
					<table border="0" cellpadding="4" cellspacing="0" width="100%">
							<tr>
								<td><label for="tooltip_title"><?php echo JText::_('Title');?></label></td>
								<td><input id="tooltip_title" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="tooltip_text"><?php echo JText::_('Text');?></label></td>
								<td><textarea id="tooltip_text" rows="5" cols="50" type="text" value=""></textarea></td>
							</tr>
					</table>
				</fieldset>
            </div>
            <div id="advanced_panel" class="panel">
                <fieldset>
                    <legend><?php echo JText::_('Attributes');?></legend>
                    <table border="0" cellpadding="4" cellspacing="0">
                        <tr>
                            <td><label for="style" class="hastip" title="<?php echo JText::_('STYLE DESC');?>"><?php echo JText::_('STYLE');?></label></td>
                            <td colspan="2"><input id="style" type="text" value="" onchange="ImageManagerDialog.setStyles();" /></td>
                        </tr>
                        <tr>
                            <td><label for="classlist" class="hastip" title="<?php echo JText::_('CLASS LIST DESC');?>"><?php echo JText::_('CLASS LIST');?></label></td>
                            <td colspan="2">
                                <select id="classlist" onchange="ImageManagerDialog.setClasses(this.value);">
                                    <option value=""><?php echo JText::_('NOT SET');?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                             <td><label for="title" class="hastip" title="<?php echo JText::_('CLASSES DESC');?>"><?php echo JText::_('CLASSES');?></label></td>
                             <td colspan="3"><input id="classes" type="text" value="" /></td>
                        </tr>
                        <tr>
                             <td><label for="title" class="hastip" title="<?php echo JText::_('TITLE DESC');?>"><?php echo JText::_('TITLE');?></label></td>
                             <td colspan="3"><input id="title" type="text" value="" /></td>
                        </tr>
                        <tr>
                            <td><label for="id" class="hastip" title="<?php echo JText::_('ID DESC');?>"><?php echo JText::_('ID');?></label></td>
                            <td colspan="2"><input id="id" type="text" value="" /></td>
                        </tr>
    
                        <tr>
                            <td><label for="dir" class="hastip" title="<?php echo JText::_('LANGUAGE DIRECTION DESC');?>"><?php echo JText::_('LANGUAGE DIRECTION');?></label></td>
                            <td colspan="2">
                                <select id="dir" onchange="ImageManagerDialog.updateStyles();">
                                        <option value=""><?php echo JText::_('Not Set');?></option>
                                        <option value="ltr"><?php echo JText::_('LTR');?></option>
                                        <option value="rtl"><?php echo JText::_('RTL');?></option>
                                </select>
                            </td>
                        </tr>
    
                        <tr>
                            <td><label for="lang" class="hastip" title="<?php echo JText::_('LANGUAGE CODE DESC');?>"><?php echo JText::_('LANGUAGE CODE');?></label></td>
                            <td colspan="2"><input id="lang" type="text" value="" /></td>
                        </tr>
    
                        <tr>
                            <td><label for="usemap" class="hastip" title="<?php echo JText::_('USEMAP DESC');?>"><?php echo JText::_('USEMAP');?></label></td>
                            <td colspan="2"><input id="usemap" type="text" value="" /></td>
                        </tr>
    
                        <tr>
                            <td><label for="longdesc" class="hastip" title="<?php echo JText::_('LONGDESC DESC');?>"><?php echo JText::_('LONGDESC');?></label></td>
                            <td><input id="longdesc" type="text" value="" /></td>
                            <td id="longdesccontainer">&nbsp;</td>
                        </tr>
                    </table>
                </fieldset>
            </div>
        </div>
    <?php $manager->loadBrowser();?>
	<div class="mceActionPanel">
		<div style="float: right">
    		<input type="button" class="button "id="refresh" value="<?php echo JText::_('Refresh');?>" />
			<input type="button" id="insert" value="<?php echo JText::_('Insert');?>" onClick="ImageManagerDialog.insert();" />
			<input type="button" id="cancel" value="<?php echo JText::_('Cancel');?>" onClick="tinyMCEPopup.close();" />
		</div>
	</div>
</body> 
</html>