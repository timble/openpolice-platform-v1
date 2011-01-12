<?php
/**
 * @version		$Id: list.tpl.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the
 				original copyright holder. This file is not licensed under the GPL.
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/*
* Display the category list (required)
*
* General variables  :
*	$this->theme->path (string) : template path
* 	$this->theme->name (string) : template name
* 	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Template variables :
*	$this->items (array)  : holds an array of dcoument items
*/
?>

<?php if (count($this->items)) { ?>
    <div id="dm_cats">
    <h2 class="dm_title"><?php echo _DML_TPL_CATS;?></h2>
    <div>
    <?php
     	/*
         * Include the list_item template and pass the item to it
        */

    	foreach($this->items as $item) :
    		if($this->theme->conf->cat_empty || $item->data->files != 0) :
    			include $this->loadTemplate('categories'.DS.'list_item.tpl.php');
    		endif;
    	endforeach;
    ?>
    </div>
    </div>
<?php } ?>