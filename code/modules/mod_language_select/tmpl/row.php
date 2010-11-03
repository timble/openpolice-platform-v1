<? /** $Id: row.php 1099 2009-10-01 00:05:49Z johan $ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<div class="nooku_language_select">
	<? $i = 0; ?>
	<? foreach(@$languages as $lang) : ?>
		<? $i++; ?>
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
		<? if($i < count(@$languages)) : ?>
				<span class="seperator">|</span>
		<? endif; ?>
	<? endforeach; ?>
	
	<form action="<?= @$uri->toString(array('path', 'query'))?>" method="post"  name="languageForm">
		<input type="hidden" id="language-select" name="lang" value="" />
	</form>
</div>
