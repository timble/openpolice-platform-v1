<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
	
<?php $i = $this->pagination->limitstart; $leading = $this->params->def('num_leading_articles', 1); ?>

<?php if($this->pagination->limitstart == '0') : ?>
	<?php for ($y = 0; $y < $leading && $i < $this->total; $y++, $i++) : ?>
	<?php $this->item =& $this->getItem($i, $this->params); ?>
	<div class="article separator leading clearfix<?php echo $this->item->state == 0 ? ' system-unpublished' : ''; ?>">
		<?php echo $this->loadTemplate('item'); ?>
	</div>
	<?php endfor; ?>
<?php endif; ?>

<?php 
	$introcount = $this->params->def('num_intro_articles', 4);
	if($this->pagination->limitstart != '0') { $introcount = $introcount + $leading; }
?>

<?php if($this->params->def('num_intro_articles', 4)) : ?>
	<?php for ($y = 0; $y < $introcount && $i < $this->total; $i++, $y++) : ?>
		<?php $this->item =& $this->getItem($i, $this->params); ?>
		<div class="article separator clearfix<?php echo $this->item->state == 0 ? ' system-unpublished' : ''; ?>">
			<?php echo $this->loadTemplate('item'); ?>
		</div>
	<?php endfor; ?>
	

	<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
	<div id="pagination-wrap">
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<?php echo $this->pagination->getPagesLinks(); ?>
		<?php endif; ?>
	</div>		
	<?php endif; ?>
<?php endif; ?>