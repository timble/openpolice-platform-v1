<?php
/**
 * @version     $Id: modules.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package     Koowa_Document
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.koowa.org
 */

/**
 * Modules renderer
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category	Koowa
 * @package		Koowa_Document
 * @subpackage	Html
 * @uses 		KFactory
 */
class KDocumentHtmlRendererModules extends KDocumentRenderer
{
	/**
	 * Renders multiple modules script and returns the results as a string
	 *
	 * @param string 	$name		The position of the modules to render
	 * @param array 	$params		Associative array of values
	 * @return string	The output of the script
	 */
	public function render( $position, array $params = array(), $content = null )
	{
		$renderer = KFactory::get('lib.koowa.document.html.renderer.module');

		$contents = '';
		foreach (JModuleHelper::getModules($position) as $mod)  {
			$contents .= $renderer->render($mod, $params, $content);
		}
		return $contents;
	}
}