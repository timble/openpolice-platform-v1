<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="page-header">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>

<?php if ($this->params->get('image') != '-1' || ($this->params->get('show_comp_description', 1) && $this->params->get('comp_description'))) : ?>
<div class="article separator group">
	<?php echo $this->image; ?>
	<?php if($this->params->get('show_comp_description', 1)) : ?>
	<?php echo $this->params->get('comp_description');?>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php foreach ( $this->categories as $category ) : ?>
	<div class="article separator">
		<h2><a href="<?php echo $category->link; ?>"><?php echo $this->escape($category->title);?></a></h2>
		<?php echo $category->description; ?>
		
		<p class="readon">
			<a href="<?php echo $category->link ?>"><?php echo JText::_('READMORE'); ?>  &rarr;</a>
		</p>
	</div>
<?php endforeach; ?>