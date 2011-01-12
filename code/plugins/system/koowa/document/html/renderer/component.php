<?php
/**
 * @version     $Id: component.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package     Koowa_Document
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.koowa.org
 */

/**
 * Component renderer
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category	Koowa
 * @package		Koowa_Document
 * @subpackage	Html
 */
class KDocumentHtmlRendererComponent extends KDocumentRenderer
{
	/**
	 * Renders a component script and returns the results as a string
	 *
	 * @param string 	$component	The name of the component to render
	 * @param array 	$params	Associative array of values
	 * @return string	The output of the script
	 */
	public function render( $component, array $params = array(), $content = null )
	{
		return $content;
	}
}
