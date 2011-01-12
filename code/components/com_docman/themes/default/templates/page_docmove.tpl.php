<?php
/**
 * @version		$Id: page_docmove.tpl.php 1363 2010-05-04 12:09:47Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the
 				original copyright holder. This file is not licensed under the GPL.
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');


/*
* Display the move document form (required)
*
* This template is called when u user preform a move operation on a document.
*
* General variables  :
*	$this->theme->path (string) : template path
*	$this->theme->name (string) : template name
*	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Preformatted variables :
*	$this->html->docmove (string)(hardcoded, can change in future versions)
*/
?>

<?php $this->splugin('pagetitle', _DML_TPL_TITLE_MOVE ) ?>

<?php echo $this->plugin('stylesheet', $this->theme->path."css/theme.css") ?>

<?php echo $this->html->menu; ?>

<h2 id="dm_title"><?php echo _DML_TPL_TITLE_MOVE;?></h2>

<?php echo $this->html->docmove ?>

<div class="dm_taskbar <?php echo @$this->theme->conf->style ? 'dm_dark' : 'dm_light'; ?>">
<ul>
    <li><a href="javascript: history.go(-1);"><?php echo _DML_TPL_BACK ?></a></li>
</ul>
<div class="clr"></div>
</div>

