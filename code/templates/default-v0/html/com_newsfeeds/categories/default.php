<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="page-header">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>
<?php if ($this->params->get('image') != '-1' || ($this->params->get('show_comp_description') && $this->params->get('comp_description'))) : ?>
<div class="article separator group">
	<?php echo $this->image; ?>
	<?php if($this->params->get('show_comp_description', 1)) : ?>
	<p><?php echo $this->escape($this->params->get('comp_description'));?></p>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php foreach ( $this->categories as $category ) : ?>
<div class="article separator">
	<h2><a href="<?php echo $category->link ?>"><?php echo $this->escape($category->title);?></a></h2>
	<?php if ( $this->params->get( 'show_cat_description' ) && $category->description ) : ?>
		<?php echo $category->description; ?>
	<?php endif; ?>
	
	<p class="readon">
		<a href="<?php echo $category->link ?>"><?php echo JText::_('READMORE'); ?>  &rarr;</a>
	</p>
</div>
<?php endforeach; ?>