<? /** $Id: default.php 1119 2010-05-20 22:30:59Z johan $ */ ?>
<? defined('_JEXEC') or die; ?>

<? @helper('stylesheet', 'translate.css', Nooku::getURL('css')); ?>
<? @helper('script', 	 'view.translate.js', Nooku::getURL('js')); ?>


<script type="text/javascript">
function insertTranslation()
{
	window.parent.tinyMCE.get('text').setContent(tinyMCE.get('text').getContent());
	return false;
}
var article_id = <?=@$id?>;
</script>

<style>
.button2-left { display: none; }
</style>

<fieldset style="width: 860px;">
	<div class="configuration" style="float: left;">
		<?=@text('Translate') ?>
	</div>
	<div style="float: right;">
		<button type="button" onclick="insertTranslation();window.parent.document.getElementById('sbox-window').close();"><?= @text('Insert') ?></button>
		<button type="button" onclick="window.parent.document.getElementById('sbox-window').close();"><?= @text('Cancel') ?></button>
	</div>
</fieldset>

<div style="width: 860px"> 
<div style="float: left; width: 410px;">
	<div style="height:25px">
		<?= @helper('nooku.flag.image', @$source_lang); ?>
		<?= @helper('select.genericlist',  @$languages, 'lang', 'onchange=""', 'iso_code', 'name', @$source_lang->iso_code, 'language-select' ); ?>
	</div>
 	<iframe id="source_article" src="<?=@$source_url?>" style="width: 410px; height: 475px; border: 1px solid silver;"></iframe>
</div>

<div style="float: right; width: 435px; height: 475px;">
	<div style="height:25px">
		<?= @helper('nooku.flag.image', @$target_lang); ?>
		<strong><?=@$target_lang->name?></strong>
	</div>
	<div id="target_article">
		<? $editor =& KFactory::get('lib.joomla.editor', array('tinymce')); ?>
		<?= $editor->display( 'text',  @$text , '445', '450', '75', '25', null, array('theme' => 'simple')) ; ?>
	</div>
</div>
</div>