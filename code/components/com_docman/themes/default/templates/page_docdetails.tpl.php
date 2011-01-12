<?php
/**
 * @version		$Id: page_docdetails.tpl.php 980 2009-11-26 19:46:13Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/* Display the document details page(required)
*
* This template is called when u user preform a details operation on a document.
*
* General variables  :
*	$this->theme->path (string) : template path
*	$this->theme->name (string) : template name
*	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Preformatted html variables :
*	$this->html->docdetails (string)(fetched from : documents/document.tpl.php)
*/

?>

<?php echo $this->plugin('javascript', $this->theme->path . "js/theme.js") ?>
<?php echo $this->plugin('stylesheet', $this->theme->path . "css/theme.css") ?>

<?php echo $this->html->docdetails ?>