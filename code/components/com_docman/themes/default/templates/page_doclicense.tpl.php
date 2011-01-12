<?php
/**
 * @version		$Id: page_doclicense.tpl.php 1363 2010-05-04 12:09:47Z mathias $
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
*	$this->html->doclicense (string)(hardcoded, can change in future versions)
*   $this->html->license    (string)(the actual license text)
*/
?>

<?php echo $this->plugin('stylesheet', $this->theme->path."css/theme.css") ?>
<div id="dm_license">
<h1 class="componentheading"><?php echo _DML_TPL_LICENSE_DOC;?></h1>

<div class="dm_license_body">
	<?php echo $this->license; ?>
</div>

<div class="dm_license_form <?php echo @$this->theme->conf->style ? 'dm_dark' : 'dm_light'; ?>">
<?php echo $this->html->doclicense ?>
</div>
</div>


