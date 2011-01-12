<?php
/**
* @version      $Id: variable.php 2106 2010-05-26 19:30:56Z johanjanssens $
* @category		Koowa
* @package      Koowa_Template
* @subpackage	Rule
* @copyright    Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
* @license      GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.koowa.org
*/

/**
 * Template rule to convert @$ to $this->
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package     Koowa_Template
 * @subpackage	Rule 
 */
class KTemplateRuleVariable extends KObject implements KTemplateRuleInterface
{
	/**
	 * Convert @$ to $this->
	 *
	 * @param string $text
	 */
	public function parse(&$text) 
	{		 
        /**
         * We could make a better effort at only finding @$ between <?php ?>
         * but that's probably not necessary as @$ doesn't occur much in the wild
         * and there's a significant performance gain by using str_replace().
         * 
         * @TODO when there is template caching, we can afford more expensive 
         * transformations
         */
        $text = str_replace(array('@$', '@'), '$this->', $text);
	}
}
