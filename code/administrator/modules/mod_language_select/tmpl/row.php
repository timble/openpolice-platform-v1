<? /** $Id: row.php 1042 2009-06-22 22:26:11Z Johan $ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<span class="language">
	<? $i = 0; ?>
	<? foreach(@$languages as $lang) : ?>
		<? $i++; ?>
		<? if($lang->iso_code != @language) : ?>
			<a href="#" onclick="document.languageForm.lang.value='<?= $lang->iso_code ?>'; document.languageForm.submit();return false;">
				<? if(@$show_flag) : ?>
					<?= @helper('nooku.flag.image', $lang); ?>
				<? endif; ?>
				<? if(@$show_name) : ?>
					<?= $lang->{@$langformat} ?>
				<? endif; ?>
			</a>
		<? else : ?>
			<? if(@$show_flag) : ?>
				<?= @helper('nooku.flag.image', $lang); ?>
			<? endif; ?>
			<? if(@$show_name) : ?>
				<?= $lang->{@$langformat} ?>
			<? endif; ?>
		<? endif; ?>
		<? if($i < count(@$languages)) : ?>|<? endif; ?>
	<? endforeach; ?>
	
	<form action="<?= @$uri->toString()?>" method="post" id="language_select_form" name="languageForm">
		<input type="hidden" id="language-select" name="lang" value="" />
	</form>
</span>
