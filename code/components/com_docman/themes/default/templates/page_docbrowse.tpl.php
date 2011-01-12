<?php
/**
 * @version		$Id: page_docbrowse.tpl.php 980 2009-11-26 19:46:13Z mathias $
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
*	$this->html->menu     (string)(fetched from : general/menu.tpl.php)
	$this->html->category (string)(fetched from : categories/category.tpl.php)
*	$this->html->cat_list (string)(fetched from : categories/list.tpl.php)
*	$this->html->doc_list (string)(fetched from : documents/list.tpl.php)
*	$this->html->pagenav  (string)(fetched from : general/pagenav.tpl.php)
*	$this->html->pagetitle(string)(fetched from : general/pagetitle.tpl.php)
*/
?>

<?php $this->splugin('pagetitle', _DML_TPL_TITLE_BROWSE.$this->html->pagetitle ) ?>

<?php echo $this->plugin('stylesheet', $this->theme->path . "css/theme.css") ?>

<?php echo $this->plugin('javascript', $this->theme->path . "js/theme.js") ?>

<?php echo $this->html->menu; ?>

<?php echo $this->html->category; ?>

<?php echo $this->html->cat_list; ?>

<?php echo $this->html->doc_list; ?>

<?php echo $this->html->pagenav; ?>