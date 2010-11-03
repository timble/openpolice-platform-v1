<? /** $Id: form.php 852 2008-11-14 01:28:43Z mathias $ */ ?>
<? @helper('behavior.tooltip'); ?>
<? @helper('script', 'view.language.js', Nooku::getURL('js')); ?>
<? @helper('stylesheet', 'form.css', Nooku::getURL('css')); ?>
<?=@helper('behavior.modal')?>

<form action="<?= @route('id='.@$language->id) ?>" method="post" class="adminform" name="adminForm">
	<div class="col40">
		<fieldset id="lang_langpack">
			<legend><?= @text('Language pack'); ?></legend>
			<dl>
				<dt><label><?= @text('Language pack'); ?></label></dt>
				<dd>
					<?=@helper('nooku.select.langpacks', @$language->iso_code) ?>
				</dd>
			</dl>
		</fieldset>
	</div>

	<div class="col60 lang_details">
		<fieldset id="lang_details">
			<legend><?= @text('Details'); ?></legend>
			<dl>
				<dt style="height:28px"><label><?= @text('ISO Code'); ?></label></dt>
				<dd>
					<?= @helper('nooku.input.isocode', @$language->iso_code); ?>
				</dd>
				<dt><label><?= @text('Name'); ?></label></dt>
				<dd>
					<input id="name_field" type="text" name="name" value="<?= @$language->name; ?>" />
				</dd>
				<dt><label><?= @text('Native Name'); ?></label></dt>
				<dd>
					<input id="native_field" type="text" name="native_name" value="<?= @$language->native_name; ?>" />
				</dd>
				<dt><label><?= @text('Alias'); ?></label></dt>
				<dd>
					<input id="alias_field" type="text" name="alias" value="<?= @$language->alias; ?>" />
				</dd>
				<dt><label><?= @text('Operations'); ?></label></dt>
				<dd>
					<?= @helper('nooku.select.operations', @$language->operations); ?>
				</dd>
				<dt><label><?= @text('Flag image'); ?></label></dt>
				<dd>
					<?= @helper('nooku.flag.image', @$language) ?>
					<a rel="{handler: 'iframe', size: {x: 505, y: 480}}" href="index.php?option=com_nooku&view=flags&tmpl=component" class="modal">
						<?=@text('Pick a flag...') ?>
					</a>
				</dd>
			</dl>
		</fieldset>
	</div>
<input type="hidden" name="image" id="image" value="" />
<input type="hidden" name="task" value="" />	
</form>
