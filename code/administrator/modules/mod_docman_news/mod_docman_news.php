<?php
/**
 * @version		$Id: mod_docman_news.php 954 2009-10-17 16:25:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

define('_DM_DEFAULT_FEED_URL', 'http://feeds.joomlatools.eu/docman');

global $_DOCMAN;
$_DOCMAN->setType(_DM_TYPE_MODULE);
$_DOCMAN->loadLanguage('modules');
require_once($_DOCMAN->getPath('classes', 'utils'));

$mainframe     = JFactory::getApplication();
$imgpath        = JURI::root(true).DS.'administrator'.DS.'templates'.DS.$mainframe->getTemplate().DS.'images'.DS;
$limit          = $params->get('limit', 5 );
$desc_truncate  = $params->get('desc_truncate', 200 );

// check if cache directory is writeable
$cacheDir = JPATH_BASE.DS.'cache'.DS;
if ( !is_writable( $cacheDir ) ) {
 	echo JText::_( 'Cache Directory Unwritable' );
   	return;
}

$options = array();
$options['rssUrl']      = $params->get('feed_url', _DM_DEFAULT_FEED_URL);
$options['cache_time']  = $params->get('cachetime', 86400);

$rss =& JFactory::getXMLparser('RSS', $options);
if ( $rss== false ) {
 	echo JText::_('Error: Feed not retrieved');
   	echo '<br />';
   	echo JText::_('This happens when no connection can be made to the server. Try updating to the latest DOCman version. Alternatively, you can disable this module in the module manager.');
   	return;
}
?>

<table class="adminlist cpanelmodule">
<tbody>
  	<tr><th>
  		<a href="<?php echo $rss->get_link() ?>" target="_blank"><?php echo $rss->get_title()?></a>&nbsp;&nbsp;&nbsp;&nbsp;
   	    <a href="<?php echo $options['rssUrl']?>" target="_blank"><img src="<?php echo JURI::root(0)?>/images/M_images/livemarks.png" /><?php echo JText::_('Subscribe to feed')?></a>
   	</th></tr><?php
   	$cntItems = $rss->get_item_quantity();
   	if( !$cntItems ) {?>
     	<tr><th><?php echo _DML_MOD_NEWS_NO_ITEMS?></th></tr><?php
   	}else{
      	$cntItems = ($cntItems > $limit) ? $limit : $cntItems;
       	for( $j = 0; $j < $cntItems; $j++ ){
         	$item = & $rss->get_item($j);?>
           	<tr><td>
             	<a href="<?php echo $item->get_link()?>" target="_blank"><?php echo $item->get_title()?></a><?php
              	if( $description = DOCMAN_Utils::snippet($item->get_description(), $desc_truncate) ) {?>
                 	<br /><?php echo $description?><?php
               	}?>
          	</td></tr><?php
      	}
   	}?>
 </tbody>
</table>