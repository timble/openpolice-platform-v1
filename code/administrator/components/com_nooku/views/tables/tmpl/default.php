<? /** $Id: default.php 745 2008-10-01 02:23:40Z Johan $ */ ?>
<? defined('_JEXEC') or die; ?>

<? @helper('stylesheet', 'grid.css', Nooku::getURL('css')); ?>

<form action="<?= @route()?>" method="post" name="adminForm">
	<table class="adminlist" style="clear: both;">
		<thead>
			<tr>
				<th width="5">
					<?= @text('NUM'); ?>
				</th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count(@$tables); ?>);" />
				</th>
				<th>
					<?= @helper('grid.sort', 'NAME', 'table_name', @$filter['direction'], @$filter['order']); ?>
				</th>
				<th>
					<?= @text('Description'); ?>
				</th>
				<th width="15%" nowrap="nowrap">
					<?= @helper('grid.sort', 'Enabled', 'enabled', @$filter['direction'], @$filter['order']); ?>
				</th>
				
				<? if(JDEBUG): ?>
					<th width="15%" nowrap="nowrap">
						<?= @text('Unique Column'); ?>
					</th>
	                <th width="15%" nowrap="nowrap">
	                	<?= @text('Title Column'); ?>
	                </th>
				<? endif; ?>
			</tr>
		</thead>
		<tbody>
			<? $i = 0; $m = 0; ?>
			<? foreach (@$tables as $table) : ?>
			<tr class="<?= 'row'.$m; ?>">
				<td align="center">
					<?= $i + 1; ?>
				</td>
				<td align="center">
					<?= @helper('grid.id', $i, $table->id); ?>
				</td>
				<td>
					<?= KInflector::humanize($table->table_name); ?>
				</td>
				<td>
					<?= @text($table->comment); ?>
				</td>
				<td align="center">
					<?= @helper('grid.enable', $table->enabled, $i ); ?>
				</td>
				
				<? if(JDEBUG): ?>
					<td align="center">
						<?= $table->unique_column; ?>
					</td>
	                <td align="center">
	                    <?= $table->title_column; ?>
	                </td>
                <? endif; ?>
			</tr>
			<? $i = $i + 1; $m = (1 - $m); ?>
			<? endforeach; ?>

			<? if (!count($this->tables)) : ?>
			<tr>
				<td colspan="20" align="center">
					<?= @text('No items found'); ?>
				</td>
			</tr>
			<? endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="20">
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