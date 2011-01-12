<? /** $Id: default.php 852 2008-11-14 01:28:43Z mathias $ */ ?>
<? defined('_JEXEC') or die; ?>

<? @helper('stylesheet', 'grid.css', Nooku::getURL('css')); ?>
<? @helper('stylesheet', 'nooku_admin.css', Nooku::getURL('css')); ?>
<? @helper('script', 'view.flags.js', Nooku::getURL('js')); ?>


<fieldset>
	<div style="float: right">
		<button type="button" onclick="window.parent.document.getElementById('sbox-window').close();">
			<?= @text( 'Cancel' );?></button>
	</div>
	<div class="configuration" >
		<?= @text('Pick a flag') ?>
	</div>
</fieldset>
		
<?=@helper('nooku.select.flags') ?>