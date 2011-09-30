<? /** $Id$ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<ul class="language_select">
	<? $i = 0; ?>
	<? foreach(@$languages as $lang) : ?>
		<? $i++; ?>
		<? if($lang->iso_code != $this->current_lang->iso_code) : ?>
		<li>
			<a href="#" onclick="document.languageForm.lang.value='<?= $lang->iso_code ?>'; document.languageForm.submit();return false;">
				<? if('flag' == @$display_flag || 'both' == @$display_flag) : ?>
					<?= @helper('nooku.flag.image', $lang); ?>
				<? endif; ?>
				<? if('name' == @$display_flag || 'both' == @$display_flag) : ?>
					<?= $lang->{@$langformat} ?>
				<? endif; ?>
			</a>
		</li>
		<? else : ?>
		<li class="active">
			<a href="#">
				<? if('flag' == @$display_flag || 'both' == @$display_flag) : ?>
					<?= @helper('nooku.flag.image', $lang); ?>
				<? endif; ?>
				<? if('name' == @$display_flag || 'both' == @$display_flag) : ?>
					<?= $lang->{@$langformat} ?>
				<? endif; ?>
			</a>	
		</li>
		<? endif; ?>
	<? endforeach; ?>
	
	<form action="<?= @$uri->toString(array('path', 'query'))?>" method="post"  name="languageForm">
		<input type="hidden" id="language-select" name="lang" value="" />
	</form>
</ul>