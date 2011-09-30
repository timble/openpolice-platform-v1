<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php $cparams = JComponentHelper::getParams ('com_media'); ?>

<div class="page-header">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>
<?php if (($this->params->def('show_description', 1) || $this->params->def('show_description_image', 1)) && ($this->category->image || $this->category->description)) : ?>
<div class="article clearfix">
	<?php if ($this->category->image) : ?>
	<img src="<?php echo $this->baseurl . '/' . $cparams->get('image_path').'/'.$this->category->image; ?>" align="right" />
	<?php endif; ?>
	<?php if ($this->params->get('show_description') && $this->category->description) :
	echo $this->category->description;
	endif; ?>
</div>
<?php endif; ?>
<?php $this->items =& $this->getItems();
echo $this->loadTemplate('items'); ?>

<?php if ($this->access->canEdit || $this->access->canEditOwn) : ?>
<?php echo JHTML::_('icon.create', $this->category, $this->params, $this->access); ?>
<?php endif; ?>