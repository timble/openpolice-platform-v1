<? /** $Id: default.php 1042 2009-06-22 22:26:11Z Johan $ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<span class="nooku_statusbar_langselect">
	<form action="<?= @$uri->toString(array('path', 'query'))?>" method="post" style="margin: 0; padding: 0">
		<? if(@$show_flag) : ?>
			<?= @helper('nooku.flag.image', @$languages[@$language]); ?>
		<? endif; ?>
		<? if(@$show_name) : ?>
			<?= @helper('select.genericlist',  @$languages, 'lang', 'onchange="this.form.submit();"', 'iso_code', @$langformat, @$language, 'language-select' ); ?>
		<? endif; ?>
	</form>
</span>

