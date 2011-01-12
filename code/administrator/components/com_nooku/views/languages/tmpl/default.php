<? /** $Id: default.php 833 2008-11-08 01:55:13Z johan $ */ ?>
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
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count(@$languages); ?>);" />
				</th>
				<th>
					<?= @helper('grid.sort', 'Name', 'name', @$filter['direction'], @$filter['order']); ?>
				</th>
				<th>
					<?= @helper('grid.sort', 'Native Name', 'native_name', @$filter['direction'], @$filter['order']); ?>
				</th>
				<th width="10%">
					<?= @helper('grid.sort', 'ISO Code', 'iso_code', @$filter['direction'], @$filter['order']); ?>
				</th>
                <th width="31px" nowrap="nowrap">
                    <?= @text('Flag'); ?>
                </th>
                <th width="31px" nowrap="nowrap">
                    <?= @helper('grid.sort', 'Ordering', 'ordering', 'DESC' /*always desc!*/, @$filter['order']); ?>
                </th>
                <th width="31px" nowrap="nowrap">
                    <?= @text('Primary'); ?>
                </th>
				<th width="15%" nowrap="nowrap">
					<?= @helper('grid.sort', 'Alias', 'alias', @$filter['direction'], @$filter['order']); ?>
				</th>
				<th width="15%" nowrap="nowrap">
					<?= @helper('grid.sort', 'Operations', 'operations', @$filter['direction'], @$filter['order']); ?>
				</th>
				<th width="31px" nowrap="nowrap">
					<?= @helper('grid.sort', 'Published', 'enabled', @$filter['direction'], @$filter['order']); ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<? $i = 0; $m = 0; ?>
			<? foreach (@$languages as $language) : ?>
			<tr class="<?php echo 'row'.$m; ?>">
				<td align="center">
					<?= $i + 1; ?>
				</td>
				<td align="center">
					<?= @helper('grid.id', $i, $language->id); ?>
				</td>
				<td>
					<a class="select-language" href="<?= @route('view=language&task=edit&id='.$language->id); ?>"><?= $language->name; ?></a>
				</td>
				<td>
					<?= $language->native_name; ?>
				</td>
				<td align="center">
					<a class="select-language" href="<?= @route('view=language&task=edit&id='.$language->id); ?>"><?= $language->iso_code; ?></a>
				</td>

                <td align="center">
                    <?= @helper('nooku.flag.image', $language); ?>
                </td>
                <td align="center">
                	<?= @helper('grid.order', $language->id) ?>
                </td>
                <td align="center">
                    <? if($language->primary): ?>
                        <img src="templates/khepri/images/menu/icon-16-default.png" alt="<?= @text( 'Primary Language' ); ?>" />
                    <? else: ?>
                        &nbsp;
                    <? endif; ?>
                </td>
				<td align="center">
					<?= $language->alias; ?>
				</td>
				<td align="center">
					 <?= @helper('nooku.string.operations', $language->operations); ?>
				</td>
				<td align="center">
					<? if($language->primary): ?>
                	 	<?= @text('n/a') ?>
                    <? else: ?>
                    	<?= @helper('grid.enable', $language->enabled, $i ); ?>    
                    <? endif; ?>
				</td>
			</tr>
			<? $i = $i + 1; $m = (1 - $m); ?>
			<? endforeach; ?>

			<? if (!count(@$languages)) : ?>
			<tr>
				<td colspan="8" align="center">
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

	<input type="hidden" name="order_change" value="0" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?= @$filter['order']; ?>" />
	<input type="hidden" name="filter_direction" value="<?= @$filter['direction']; ?>" />
</form>