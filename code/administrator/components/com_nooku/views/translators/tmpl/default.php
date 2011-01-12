<? /** $Id: default.php 836 2008-11-10 13:41:51Z mathias $ */ ?>
<? defined('_JEXEC') or die; ?>

<? @helper('stylesheet', 'grid.css', Nooku::getURL('css')); ?>

<form action="<?= @route('index.php?option=com_nooku&view=translators')?>" method="post" name="adminForm">
	<table class="adminlist" style="clear: both;">
		<thead>
			<tr>
				<th width="5">
					<?= @text('NUM'); ?>
				</th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count(@$translators); ?>);" />
				</th>
				<th class="title">
					<?= @helper('grid.sort',   'Name', 'name', @$filter['direction'], @$filter['order'] ); ?>
				</th>
				<th width="15%" class="title" >
					<?= @helper('grid.sort',   'Username', 'username', @$filter['direction'], @$filter['order'] ); ?>
				</th>
				<th width="15%" nowrap="nowrap">
					<?= @helper('grid.sort', 'Enabled', 'enabled', @$filter['direction'], @$filter['order']); ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<? $i = 0; $m = 0; ?>
			<? foreach (@$translators as $translator) : ?>
			<tr class="<?= 'row'.$m; ?>">
				<td align="center">
					<?= $i; ?>
				</td>
				<td align="center">
					<?= @helper('grid.id', $i, $translator->user_id); ?>
				</td>
				<td>
					<?= $translator->name; ?>
				</td>
				<td align="center">
					<a  href="<?= @route('index.php?option=com_users&view=user&task=edit&cid='.$translator->user_id); ?>"><?= $translator->username; ?></a>
				</td>
				<td align="center">
					<?= @helper('grid.enable', $translator->enabled, $i ); ?>
				</td>
			</tr>
			<? ++$i; $m = (1 - $m); ?>
			<? endforeach; ?>

			<? if (!count(@$translators)) : ?>
			<tr>
				<td colspan="6" align="center">
					<?= @text('No users found. Only users with Author permissions or higher can be added as translators. Super administrators are translators by default.'); ?>
				</td>
			</tr>
			<? endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">
					<?= @$pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?= @$filter['order']; ?>" />
	<input type="hidden" name="filter_direction" value="<?= @$filter['direction']; ?>" />
</form>