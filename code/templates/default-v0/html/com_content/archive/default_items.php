<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php foreach ($this->items as $item) : ?>
<div class="article separator clearfix">
	<div class="page-header">
		<h1><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug)); ?>"><?php echo $this->escape($item->title); ?></a></h1>
		
		<?php if ($this->params->get('show_create_date')) : ?>
		<p class="article-info">
			<span>
				<strong><?php echo JHTML::_('date', $item->publish_up, JText::_('%a %d/%m/%Y - %H:%M')); ?></strong>
			</span>
			<?php if(intval($item->modified) != 0 && $this->params->get('show_modify_date')) : ?>
				<span>
					<em><?php echo JText::_('Update'); ?>: <?php echo JHTML::_('date', $item->modified, JText::_('%d/%m/%Y - %H:%M')); ?></em>
				</span>
			<?php endif; ?>
		</p>
	</div>
	<?php endif; ?>
	<p>
		<?php echo substr(strip_tags($item->introtext), 0, 255);  ?>...
	</p>
	<p class="readon">
		<a class="btn" href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug)); ?>"><?php echo JText::_('READMORE'); ?>  &rarr;</a>
	</p>
</div>
<?php endforeach; ?>

<div id="pagination-wrap">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>