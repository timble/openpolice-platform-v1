<?php
/**
 * @version		$Id: list_item.tpl.php 1384 2010-06-18 09:49:14Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the
 				original copyright holder. This file is not licensed under the GPL.
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');


/*
* Display a documents list item (called by document/list.tpl.php)
*
* This template is called when u user preform browse the docman
*
* General variables  :
*	$this->theme->path (string) : template path
* 	$this->theme->name (string) : template name
* 	$this->theme->conf (object) : template configuartion parameters
*	$this->theme->icon (string) : template icon path
*   $this->theme->png  (boolean): browser png transparency support


* Template variables :
*   $this->doc->data  (object) : holds the document data
*   $this->doc->links (object) : holds the document operations
*   $this->doc->paths (object) : holds the document paths
*/
global $_DMUSER;

// Check if item_title_link is set in themeConfig.php, new since 1.5.1
$item_title_link = isset($this->theme->conf->item_title_link) ? $this->theme->conf->item_title_link : '1'; ?>

<?php $path = $this->doc->data->dmthumbnail ? $this->doc->paths->thumb : $this->doc->paths->icon; ?>

<div class="dm_row <?php echo @$this->theme->conf->style ? 'dm_dark' : 'dm_light'; ?>">
	<h3 class="dm_title">
	<?php // output category icon/thumb
	if($this->theme->conf->doc_image) : ?>
		<img src="<?php echo $path;?>" alt="<?php echo htmlspecialchars($this->doc->data->dmname); ?>" />
	<?php endif; ?>

	<?php
	// output title
	switch($item_title_link) :
	 	case 0 :  //no link
			echo $this->doc->data->dmname;
		break;

		case 1 :  // link to download, if download is allowed
			if($_DMUSER->canDownload($this->doc->data->id)) {
	            ?><a href="<?php echo $this->doc->data->downloadlink?>" title="<?php echo htmlspecialchars($this->doc->data->dmname)?>">
					<?php echo htmlspecialchars($this->doc->data->dmname) ?>
				</a><?php
       		} else {
            	echo htmlspecialchars($this->doc->data->dmname);
        	}
		break;

	 	case 2  :  // link to details
			?><a href="<?php echo $this->doc->data->permalink;?>" title="<?php echo $this->doc->data->dmname; ?>">
				<?php echo $this->doc->data->dmname; ?>
			</a><?php
	 	break;
	endswitch;
	?>

	<div class="clr"></div>
	</h3>
<div class="dm_details <?php echo @$this->theme->conf->style ? 'dm_dark' : 'dm_light'; ?>">
<?php if($this->doc->data->new && $this->theme->conf->item_new || $this->doc->data->hot && $this->theme->conf->item_hot) : ?>
<div>
	<strong>
	<?php echo $this->doc->data->new && $this->theme->conf->item_new ? _DML_NEW : ''; ?>
	<?php echo $this->doc->data->new && $this->theme->conf->item_new && $this->doc->data->hot && $this->theme->conf->item_hot ? '&amp;' : ''; ?>
	<?php echo $this->doc->data->hot && $this->theme->conf->item_hot ? _DML_HOT : ''; ?>
	</strong>
</div>
<?php endif; ?>


<?php if($this->theme->conf->item_date || $this->theme->conf->item_date_modified || $this->theme->conf->item_filesize || $this->theme->conf->item_downloads) : ?>
	<table cellspacing="0">
		<?php // output document date added
		if ( $this->theme->conf->item_date ) : ?>
		<tr>
		    <td><strong><?php echo _DML_TPL_DATEADDED;?>:</strong></td>
		    <td><?php $this->plugin('dateformat', $this->doc->data->dmdate_published, _DML_TPL_DATEFORMAT_SHORT); ?></td>

		</tr>
		<?php endif; ?>

		<?php // output document date modified
		if ( $this->theme->conf->item_date_modified ) : ?>
		    <tr>
		 		<td><strong><?php echo _DML_DATE_MODIFIED ?>:</strong></td>
		 		<td><?php  $this->plugin('dateformat', $this->doc->data->dmlastupdateon , _DML_TPL_DATEFORMAT_SHORT); ?></td>
		 	</tr>
		<?php endif; ?>

		<?php // output file size
		if($this->theme->conf->item_filesize) : ?>
		<tr>
			<td><strong><?php echo _DML_TPL_FSIZE;?>:</strong></td>
			<td><?php if ($this->doc->data->filesize == 'Link') { echo _DML_UNKNOWN; } else { echo $this->doc->data->filesize; } ?></td>
		</tr>
		<?php endif; ?>

		<?php // output document counter
		if ( $this->theme->conf->item_downloads  ) : ?>
		<tr>
			<td><strong><?php echo _DML_TPL_DOWNLOADS;?>:</strong></td>
		    <td><?php echo $this->doc->data->dmcounter;?></td>
		</tr>
		<?php endif; ?>
	</table>
<?php endif?>

</div>
<?php

//output document description
if ( $this->theme->conf->item_description AND $this->doc->data->dmdescription ) :
	?>
	<div class="dm_description">
		<?php echo $this->doc->data->dmdescription;?>
	</div>
	<?php
endif;

//output document url
if ( $this->theme->conf->item_homepage && $this->doc->data->dmurl != '') :
	?>
 	<div class="dm_homepage">
		<?php echo _DML_TPL_HOMEPAGE;?>: <a href="<?php echo $this->doc->data->dmurl;?>"><?php echo $this->doc->data->dmurl;?></a>
	</div>
	<?php
endif;

?>
<div class="clr"></div>
<?php
if(!$this->doc->data->approved) {
	?><div class="dm_unapproved"><?php echo _DML_NOAPPROVED_DOWNLOAD; ?></div><?php
} elseif(!$this->doc->data->published) {
	?><div class="dm_unpublished"><?php echo _DML_NOPUBLISHED_DOWNLOAD; ?></div><?php
} elseif($this->doc->data->checked_out) {
    ?><div class="dm_checked_out"><?php echo _DML_NOTDOWN; ?></div><?php
}?>

<div class="dm_taskbar <?php echo @$this->theme->conf->style ? 'dm_dark' : 'dm_light'; ?>">
    <ul>
    <?php include $this->loadTemplate('documents'.DS.'tasks.tpl.php');  ?>
    </ul>
    <div class="clr"></div>
</div>

</div>