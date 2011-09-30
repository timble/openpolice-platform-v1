<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php $cparams = JComponentHelper::getParams ('com_media'); ?>

<div class="page-header">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>
<?php if (($this->params->def('show_description', 1) || $this->params->def('show_description_image', 1)) && ($this->section->image || $this->section->description)) : ?>
<div class="article separator clearfix">
	<?php if ($this->params->get('show_description_image') && $this->section->image) : ?>
	<img src="<?php echo $this->baseurl . '/' . $cparams->get('image_path').'/'.$this->section->image; ?>" align="right" />
	<?php endif; ?>

	<?php if ($this->params->get('show_description') && $this->section->description) :
		echo $this->section->description;
	endif; ?>
</div>
<?php endif; ?>

<?php if ($this->params->def('show_categories', 1) && count($this->categories)) : ?>
<?php foreach ($this->categories as $category) : ?>
	<div class="article separator group">
		<?php if (!$this->params->get('show_empty_categories') && !$category->numitems) :
			continue;
		endif; ?>
		
		<?php if ($this->params->get('show_description_image') && $this->section->image) : ?>
		<img src="<?php echo $this->baseurl . '/' . $cparams->get('image_path').'/'.$this->section->image; ?>" align="right" />
		<?php endif; ?>
		
		<h2>
			<a href="<?php echo $category->link; ?>"><?php echo $category->title; ?></a>
		</h2>

		<?php if ($this->params->def('show_category_description', 1) && $category->description) : ?>
		<p class="cat-desc"><?php echo $category->description; ?></p>
		<?php endif; ?>
		
		<p class="readon">
			<a href="<?php echo $category->link; ?>"><?php echo JText::_('READMORE'); ?> &rarr;</a>
		</p>
	</div>
<?php endforeach; ?>
<?php endif;