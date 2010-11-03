<?php
/**
 * @version		$Id: input.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Helpers
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * View helper for creating input boxes
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Helpers
 */
class NookuHelperInput
{
	public static function isocode($iso_code = '')
	{
		$lang = '';
		$country = '';
		if(!empty($iso_code)) {
			list($lang, $country) = explode('-', $iso_code, 2);
		}
		$style 	= 'style="font-size:18px;font-weight:bold;text-align:center;"';
		$common	= ' class="iso_code_field" maxlength="2" size="1" type="text"';
		return "<span $style>"
			  .'<input id="iso_code_lang_field" name="iso_code_lang"  value="'.$lang.'" '.$style.$common.' />'
			  .' - '
			  .'<input id="iso_code_country_field" name="iso_code_country" value="'.$country.'" '.$style.$common.' />'
			  .'</span>';
	}
}