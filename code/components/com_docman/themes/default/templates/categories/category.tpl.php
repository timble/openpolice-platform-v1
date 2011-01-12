<?php
/**
 * @version		$Id: category.tpl.php 1010 2009-12-04 17:07:02Z tom $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */

/*
* Display category details (required)
*
* General variables  :
*	$this->theme->path (string) : template path
* 	$this->theme->name (string) : template name
* 	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Template variables :
*	$this->data		(object) : holds the category data
*  $this->links 	(object) : holds the category operations
*  $this->paths 	(object) : holds the category paths
*/
?>

<?php $path = $this->data->image ? $this->paths->thumb : $this->paths->icon; ?>

<div class="dm_cat">
<?php
	if($this->theme->conf->cat_image) :
        ?><img class="dm_thumb-<?php echo $this->data->image_position;?>" src="<?php echo $path; ?>" alt="" /><?php
    endif;
       
	if($this->data->title != '') :
        ?><h1 class="dm_title"><?php echo $this->data->title;?></h1><?php
    endif;

	if($this->data->description != '') :
		?><div class="dm_description"><?php echo $this->data->description;?></div><?php
	endif;
?>
<div class="clr"></div>
</div>
