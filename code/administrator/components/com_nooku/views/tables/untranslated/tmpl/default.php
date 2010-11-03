<? /** $Id: default.php 737 2008-09-28 03:12:00Z Johan $ */ ?>
<? defined('_JEXEC') or die; ?>

<? @helper('stylesheet', 'grid.css', Nooku::getURL('css')); ?>
<? @helper('behavior.tooltip'); ?>

<form target="_top" action="<?= @route('controller=table')?>" method="post" name="adminForm">
	<fieldset>
		<div style="float: right">
			<button type="button" onclick="submitbutton('add');window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 700);">
				<?= @text( 'Add' );?></button>
			<button type="button" onclick="window.parent.document.getElementById('sbox-window').close();">
				<?= @text( 'Cancel' );?></button>
		</div>
		<div class="configuration" >
			<?= @text('Add Tables') ?>
		</div>
	</fieldset>

	<fieldset>
		<legend>
			<?= @text( 'Tables list' );?>
		</legend>

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
						<?= @text('Table name') ?>
					</th>
					<th>
						<?= @text('Table description') ?>
					</th>
					<th>
						<span class="hasTip" title="<?= @text('Text')?>::<?= @text('Not all tables contain text. in most situations, you\'ll only want to enable translations for tables with text') ?>">
							<?= @text('Text') ?>
						</span>
					</th>
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
						<?= @helper('grid.id', $i, $table->table_name); ?>
					</td>
					<td>
						<?= KInflector::humanize($table->table_name); ?>
					</td>
					<td>
						<?= @text($table->comment); ?>
					</td>
					<td>
						<span class="hasTip" title="<?= @text('Text')?>::<?= @text('Not all tables contain text. in most situations, you\'ll only want to enable translations for tables with text') ?>">
							<?= @helper('grid.boolean', $table->has_text ); ?>
						</span>
					</td>	
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
		</table>
	
	</fieldset>

	<input type="hidden" name="task" value="add" />
	<input type="hidden" name="boxchecked" value="0" />
</form>