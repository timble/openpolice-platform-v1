<? /** $Id: list.php 1114 2010-05-16 20:25:22Z johan $ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<? /*unset(@$languages[@$current_lang->iso_code]);*/ ?>

<div class="nooku_language_select">
	<ul>
	<? foreach(@$languages as $lang) : ?>
	<li>
		<? if($lang->iso_code != $this->current_lang->iso_code) : ?>		
			<a href="#" onclick="document.languageForm.lang.value='<?= $lang->iso_code ?>'; document.languageForm.submit();return false;">
				<? if('flag' == @$display_flag || 'both' == @$display_flag) : ?>
					<?= @helper('nooku.flag.image', $lang); ?>
				<? endif; ?>
				<? if('name' == @$display_flag || 'both' == @$display_flag) : ?>
					<?= $lang->{@$langformat} ?>
				<? endif; ?>
			</a>
		<? else : ?>		
			<span class="active">
				<? if('flag' == @$display_flag || 'both' == @$display_flag) : ?>
					<?= @helper('nooku.flag.image', $lang); ?>
				<? endif; ?>
				<? if('name' == @$display_flag || 'both' == @$display_flag) : ?>
					<?= $lang->{@$langformat} ?>
				<? endif; ?>
			</span>
		<? endif; ?>
	</li>
	<? endforeach; ?>
	</ul>

	<form action="<?= @$uri->toString(array('path', 'query'))?>" method="post" name="languageForm">
		<input type="hidden" id="language-select" name="lang" value="" />
	</form>
</div>
