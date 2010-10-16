<?php
/**
 * @version		$Id: page_msgbox.tpl.php 980 2009-11-26 19:46:13Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/*
* Display a msgbox  (required)
*
* This template is called when the component is down (configuration setting
* 'section is down') or when the users hasn't the necessary access permissions.
*
* General variables  :
*	$this->theme->path (string) : template path
*	$this->theme->name (string) : template name
*	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Template Variables :
*	$this->msg (string) : the msg to be displayed
*/
?>

<?php echo $this->plugin('stylesheet', $this->theme->path . "/css/theme.css") ?>

<div id="dm_msgbox">
  	<p><?php echo $this->msg ?></p>
</div>