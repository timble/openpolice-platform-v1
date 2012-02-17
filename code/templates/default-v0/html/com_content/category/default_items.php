<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<table cellspacing="0" cellpadding="0" width="100%">
	<tbody>
	<?php foreach ($this->items as $item) : ?>
	<tr class="zebra<?php echo ($item->odd + 1); ?>">
		<td>
			<a href="<?php echo $item->link; ?>">
				<?php echo $this->escape($item->title); ?>
			</a>
			<?php echo JHTML::_('icon.edit', $item, $this->params, $this->access); ?>
		</td>
		<?php if ($this->params->get('show_date')) : ?>
		<td nowrap="true">
			<?php echo JHTML::_('date', $item->publish_up, JText::_('%a %d/%m/%Y - %H:%M')); ?>
		</td>
		<?php endif; ?>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php if ($this->params->get('show_pagination')) : ?>
<div id="pagination-wrap">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
<?php endif; ?>
