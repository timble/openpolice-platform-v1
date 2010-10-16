<?php
/**
 * @version		$Id: tasks.tpl.php 979 2009-11-26 18:08:33Z tom $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/*
* Display the document tasks (called by document/list_item.tpl.php and documents/document.tpl.php)
*
* General variables  :
*	$this->theme->path (string) : template path
* 	$this->theme->name (string) : template name
* 	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Template variables :
*	$this-	>doc->buttons (array) : holds the tasks a user can preform on a
*document
*/

foreach($this->doc->buttons as $button) {

	if($button->params->get('popup', false))
	{
		JHTML::_('behavior.modal');
		$popup = 'class="modal" rel="{handler: \'iframe\', size: {x: 800, y: 500}}"';
	} else {
		$popup = '';
	}
	
	$attr = '';
    if($class = $button->params->get('class', '')) {
    	$attr = 'class="' . $class . '"';
    }
	?><li <?php echo $attr?>>
        <a href="<?php echo $button->link?>" <?php echo $popup?>>
            <?php echo $button->text ?>
        </a>
    </li><?php
}