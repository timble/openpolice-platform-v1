<?php
/**
 * @version		$Id: avreloaded.php 945 2008-06-09 17:28:15Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Editor button
 */
class plgButtonAvReloaded extends JPlugin
{
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @param 	object $subject The object to observe
     * @param 	array  $config  An array that holds the plugin configuration
     * @since 1.5
     */
    function plgButtonAvReloaded(& $subject, $config) {
        parent::__construct($subject, $config);
    }

    /**
     * Display the button
     *
     * @return array A two element array of(imageName, textToInsert)
     */
    function onDisplay($name) {
        $link = 'index.php?option=com_avreloaded&amp;view=insert&amp;tmpl=component&amp;e_name='.$name;
        JHTML::_('behavior.modal');
        $button = new JObject();
        $button->set('modal', true);
        $button->set('link', $link);
        $button->set('text', JText::_('AVR Media'));
        $button->set('name', 'image');
        $button->set('options', "{handler: 'iframe', size: {x: 600, y: 650}}");
        return $button;
    }
}
