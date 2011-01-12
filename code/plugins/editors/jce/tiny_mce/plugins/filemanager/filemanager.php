<?php
/**
* @package JCE File Manager
* @copyright Copyright (C) 2005 - 2010 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see licence.txt
* JCE File Manager is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

$version = "1.5.4.1";

require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'editor.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'plugin.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'utils.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'manager.php' );

require_once( dirname( __FILE__ ) .DS. 'classes' .DS. 'filemanager.php' );

$manager =& FileManager::getInstance();

$manager->setXHR( array( &$manager, 'getProperties' ) );

$manager->script( array( 'sortables' ) );
$manager->script( array( 'filemanager' ), 'plugins' );
$manager->css( array( 'filemanager' ), 'plugins' );
// Load extensions if any
$manager->loadExtensions();
// Process requests
$manager->processXHR();

$manager->_debug = false;
$session = &JFactory::getSession();
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
		FileManagerDialog.settings=<?php echo $manager->getSettings();?>
	</script>
    <?php echo $manager->printHead();?>
</head>
<body lang="<?php echo $manager->getLanguage(); ?>" style="display: none;">
    <div class="panel_wrapper">
            <fieldset>
                <legend><?php echo JText::_('Link');?></legend>
                <table class="properties" border="0">
                    <tr>
                        <td class="column1"><label for="href" class="hastip" title="<?php echo JText::_('URL DESC');?>"><?php echo JText::_('URL');?></label></td>
                        <td colspan="3"><input type="text" id="href" value="" class="required" /></td>
                    </tr>
                    <tr>
                        <td><label for="targetlist" class="hastip" title="<?php echo JText::_('TARGET DESC');?>"><?php echo JText::_('TARGET');?></label></td>
                        <td colspan="3"><select id="targetlist" name="targetlist">
                        <option value=""><?php echo JText::_('NOT SET');?></option>
                        <option value="_self"><?php echo JText::_('TARGET SELF');?></option>
                        <option value="_blank"><?php echo JText::_('TARGET BLANK');?></option>
                        <option value="_parent"><?php echo JText::_('TARGET PARENT');?></option>
                        <option value="_top"><?php echo JText::_('TARGET TOP');?></option>								
                        </select>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend><?php echo JText::_('OPTIONS');?></legend>
                <div id="options-enabled">
                    <table class="properties" border="0">
                        <tr>
                            <td><label for="text" class="hastip" title="<?php echo JText::_('TEXT DESC');?>"><?php echo JText::_('TEXT');?></label></td>
                            <td colspan="3"><input id="text" type="text" value="" class="required" /></td>
                        </tr>
						<tr>
                            <td><label for="title" class="hastip" title="<?php echo JText::_('TITLE DESC');?>"><?php echo JText::_('TITLE');?></label></td>
                            <td colspan="3"><input id="title" type="text" value="" /></td>
                        </tr>
                        <tr>
                            <td><label class="hastip" title="<?php echo JText::_('LAYOUT DESC');?>"><?php echo JText::_('LAYOUT');?></label></td>
                            <td colspan="3"><ul id="sortGroup"></ul></td>
                        </tr>
                        <tr>
                            <td><label for="date-class" class="hastip" title="<?php echo JText::_('DATE CLASS DESC');?>"><?php echo JText::_('DATE CLASS');?></label></td>
                            <td>
                            <select id="date-class" class="mceEditableSelect">
                            	<option value=""><?php echo JText::_('NOT SET');?></option>
                            </select>
                            </td>
                            <td><label for="size-class" class="hastip" title="<?php echo JText::_('SIZE CLASS DESC');?>"><?php echo JText::_('SIZE CLASS');?></label></td>
                            <td>
                            <select id="size-class" class="mceEditableSelect">
                            	<option value=""><?php echo JText::_('NOT SET');?></option>
                            </select>
                            </td>
                        </tr>
                    </table>
            	</div>
                <div id="options-disabled"><?php echo JText::_('OPTIONS DISABLED');?></div>
            </fieldset>
    </div>
	<?php $manager->loadBrowser();?>
	<div class="mceActionPanel">
		<div style="float: right">
    		<input type="button" class="button "id="refresh" value="<?php echo JText::_('Refresh');?>" />
			<input type="button" id="insert" value="<?php echo JText::_('Insert');?>" onClick="FileManagerDialog.insert();" />
			<input type="button" id="cancel" value="<?php echo JText::_('Cancel');?>" onClick="tinyMCEPopup.close();" />
		</div>
	</div>
</body> 
</html> 
