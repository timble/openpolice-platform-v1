<?php
/**
 * @version		$Id: language.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Elements
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Renders a category element
 *
 * @author      Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Elements
 */
class JElementLanguage extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	public $_name = 'Language';

	public function fetchElement($name, $value, &$node, $control_name)
	{
		$db = KFactory::get('lib.joomla.database');

		KViewHelper::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_nooku'.DS.'helpers');
		return KViewHelper::_('nooku.select.languages', $value, $control_name.'['.$name.']', array('class' => 'inputbox', 'size' => '1'), null, false);
	}
}