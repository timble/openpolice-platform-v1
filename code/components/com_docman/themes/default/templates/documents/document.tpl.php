<?php
/**
 * @version		$Id: document.tpl.php 1363 2010-05-04 12:09:47Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the
 				original copyright holder. This file is not licensed under the GPL.
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');


/*
* Display document details (required)
*
* General variables  :
*	$this->theme->path (string) : template path
* 	$this->theme->name (string) : template name
* 	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support
*
* Template variables :
*	$this->data		(object) : holds the document data
*   $this->links 	(object) : holds the document operations
*   $this->paths 	(object) : holds the document paths
*/

$mainframe = JFactory::getApplication();
$pathway  = & $mainframe->getPathWay();
$pathway->addItem($this->data->dmname);

$mainframe->setPageTitle( _DML_TPL_TITLE_DETAILS . ' | ' . $this->data->dmname );
?>

<div id="dm_details" class="<?php echo @$this->theme->conf->style ? 'dm_dark' : 'dm_light'; ?>">


<h1 class="dm_title"><?php echo _DML_TPL_DETAILSFOR ?><em>&nbsp;<?php echo htmlspecialchars($this->data->dmname) ?></em></h1>

<?php
if ($this->data->dmthumbnail) :
	?><img src="<?php echo $this->paths->thumb ?>" alt="<?php echo htmlspecialchars($this->data->dmname)?>" /><?php
endif;
?>

<table summary="<?php echo htmlspecialchars($this->data->dmname)?>" cellspacing="0" >

<col id="prop" />
<col id="val" />
<thead>
	<tr>
		<td><?php echo _DML_PROPERTY?></td><td><?php echo _DML_VALUE?></td>
	</tr>
</thead>
<tbody>
<?php
if($this->theme->conf->details_name) :
	?>
	<tr>
 		<td><strong><?php echo _DML_TPL_NAME ?>:</strong></td><td><?php echo htmlspecialchars($this->data->dmname) ?></td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_description) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_DESC ?>:</strong></td><td><?php echo $this->data->dmdescription ?></td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_filename) :
	 ?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_FNAME ?>:</strong></td><td><?php echo htmlspecialchars($this->data->filename) ?></td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_filesize) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_FSIZE ?>:</strong></td>
 		<td><?php if ($this->data->filesize == 'Link') { echo _DML_UNKNOWN; } else { echo $this->data->filesize; } ?></td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_filetype) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_FTYPE ?>:</strong></td><td><?php echo $this->data->filetype ?>&nbsp;(<?php echo _DML_TPL_MIME.":&nbsp;".$this->data->mime ?>)</td>
	</tr>
	<?php
endif;
if($this->theme->conf->details_submitter) :
	?>
	<tr>
 		<td><strong><?php echo _DML_TPL_SUBBY ?>:</strong></td><td><?php echo $this->data->submited_by ?></td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_created) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_SUBDT ?></strong></td>
 		<td>
 			 <?php  $this->plugin('dateformat', $this->data->dmdate_published , _DML_TPL_DATEFORMAT_LONG); ?>
 		</td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_readers) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_OWNER ?>:</strong></td><td><?php echo $this->data->owner ?></td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_maintainers) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_MAINT ?>:</strong></td><td><?php echo $this->data->maintainedby ?></td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_downloads) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_HITS ?>:</strong></td><td><?php echo $this->data->dmcounter."&nbsp;"._DML_TPL_HITS ?></td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_updated) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_LASTUP ?>:</strong></td>
 		<td>
 			<?php  $this->plugin('dateformat', $this->data->dmlastupdateon , _DML_TPL_DATEFORMAT_LONG); ?>
 		</td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_homepage) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_HOME ?>:</strong></td><td><?php echo $this->data->dmurl ?></td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_crc_checksum) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_CRC_CHECKSUM ?>:</strong></td><td><?php echo $this->data->params->get('crc_checksum'); ?></td>
 	</tr>
	<?php
endif;
if($this->theme->conf->details_md5_checksum) :
	?>
 	<tr>
 		<td><strong><?php echo _DML_TPL_MD5_CHECKSUM ?>:</strong></td><td><?php echo $this->data->params->get('md5_checksum'); ?></td>
 	</tr>
	<?php
endif;
?>
</tbody>
</table>
<div class="clr"></div>
</div>

<?php if(JRequest::getString('tmpl') != 'component') :?>
    <div class="dm_taskbar <?php echo @$this->theme->conf->style ? 'dm_dark' : 'dm_light'; ?>">
    <ul>
    <?php
    	unset($this->buttons['details']);
    	$this->doc = &$this;
    	include $this->loadTemplate('documents'.DS.'tasks.tpl.php');
    ?>
    <li><a href="javascript: history.go(-1);"><?php echo _DML_TPL_BACK ?></a></li>
    </ul>
    </div>
<?php endif; ?>

<div class="clr"></div>