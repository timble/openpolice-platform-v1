<?php
/**
 * @version		$Id: list_order.tpl.php 1363 2010-05-04 12:09:47Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the
 				original copyright holder. This file is not licensed under the GPL.
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');


/*
* Display the documents list ordering (called by document/list.tpl.php)
*
* General variables  :
*	$this->theme->path (string) : template path
* 	$this->theme->name (string) : template name
* 	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Template variables :
*	$this->order->links     (array)  : holds an array of order by task links
*  $this->order->orderby   (string) : current orderby setting
*  $this->order->direction (string) : current order direction
*/
?>
<div class="dm_orderby <?php echo @$this->theme->conf->style ? 'dm_dark' : 'dm_light'; ?>"> <?php echo _DML_TPL_ORDER_BY ?> :
<?php
	if($this->order->orderby != 'name') :
		?><a href="<?php echo $this->order->links['name'] ?>"><?php echo _DML_TPL_ORDER_NAME ?></a> | <?php
	else :
 		?><strong><?php echo _DML_TPL_ORDER_NAME ?> </strong> | <?php
 	endif;

	if($this->order->orderby != 'date') :
 		?><a href="<?php echo $this->order->links['date'] ?>"><?php echo _DML_TPL_ORDER_DATE ?></a> | <?php
 	else :
 		?><strong><?php echo _DML_TPL_ORDER_DATE ?> </strong> | <?php
 	endif;

 	if($this->order->orderby != 'hits') :
 		?><a href="<?php echo $this->order->links['hits'] ?>"><?php echo _DML_TPL_ORDER_HITS ?></a> <?php
 	else :
 		?><strong><?php echo _DML_TPL_ORDER_HITS ?> </strong> | <?php
 	endif;

	if ($this->order->direction == 'ASC') :
		?><a href="<?php echo $this->order->links['dir'] ?>">[ <?php echo _DML_TPL_ORDER_DESCENT ?> ]</a><?php
   	else :
       	 ?><a href="<?php echo $this->order->links['dir'] ?>">[ <?php echo _DML_TPL_ORDER_ASCENT ?> ]</a><?php
    endif;
?>
</div>