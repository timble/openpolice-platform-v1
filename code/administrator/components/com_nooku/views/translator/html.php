<?php
/**
 * @version		$Id: html.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Translator HTML View
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewTranslator extends KViewHtml
{
	public function display($tpl = null)
	{
		// @todo ACLs need to be set in this view
		JError::raiseNotice(0, 'Editing translator permissions will be back in a later version');
		
		$model = KFactory::get('admin::com.nooku.model.translators');

		$this->assignRef('translator', $model->getItem());
		
		$this->displayToolbar();

		// Display the layout
		parent::display($tpl);
	}

    public function displayToolbar()
    {
       $name = $this->getClassName();

		// Set the titlebar text
		JToolBarHelper::title( JText::sprintf( ucfirst($name['prefix']).' - %s', ucfirst($name['suffix']) ), 'langmanager');
	
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel('cancel', JText::_('Close'));
		JToolBarHelper::divider();

        //$bar = JToolBar::getInstance('toolbar');
        //$bar->appendButton( 'Popup', 'help', 'Help', Nooku::HELP_URL);
    }
}
