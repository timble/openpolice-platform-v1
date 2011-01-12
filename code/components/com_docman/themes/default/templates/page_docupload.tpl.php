<?php
/**
 * @version		$Id: page_docupload.tpl.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the
 				original copyright holder. This file is not licensed under the GPL.
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/*
* Display the upload document form (required)
*
* This template is called when u user preform a upload operation on a document.
*
* General variables  :
*	$this->theme->path (string) : template path
*	$this->theme->name (string) : template name
*	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Template variables :
*	$this->step   (number)  : holds the current step
*   $this->update (boolean) : true, if we are updating a document
*   $this->method (string)  : hols the upload method used (http, link or transfer)
*
* Preformatted variables :
*	$this->html->docupload (string)(hardcoded, can change in future versions)
*
*/
?>

<?php $this->splugin('pagetitle', _DML_TPL_TITLE_UPLOAD ) ?>

<?php echo $this->plugin('stylesheet', $this->theme->path."css/theme.css") ?>
<?php echo $this->plugin('overlib'); ?>

<?php echo $this->html->menu; ?>

<?php
if($this->update) :
?><h2 id="dm_title"><?php echo _DML_TPL_TITLE_UPDATE;?></h2><?php
else :
?><h2 id="dm_title"><?php echo _DML_TPL_TITLE_UPLOAD;?></h2><?php
endif;
?>

<?php
switch($this->step) :
	case '1' :  include $this->loadTemplate('upload'.DS.'step_1.tpl.php');  break;
	case '2' :  include $this->loadTemplate('upload'.DS.'step_2.tpl.php');  break;
	case '3' :  include $this->loadTemplate('upload'.DS.'step_3.tpl.php');  break;
endswitch;
?>