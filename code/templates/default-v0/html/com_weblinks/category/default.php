<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="page-header"><h1><?php echo $this->escape($this->params->get('page_title')); ?></h1></div>

<?php if ( $this->category->image || $this->category->description ) : ?>
    <div class="article description group">
	<?php
		if ( isset($this->category->image) ) :  echo $this->category->image; endif;
		echo $this->category->description;
	?>
    </div>
<?php endif; ?>

<?php echo $this->loadTemplate('items'); ?>