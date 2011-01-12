<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
global $mainframe;

$version 		= "1.5.6.2";
// JCE Utilities Popup version
$popup_version 	= "1.0.8+";

require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'editor.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'plugin.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'utils.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'manager.php' );

require_once( dirname( __FILE__ ) .DS. 'classes' .DS. 'mediamanager.php' );

$manager =& MediaManager::getInstance();

// check the user/group has editor permissions
$manager->checkPlugin() or die( 'Restricted access' );

// Load Plugin Parameters
$params	= $manager->getPluginParams();

$manager->changeButton( 'file', 'view', array( 'action' => 'this.viewMedia' ) );

$manager->setXHR( array( &$manager, 'getDimensions' ) );

$manager->script( array( 'mediamanager' ), 'plugins' );
$manager->css( array( 'mediamanager' ), 'plugins' );

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
	<title><?php echo JText::_('PLUGIN TITLE').' : '.$version;?></title>
<?php
$manager->printScripts();
$manager->printCss();	
?>
	<link href="<?php echo $manager->getSkin();?>/window.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
		MediaManagerDialog.settings=<?php echo $manager->getSettings();?>
	</script>
    <?php echo $manager->printHead();?>
</head>
<body lang="<?php echo $manager->getLanguage(); ?>" id="mediamanager" style="display: none;">
    <div class="tabs">
			<ul>
				<li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onmousedown="return false;"><?php echo JText::_('File');?></a></span></li>
            	<li id="media_tab"><span><a href="javascript:mcTabs.displayTab('media_tab','media_panel');" onMouseDown="return false;"><?php echo JText::_('Options');?></a></span></li>
                <li id="advanced_tab"><span><a href="javascript:mcTabs.displayTab('advanced_tab','advanced_panel');" onMouseDown="return false;"><?php echo JText::_('Advanced');?></a></span></li>
            	<li id="popup_tab"><span><a href="javascript:mcTabs.displayTab('popup_tab','popup_panel');" onMouseDown="return false;"><?php echo JText::_('Popup');?></a></span></li>
            </ul>
		</div>
		<div class="panel_wrapper">
			<div id="general_panel" class="panel current">
				<table>
    				<tr>
    					<td style="vertical-align:top;width:70%;">
                        <fieldset>
                            <legend><?php echo JText::_('Properties');?></legend>
                            <table cellpadding="3" cellspacing="0" border="0" style="height:150px;">
                                    <tr>
                                        <td><label for="media_type"><?php echo JText::_('Type');?></label></td>
                                        <td colspan="3"><select id="media_type" onChange="MediaManagerDialog.changedType(this.value);">
                                                <option value="flash"><?php echo JText::_('Flash');?></option>
                                                <option value="quicktime"><?php echo JText::_('Quicktime');?></option>
                                                <option value="director"><?php echo JText::_('Director');?></option>
                                                <option value="windowsmedia"><?php echo JText::_('Windows Media');?></option>
                                                <option value="real"><?php echo JText::_('Real Media');?></option>
                                                <option value="divx"><?php echo JText::_('DivX');?></option>
												<option value="audio"><?php echo JText::_('HTML5 Audio');?></option>
												<option value="video"><?php echo JText::_('HTML5 Video');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="src" class="hastip" title="<?php echo JText::_('URL DESC');?>"><?php echo JText::_('URL');?></label></td>
                                        <td colspan="3"><input id="src" type="text" value="" onChange="MediaManagerDialog.switchType(this.value);" class="required" /></td>
                                    </tr>
                                    <tr>
                                        <td><label for="width" class="hastip" title="<?php echo JText::_('DIMENSIONS DESC');?>"><?php echo JText::_('DIMENSIONS');?></label></td>
                                        <td colspan="3">
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <input type="text" id="width" class="required" value="" onchange="MediaManagerDialog.setDimensions('width', 'height');" /> x <input type="text" id="height" class="required" value="" onChange="MediaManagerDialog.setDimensions('height', 'width');" />
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
                                    <td colspan="3">
                                        <select id="align" onchange="MediaManagerDialog.updateStyles();">
                                            <option value=""><?php echo JText::_('Align Default');?></option>
                                            <option value="top"><?php echo JText::_('Align Top');?></option>
                                            <option value="middle"><?php echo JText::_('Align Middle');?></option>
                                            <option value="bottom"><?php echo JText::_('Align Bottom');?></option>
                                            <option value="left"><?php echo JText::_('Align Left');?></option>
                                            <option value="right"><?php echo JText::_('Align Right');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="hastip" title="<?php echo JText::_('MARGIN DESC');?>"><?php echo JText::_('MARGIN');?></label></td>
                                    <td colspan="3">
                                        <label for="margin_top"><?php echo JText::_('Top');?></label><input type="text" id="margin_top" value="" size="3" maxlength="3" onChange="MediaManagerDialog.setMargins();" />
                                        <label for="margin_right"><?php echo JText::_('Right');?></label><input type="text" id="margin_right" value="" size="3" maxlength="3" onChange="MediaManagerDialog.setMargins();" />
                                        <label for="margin_bottom"><?php echo JText::_('Bottom');?></label><input type="text" id="margin_bottom" value="" size="3" maxlength="3" onChange="MediaManagerDialog.setMargins();" />
                                        <label for="margin_left"><?php echo JText::_('Left');?></label><input type="text" id="margin_left" value="" size="3" maxlength="3" onChange="MediaManagerDialog.setMargins();" />
                                        <input type="checkbox" class="checkbox" id="margin_check" onclick="MediaManagerDialog.setMargins();"><label><?php echo JText::_('Equal Values');?></label>
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
                            		<td class="preview" style="vertical-align:top;">
                                            <img id="sample" src="<?php echo $manager->image('sample.jpg', 'plugins');?>" alt="sample" />
                                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                            		</td>
                                </tr>
                            </table>
                    	</fieldset>
                    </td>
                </tr>
    		</table>
			</div>
			<div id="advanced_panel" class="panel">
                <fieldset>
					<legend><?php echo JText::_('Advanced');?></legend>
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td><label for="id" class="hastip" title="<?php echo JText::_('ID DESC');?>"><?php echo JText::_('ID');?></label></td>
                            <td><input type="text" id="id" /></td>
                        </tr>
                        <tr>
                        	<td><label for="name" class="hastip" title="<?php echo JText::_('NAME DESC');?>"><?php echo JText::_('NAME');?></label></td>
                            <td><input type="text" id="name" /></td>
                        </tr>
                        <tr>
                            <td><label for="style" class="hastip" title="<?php echo JText::_('STYLE DESC');?>"><?php echo JText::_('STYLE');?></label></td>
                            <td><input id="style" type="text" value="" /></td>
                        </tr>
                        <tr>
                            <td><label for="classes" class="hastip" title="<?php echo JText::_('CLASSES DESC');?>"><?php echo JText::_('CLASSES');?></label></td>
                            <td><input id="classes" type="text" value="" /></td>
                        </tr>
                        <tr>
                            <td><label for="classlist" class="hastip" title="<?php echo JText::_('CLASS LIST DESC');?>"><?php echo JText::_('CLASS LIST');?></label></td>
                            <td>
                            <select id="classlist" onchange="MediaManagerDialog.setClasses(this.value);">
                            	<option value=""><?php echo JText::_('NOT SET');?></option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                        	<td><label for="bgcolor" class="hastip" title="<?php echo JText::_('BGCOLOR DESC');?>"><?php echo JText::_('BGCOLOR');?></label></td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input id="bgcolor" type="text" value="" size="9" onChange="TinyMCE_Utils.updateColor('bgcolor');MediaManagerDialog.updateStyles();" /></td>
										<td id="bgcolor_pickcontainer">&nbsp;</td>
									</tr>
								</table>
							</td>
                        </tr>
                        <tr>
                            <td><label class="hastip" title="<?php echo JText::_('BORDER DESC');?>"><?php echo JText::_('Border');?></label></td>
                            <td colspan="3">
                            <table cellspacing="0">
                                <tr>
                                    <td><input type="checkbox" class="checkbox" id="border" onclick="MediaManagerDialog.setBorder(this.checked);"></td>
                                    <td><label for="border_width"><?php echo JText::_('Width');?></label></td>
                                    <td>
                                    <select id="border_width" onchange="MediaManagerDialog.updateStyles();" class="mceEditableSelect">
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
                                    <td><label for="border_style"><?php echo JText::_('Style');?></label></td>
                                    <td>
                                        <select id="border_style" onchange="MediaManagerDialog.updateStyles();">
                                            <option value="none"><?php echo JText::_('BORDER NONE');?></option>
                                            <option value="solid" selected="selected"><?php echo JText::_('BORDER SOLID');?></option>
                                            <option value="dashed"><?php echo JText::_('BORDER DASHED');?></option>
                                            <option value="dotted"><?php echo JText::_('BORDER DOTTED');?></option>
                                            <option value="double"><?php echo JText::_('BORDER DOUBLE');?></option>
                                            <option value="groove"><?php echo JText::_('BORDER GROOVE');?></option>
                                            <option value="inset"><?php echo JText::_('BORDER INSET');?></option>
                                            <option value="outset"><?php echo JText::_('BORDER OUTSET');?></option>
                                            <option value="ridge"><?php echo JText::_('BORDER RIDGE');?></option>
                                        </select>
                                    </td>
                                    <td><label for="border_color"><?php echo JText::_('Color');?></label></td>
                                    <td><input id="border_color" type="text" value="#000000" size="9" onchange="TinyMCE_Utils.updateColor(this);ImageManagerDialog.updateStyles();" /></td>
                                    <td id="border_color_pickcontainer">&nbsp;</td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                           <td><label for="controller_height" class="hastip" title="<?php echo JText::_('CONTROLLER HEIGHT DESC');?>"><?php echo JText::_('CONTROLLER HEIGHT');?></label></td>
                           <td><input type="text" id="controller_height" value="" /></td>
                        </tr>
                    </table>
            	</fieldset>
            </div>
            <div id="media_panel" class="panel"> 
				<fieldset id="flash_options">
					<legend><?php echo JText::_('Flash Options');?></legend>
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td><label for="flash_quality"><?php echo JText::_('quality');?></label></td>
							<td>
								<select id="flash_quality">
									<option value=""><?php echo JText::_('not set');?></option> 
									<option value="high"><?php echo JText::_('high');?></option>
									<option value="low"><?php echo JText::_('low');?></option>
									<option value="autolow"><?php echo JText::_('autolow');?></option>
									<option value="autohigh"><?php echo JText::_('autohigh');?></option>
									<option value="best"><?php echo JText::_('best');?></option>
								</select>
							</td>

							<td><label for="flash_scale"><?php echo JText::_('scale');?></label></td>
							<td>
								<select id="flash_scale">
									<option value=""><?php echo JText::_('not set');?></option> 
									<option value="showall"><?php echo JText::_('showall');?></option>
									<option value="noborder"><?php echo JText::_('noborder');?></option>
									<option value="exactfit"><?php echo JText::_('exactfit');?></option>
								</select>
							</td>
						</tr>

						<tr>
							<td><label for="flash_wmode"><?php echo JText::_('wmode');?></label></td>
							<td>
								<select id="flash_wmode">
									<option value=""><?php echo JText::_('not set');?></option> 
									<option value="window"><?php echo JText::_('window');?></option>
									<option value="opaque"><?php echo JText::_('opaque');?></option>
									<option value="transparent" selected="selected"><?php echo JText::_('transparent');?></option>
								</select>
							</td>

							<td><label for="flash_salign"><?php echo JText::_('salign');?></label></td>
							<td>
								<select id="flash_salign">
									<option value=""><?php echo JText::_('not set');?></option> 
									<option value="l"><?php echo JText::_('left');?></option>
									<option value="t"><?php echo JText::_('top');?></option>
									<option value="r"><?php echo JText::_('righ');?>t</option>
									<option value="b"><?php echo JText::_('bottom');?></option>
									<option value="tl"><?php echo JText::_('top-left');?></option>
									<option value="tr"><?php echo JText::_('top_right');?></option>
									<option value="bl"><?php echo JText::_('bottom-left');?></option>
									<option value="br"><?php echo JText::_('bottom-right');?></option>
								</select>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_play" checked="checked" /></td>
										<td><label for="flash_play"><?php echo JText::_('play');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_loop" checked="checked" /></td>
										<td><label for="flash_loop"><?php echo JText::_('loop');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_menu" checked="checked" /></td>
										<td><label for="flash_menu"><?php echo JText::_('menu');?></label></td>
									</tr>
								</table>
							</td>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_swliveconnect" /></td>
										<td><label for="flash_swliveconnect"><?php echo JText::_('liveconnect');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
                        <tr>
							<td colspan="4">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_allowfullscreen" /></td>
										<td><label for="flash_allowfullscreen"><?php echo JText::_('allowfullscreen', 'allowFullScreen');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

					<table>
						<tr>
							<td><label for="flash_base"><?php echo JText::_('base');?></label></td>
							<td><input type="text" id="flash_base" /></td>
						</tr>

						<tr>
							<td><label for="flash_flashVars"><?php echo JText::_('flashvars');?></label></td>
							<td><input type="text" id="flash_flashvars" /></td>
						</tr>
					</table>
				</fieldset>
				<fieldset id="flv_options">
					<legend><?php echo JText::_('flv options');?></legend>
					<table border="0" cellpadding="4" cellspacing="0" width="100%">
						<tr>
                        	<td colspan="4">
                        	<input type="checkbox" class="checkbox" id="flv_absolute" />
							<label for="flv_absolute" title="<?php echo JText::_('ABSOLUTE URL DESC');?>" class="hastip"><?php echo JText::_('Absolute URL');?></label>
                            </td>
                            <td rowspan="5" style="vertical-align:top;"><div id="flv_preview"><div id="flv_preview_container"></div></div></td>
                        </tr>
                        <tr>
							<td><input type="checkbox" class="checkbox" id="flv_autostart" />
							<label for="flv_autostart"><?php echo JText::_('play');?></label>
                            </td>
                            <td>
							<input type="checkbox" class="checkbox" id="flv_repeat" />
							<label for="flv_repeat"><?php echo JText::_('loop');?></label>
                            </td>
                            <td colspan="2"><label for="flv_bufferlength"><?php echo JText::_('buffer');?></label>
							<input type="text" size="3" id="flv_bufferlength" value="" /></td>
						</tr>
                        <tr>
							<td><input type="checkbox" class="checkbox" id="flv_frontcolor_check" onclick="MediaManagerDialog.setFlvPreview();" /><label for="flv_frontcolor1"><?php echo JText::_('Color Dark');?></label></td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
                                        <td><input id="flv_frontcolor" type="text" value="#333333" size="9" onChange="TinyMCE_Utils.updateColor('flv_frontcolor');MediaManagerDialog.setFlvPreview();" /></td>
										<td id="flv_frontcolor_pickcontainer">&nbsp;</td>
									</tr>
								</table>
							</td>
							<td><input type="checkbox" class="checkbox" id="flv_lightcolor_check" onclick="MediaManagerDialog.setFlvPreview();" /><label for="flv_lightcolor"><?php echo JText::_('Color Light');?></label></td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input id="flv_lightcolor" type="text" value="#999999" size="9" onChange="TinyMCE_Utils.updateColor('flv_lightcolor');MediaManagerDialog.setFlvPreview();" /></td>
										<td id="flv_lightcolor_pickcontainer">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
                        <tr>
							<td><input type="checkbox" class="checkbox" id="flv_screencolor_check" onclick="MediaManagerDialog.setFlvPreview();" /><label for="flv_screencolor"><?php echo JText::_('Color Screen');?></label></td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										
                                        <td><input id="flv_screencolor" type="text" value="#000000" size="9" onChange="TinyMCE_Utils.updateColor('flv_screencolor');" /></td>
										<td id="flv_screencolor_pickcontainer">&nbsp;</td>
									</tr>
								</table>
							</td>
							<td><input type="checkbox" class="checkbox" id="flv_backcolor_check" onclick="MediaManagerDialog.setFlvPreview();" /><label for="flv_backcolor"><?php echo JText::_('Color Back');?></label></td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input id="flv_backcolor" type="text" value="#999999" size="9" onChange="TinyMCE_Utils.updateColor('flv_backcolor');" /></td>
										<td id="flv_backcolor_pickcontainer">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
                        <tr>
							<td colspan="4"><table><tr><td><label for="flv_image"><?php echo JText::_('Thumbnail');?></label></td><td><input id="flv_image" type="text" value="" size="50" onchange="MediaManagerDialog.setFlvPreview();"/></td>
							<td id="flv_image_browsercontainer">&nbsp;</td></tr></table></td>
						</tr>
					</table>
				</fieldset>
				<fieldset id="quicktime_options">
					<legend><?php echo JText::_('Quicktime Options');?></legend>
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="quicktime_loop" /></td>
										<td><label for="quicktime_loop"><?php echo JText::_('loop');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="quicktime_autoplay" /></td>
										<td><label for="quicktime_autoplay"><?php echo JText::_('play');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="quicktime_cache" /></td>
										<td><label for="quicktime_cache"><?php echo JText::_('cache');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="quicktime_controller" checked="checked" /></td>
										<td><label for="quicktime_controller"><?php echo JText::_('controller');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="quicktime_correction" /></td>
										<td><label for="quicktime_correction"><?php echo JText::_('correction');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="quicktime_enablejavascript" /></td>
										<td><label for="quicktime_enablejavascript"><?php echo JText::_('enablejavascript');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="quicktime_kioskmode" /></td>
										<td><label for="quicktime_kioskmode"><?php echo JText::_('kioskmode');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="quicktime_autohref" /></td>
										<td><label for="quicktime_autohref"><?php echo JText::_('autohref');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="quicktime_playeveryframe" /></td>
										<td><label for="quicktime_playeveryframe"><?php echo JText::_('playeveryframe');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="quicktime_targetcache"  /></td>
										<td><label for="quicktime_targetcache"><?php echo JText::_('targetcache');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td><label for="quicktime_scale"><?php echo JText::_('scale');?></label></td>
							<td><select id="quicktime_scale" class="mceEditableSelect">
									<option value=""><?php echo JText::_('not set');?></option> 
									<option value="tofit"><?php echo JText::_('tofit');?>/option>
									<option value="aspect"><?php echo JText::_('aspect');?></option>
								</select>
							</td>

							<td colspan="2">&nbsp;</td>
						</tr>

						<tr>
							<td><label for="quicktime_starttime"><?php echo JText::_('starttime');?></label></td>
							<td><input type="text" id="quicktime_starttime" /></td>

							<td><label for="quicktime_endtime"><?php echo JText::_('endtime');?></label></td>
							<td><input type="text" id="quicktime_endtime" /></td>
						</tr>

						<tr>
							<td><label for="quicktime_target"><?php echo JText::_('target');?></label></td>
							<td><input type="text" id="quicktime_target" /></td>

							<td><label for="quicktime_href"><?php echo JText::_('href');?></label></td>
							<td><input type="text" id="quicktime_href" /></td>
						</tr>

						<tr>
							<td><label for="quicktime_qtsrcchokespeed"><?php echo JText::_('qtsrcchokespeed');?></label></td>
							<td><input type="text" id="quicktime_qtsrcchokespeed" /></td>

							<td><label for="quicktime_volume"><?php echo JText::_('volume');?></label></td>
							<td><input type="text" id="quicktime_volume" /></td>
						</tr>

						<tr>
							<td><label for="quicktime_qtsrc"><?php echo JText::_('qtsrc');?></label></td>
							<td colspan="4">
							<table border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td><input type="text" id="quicktime_qtsrc" /></td>
									<td id="qtsrcfilebrowsercontainer">&nbsp;</td>
								  </tr>
							</table>
							</td>
						</tr>
					</table>
				</fieldset>

				<fieldset id="windowsmedia_options">
					<legend><?php echo JText::_('windowsmedia options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="windowsmedia_autostart" /></td>
										<td><label for="windowsmedia_autostart"><?php echo JText::_('autostart');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="windowsmedia_enabled" /></td>
										<td><label for="windowsmedia_enabled"><?php echo JText::_('enabled');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="windowsmedia_enablecontextmenu" checked="checked" /></td>
										<td><label for="windowsmedia_enablecontextmenu"><?php echo JText::_('menu');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="windowsmedia_fullscreen" /></td>
										<td><label for="windowsmedia_fullscreen"><?php echo JText::_('fullscreen');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="windowsmedia_invokeurls" checked="checked" /></td>
										<td><label for="windowsmedia_invokeurls"><?php echo JText::_('invokeurls');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="windowsmedia_mute" /></td>
										<td><label for="windowsmedia_mute"><?php echo JText::_('mute');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="windowsmedia_stretchtofit" /></td>
										<td><label for="windowsmedia_stretchtofit"><?php echo JText::_('stretchtofit');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="windowsmedia_windowlessvideo" /></td>
										<td><label for="windowsmedia_windowlessvideo"><?php echo JText::_('windowlessvideo');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td><label for="windowsmedia_balance"><?php echo JText::_('balance');?></label></td>
							<td><input type="text" id="windowsmedia_balance" /></td>

							<td><label for="windowsmedia_baseurl"><?php echo JText::_('baseurl');?></label></td>
							<td><input type="text" id="windowsmedia_baseurl" /></td>
						</tr>

						<tr>
							<td><label for="windowsmedia_captioningid"><?php echo JText::_('captioningid');?></label></td>
							<td><input type="text" id="windowsmedia_captioningid" /></td>

							<td><label for="windowsmedia_currentmarker"><?php echo JText::_('currentmarker');?></label></td>
							<td><input type="text" id="windowsmedia_currentmarker" /></td>
						</tr>

						<tr>
							<td><label for="windowsmedia_currentposition"><?php echo JText::_('currentposition');?></label></td>
							<td><input type="text" id="windowsmedia_currentposition" /></td>

							<td><label for="windowsmedia_defaultframe"><?php echo JText::_('defaultframe');?></label></td>
							<td><input type="text" id="windowsmedia_defaultframe" /></td>
						</tr>

						<tr>
							<td><label for="windowsmedia_playcount"><?php echo JText::_('playcount');?></label></td>
							<td><input type="text" id="windowsmedia_playcount" /></td>

							<td><label for="windowsmedia_rate"><?php echo JText::_('rate');?></label></td>
							<td><input type="text" id="windowsmedia_rate" /></td>
						</tr>

						<tr>
							<td><label for="windowsmedia_uimode"><?php echo JText::_('uimode');?></label></td>
							<td><input type="text" id="windowsmedia_uimode" /></td>

							<td><label for="windowsmedia_volume"><?php echo JText::_('volume');?></label></td>
							<td><input type="text" id="windowsmedia_volume" /></td>
						</tr>

					</table>
				</fieldset>

				<fieldset id="real_options">
					<legend><?php echo JText::_('rmp options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="real_autostart" /></td>
										<td><label for="real_autostart"><?php echo JText::_('autostart');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="real_loop" /></td>
										<td><label for="real_loop"><?php echo JText::_('loop');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="real_autogotourl" checked="checked" /></td>
										<td><label for="real_autogotourl"><?php echo JText::_('autogotourl');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="real_center" /></td>
										<td><label for="real_center"><?php echo JText::_('center');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="real_imagestatus" checked="checked" /></td>
										<td><label for="real_imagestatus"><?php echo JText::_('imagestatus');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="real_maintainaspect" /></td>
										<td><label for="real_maintainaspect"><?php echo JText::_('maintainaspect');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="real_nojava" /></td>
										<td><label for="real_nojava"><?php echo JText::_('nojava');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="real_prefetch" /></td>
										<td><label for="real_prefetch"><?php echo JText::_('prefetch');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="real_shuffle" /></td>
										<td><label for="real_shuffle"><?php echo JText::_('shuffle');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">&nbsp;
								
							</td>
						</tr>

						<tr>
							<td><label for="real_console"><?php echo JText::_('console');?></label></td>
							<td><input type="text" id="real_console" /></td>

							<td><label for="real_controls"><?php echo JText::_('controls');?></label></td>
							<td><input type="text" id="real_controls" /></td>
						</tr>

						<tr>
							<td><label for="real_numloop"><?php echo JText::_('numloop');?></label></td>
							<td><input type="text" id="real_numloop" /></td>

							<td><label for="real_scriptcallbacks"><?php echo JText::_('scriptcallbacks');?></label></td>
							<td><input type="text" id="real_scriptcallbacks" /></td>
						</tr>
					</table>
				</fieldset>

				<fieldset id="director_options">
					<legend><?php echo JText::_('director options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td><label for="director_swstretchstyle"><?php echo JText::_('swstretchstyle');?></label></td>
							<td>
								<select id="director_swstretchstyle">
									<option value="none"><?php echo JText::_('None');?></option>
									<option value="meet"><?php echo JText::_('Meet');?></option>
									<option value="fill"><?php echo JText::_('Fill');?></option>
									<option value="stage"><?php echo JText::_('Stage');?></option>
								</select>
							</td>

							<td><label for="director_swvolume"><?php echo JText::_('volume');?></label></td>
							<td><input type="text" id="director_swvolume" /></td>
						</tr>

						<tr>
							<td><label for="director_swstretchhalign"><?php echo JText::_('swstretchhalign');?></label></td>
							<td>
								<select id="director_swstretchhalign">
									<option value="none"><?php echo JText::_('None');?></option>
									<option value="left"><?php echo JText::_('left');?></option>
									<option value="center"><?php echo JText::_('center');?></option>
									<option value="right"><?php echo JText::_('right');?></option>
								</select>
							</td>

							<td><label for="director_swstretchvalign"><?php echo JText::_('swstretchvalign');?></label></td>
							<td>
								<select id="director_swstretchvalign">
									<option value="none"><?php echo JText::_('None');?></option>
									<option value="meet"><?php echo JText::_('Top');?></option>
									<option value="fill"><?php echo JText::_('Center');?></option>
									<option value="stage"><?php echo JText::_('Bottom');?></option>
								</select>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="director_autostart" checked="checked" /></td>
										<td><label for="director_autostart"><?php echo JText::_('autostart');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="director_sound" checked="checked" /></td>
										<td><label for="director_sound"><?php echo JText::_('sound');?></label></td>
									</tr>
								</table>
							</td>
						</tr>


						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="director_swliveconnect" /></td>
										<td><label for="director_swliveconnect"><?php echo JText::_('liveconnect');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="director_progress" checked="checked" /></td>
										<td><label for="director_progress"><?php echo JText::_('progress');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</fieldset>                
                <fieldset id="divx_options">
					<legend><?php echo JText::_('DivX Options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="divx_loop" /></td>
										<td><label for="divx_loop"><?php echo JText::_('Loop');?></label></td>
									</tr>
								</table>
							</td>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="divx_bannerenabled" checked="checked" /></td>
										<td><label for="divx_bannerenabled"><?php echo JText::_('bannerEnabled');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
                        <tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="divx_autoplay" checked="checked" /></td>
										<td><label for="divx_autoplay"><?php echo JText::_('play');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="divx_allowcontextmenu" checked="checked" /></td>
										<td><label for="divx_allowcontextmenu"><?php echo JText::_('allowContextMenu');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
                        <tr>
							<td><label for="divx_mode"><?php echo JText::_('Mode');?></label></td>
							<td>
								<select id="divx_mode" onChange="MediaManagerDialog.setControllerHeight('divx');">
									<option value="null"><?php echo JText::_('Null');?></option>
									<option value="zero"><?php echo JText::_('Zero');?></option>
									<option value="mini"><?php echo JText::_('Mini');?></option>
									<option value="large"><?php echo JText::_('Large');?></option>
                                    <option value="full"><?php echo JText::_('Full');?></option>
								</select>
							</td>
                            <td><label for="divx_bufferingmode"><?php echo JText::_('bufferingMode');?></label></td>
							<td>
								<select id="divx_bufferingmode">
									<option value="null"><?php echo JText::_('Null');?></option>
									<option value="auto"><?php echo JText::_('Auto');?></option>
									<option value="full"><?php echo JText::_('Full');?></option>
								</select>
							</td>
						</tr>
                        <tr>
                            <td><label for="divx_previewmessage"><?php echo JText::_('previewMessage');?></label></td>
                            <td><input type="text" id="divx_previewmessage" /></td>
                            <td><label for="divx_movietitle"><?php echo JText::_('movieTitle');?></label></td>
                            <td><input type="text" id="divx_movietitle" /></td>
                        </tr>
                        <tr>
                            <td><label for="divx_previewmessagefontsize"><?php echo JText::_('previewMessageFontSize');?></label></td>
                            <td><input type="text" id="divx_previewmessagefontsize" /></td>
                            <td><label for="divx_minversion"><?php echo JText::_('minVersion');?></label></td>
                            <td><input type="text" id="divx_minversion" /></td>
                        </tr>
                        
                        <tr>
                            <td><label for="divx_previewimage"><?php echo JText::_('previewImage');?></label></td>
                            <td><input type="text" id="divx_previewimage" /></td>
                            <td colspan="2" id="divx_previewimage_browsercontainer">&nbsp;</td>       
                        </tr>
					</table>
				</fieldset>
				<fieldset id="video_options">
					<legend><?php echo JText::_('video options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="video_autoplay" /></td>
										<td><label for="video_autoplay"><?php echo JText::_('autoplay');?></label></td>
									</tr>
								</table>
							</td>

							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="video_controls" /></td>
										<td><label for="video_controls"><?php echo JText::_('controls');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="video_loop" /></td>
										<td><label for="video_loop"><?php echo JText::_('loop');?></label></td>
									</tr>
								</table>
							</td>

							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="video_preload" /></td>
										<td><label for="video_preload"><?php echo JText::_('preload');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</fieldset> 
				
				<fieldset id="audio_options">
					<legend><?php echo JText::_('audio options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="audio_autoplay" /></td>
										<td><label for="audio_autoplay"><?php echo JText::_('autoplay');?></label></td>
									</tr>
								</table>
							</td>

							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="audio_controls" /></td>
										<td><label for="audio_controls"><?php echo JText::_('controls');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="audio_preload" /></td>
										<td><label for="audio_preload"><?php echo JText::_('preload');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</fieldset> 
			</div>
            <div id="popup_panel" class="panel">
				<fieldset>
					<legend><input type="checkbox" id="popup_check" class="checkbox" /><label for="popup_check" class="hastip" title="<?php echo JText::_('POPUP ENABLE DESC');?>"><?php echo JText::_('ENABLE');?></label></legend>
					<table border="0" cellpadding="4" cellspacing="0" width="100%">
							<tr>
                            	<td td colspan="2"><?php echo JText::_('POPUP REQUIRE');?> <?php echo $popup_version;?></td>
                            </tr>
                            <tr>
								<td><label for="popup_title" class="hastip" title="<?php echo JText::_('POPUP TITLE DESC');?>"><?php echo JText::_('POPUP TITLE');?></label></td>
								<td><input id="popup_title" type="text" value="" /></td>
							</tr>
                            <tr>
								<td><label for="popup_link_title" class="hastip" title="<?php echo JText::_('POPUP LINK TITLE DESC');?>"><?php echo JText::_('POPUP LINK TITLE');?></label></td>
								<td><input id="popup_link_title" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="popup_group" class="hastip" title="<?php echo JText::_('POPUP GROUP DESC');?>"><?php echo JText::_('POPUP GROUP');?></label></td>
								<td><input id="popup_group" type="text" value="" /></td>
							</tr>
					</table>
				</fieldset>
            </div>
		</div>
        <?php $manager->loadBrowser();?>
		<div class="mceActionPanel">
			<div style="float: right">
				<input type="button" class="button" id="refresh" value="<?php echo JText::_('refresh');?>" />
				<input type="button" class="button" id="insert" value="<?php echo JText::_('insert');?>" onClick="MediaManagerDialog.insert();" />
				<input type="button" class="button" id="cancel" value="<?php echo JText::_('cancel');?>" onClick="tinyMCEPopup.close();" />
			</div>
		</div>
	</form>
</body>
</html>
