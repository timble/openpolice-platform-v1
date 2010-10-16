<?php
/**
 * @version		$Id: pagenav.tpl.php 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');


/*
* Display the pagenav (required)
*
* General variables  :
*	$this->theme->path (string) : template path
* 	$this->theme->name (string) : template name
* 	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Template variables :
*	$this->pagenav (object) : the pagenav object
*	$this->link    (nuber)  : the full page link
*
*/
?>

<div id="dm_nav">
<?php echo $this->pagenav->writePagesLinks( $this->link );?>
	<div>
	<?php echo $this->pagenav->writePagesCounter();?>
	</div>
</div>

