<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="page-header">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>
<?php if ( $this->image || $this->category->description ) : ?>
<div class="desc">
	<?php if ( isset($this->image) ) : echo $this->image; endif; ?>
	<?php echo $this->category->description; ?>
</div>
<?php endif; ?>
<?php echo $this->loadTemplate('items'); ?>