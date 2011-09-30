<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php foreach ($this->items as $item) : ?>
<div class="article separator">
	<h2><?php echo $item->title; ?></h2>
	<?php if ( $this->params->get( 'show_link_description' ) ) : ?>
	<p><?php echo nl2br($this->escape($item->description)); ?></p>
	<?php endif; ?>
	
	<p><a href="<?php echo $item->url; ?>"><?php echo $item->url; ?></a></p>
</div>
<?php endforeach; ?>
    
<div id="pagination-wrap">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>