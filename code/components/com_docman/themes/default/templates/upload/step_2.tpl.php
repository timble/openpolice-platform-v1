<?php
/**
 * @version		$Id: step_2.tpl.php 953 2009-10-14 20:38:38Z mathias $
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
*	$this->step (number)  : holds the current step
*
* Preformatted variables :
*	$this->html->docupload (string)(hardcoded, can change in future versions)
*
*/
?>
<p><?php echo _DML_TPL_UPLOAD_STEP." ".$this->step." "._DML_TPL_UPLOAD_OF." 3" ;?></p>

<p>
<?php
switch($this->method) :
	case 'http' 	: 	echo _DML_TPL_UPLOAD; break;
	case 'transfer' : 	echo _DML_TPL_TRANSFER; break;
	case 'link'     :	echo _DML_TPL_LINK; break;
	default : break;
endswitch;
?>
</p>

<?php echo $this->html->docupload ?>

