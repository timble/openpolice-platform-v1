<?php
class plgContentTidy extends JPlugin
{
	public function onBeforeContentSave($article, $is_new)
	{
		$tidy_options = array(
			'show-body-only'				=> true,
			'clean'							=> true,
			'word-2000'						=> true,
			'drop-font-tags'				=> true,
			'drop-proprietary-attributes'	=> true
		);

		$article->text = tidy_repair_string($article->text, $tidy_options);

		return true;
	}
}