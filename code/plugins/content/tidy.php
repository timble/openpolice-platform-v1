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

		$article->introtext	= tidy_repair_string($article->introtext, $tidy_options);
		$article->fulltext	= tidy_repair_string($article->fulltext, $tidy_options);

		return true;
	}
}