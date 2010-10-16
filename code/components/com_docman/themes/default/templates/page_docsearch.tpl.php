<?php
/**
 * @version		$Id: page_docsearch.tpl.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the
 				original copyright holder. This file is not licensed under the GPL.
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/* Display the documents overview (required)
*
* This template is called when u user preform browse the docman
*
* General variables  :
*	$this->theme->path (string) : template path
* 	$this->theme->name (string) : template name
* 	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Preformatted html variables :
*	$this->html->menu     	(string)(fetched from : general/menu.tpl.php)
*	$this->html->searchform	(string)(hardcoded)
*
* Template variables :
*	$this->items (array)  : holds an array of dcoument items
*/

$mainframe = JFactory::getApplication();
$mainframe->appendPathway(_DML_TPL_TITLE_SEARCH);
?>

<?php $this->splugin('pagetitle', _DML_TPL_TITLE_SEARCH ) ?>

<?php echo $this->plugin('stylesheet', $this->theme->path . "css/theme.css") ?>

<?php echo $this->html->menu; ?>

<h2 id="dm_title"><?php echo _DML_TPL_TITLE_SEARCH;?></h2>

<?php echo $this->html->searchform ?>

<?php
// If we have no items to show
if (count($this->items) == 0 && JRequest::getCmd('task') == 'search_result') :
    $app = & JFactory::getApplication();
    $app->enqueueMessage(_DML_TPL_NO_ITEMS_FOUND);
    return;
endif;

?>

<dl id="dm_docs">
<?php
/*
     * Include the list_item template and pass the item to it
    */
$category = '';
foreach($this->items as $item) :
    if ($category != $item->data->category) :
        $category = $item->data->category ;
        ?><dt class="dm_cat"><?php echo _DML_CAT .': '. $item->data->category ?></dt><?php
    endif;
    $this->doc = &$item; //add item to template variables
    include $this->loadTemplate('documents'.DS.'list_item.tpl.php');
endforeach;

?>
</dl>
