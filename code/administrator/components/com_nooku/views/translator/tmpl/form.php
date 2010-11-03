<? /** $Id: form.php 737 2008-09-28 03:12:00Z Johan $ */ ?>
<? defined('_JEXEC') or die; ?>
<? @helper('behavior.tooltip'); ?>

<? @helper('stylesheet', 'form.css', Nooku::getURL('css')); ?>

<form action="<?= @route('id='.@$translator->id)?>" method="post" class="adminform" name="adminForm">
	<div class="col60">
		<fieldset>
			<legend><?= @text('Details'); ?></legend>
			<dl>
				<dt><label><?= @text('User'); ?></label></dt>
				<dd>
					<?= @helper('list.users', 'user_id', @$translator->user_id, 1); ?>
				</dd>
				<dt><label><?= @text('Language'); ?></label></dt>
				<dd>
					<?= @helper('html.select.languages', @$translator->iso_code, 'iso_code'); ?>
				</dd>
			</dl>
			<input type="hidden" name="task" value="" />
		</fieldset>
	</div>
</form>