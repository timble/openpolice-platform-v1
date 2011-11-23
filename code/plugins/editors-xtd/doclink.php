<?php
/**
 * @version		$Id: doclink.php 1125 2010-01-15 13:50:13Z tom $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
 * plgButtonDoclink Class
 */
class plgButtonDoclink extends JPlugin 
{
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @param   object $subject The object to observe
     * @param   array  $config  An array that holds the plugin configuration
     * @since 1.5
     */
    function plgButtonDoclink(& $subject, $config) {
        parent::__construct($subject, $config);
    }

    /**
     * Display the button
     */
    function onDisplay($name)
    {
        $doc            =& JFactory::getDocument();

        $doclink_url    = JURI::root()."plugins/editors-xtd/doclink";
        $docman_url     = JURI::root()."components/com_docman/";

        $style = ".button2-left .doclink {
                background:transparent url($doclink_url/images/j_button2_doclink.png) no-repeat scroll 100% 0pt;
                }";
        $doc->addStyleDeclaration($style);

        $doc->addScript($docman_url.'assets/js/doclink.js');

        $button = new JObject();
        $button->set('modal', true);
        $button->set('text', JText::_('DOClink'));
        $button->set('name', 'doclink');
        $button->set('link', JRoute::_('index.php?option=com_docman&amp;task=doclink&amp;e_name='.$name.'&amp;format=raw'));
        $button->set('options', "{handler: 'iframe', size: {x: 570, y: 510}}");

        return $button;
    }
}