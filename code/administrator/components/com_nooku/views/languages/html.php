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
 * Nooku Languages HTML View
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewLanguages extends KViewHtml
{
	public function display($tpl = null)
	{
		$model = KFactory::get('admin::com.nooku.model.languages');
		
		$this->assignRef('languages',  $model->getList());
		$this->assignRef('filter',     $model->getFilters());
		$this->assignRef('pagination', $model->getPagination());

        // Mixin a menubar object
        $this->mixin( new NookuMixinMenu($this));

        $this->displayMenubar();
        $this->displayMenutitle();
        $this->displayToolbar();

		// Display the layout
		parent::display($tpl);
	}


    public function displayToolbar()
    {
		JToolBarHelper::publishList('enable', JText::_('Publish'));
		JToolBarHelper::unpublishList('disable', JText::_('Unpublish'));
		JToolBarHelper::divider();
		JToolBarHelper::deleteList('Are you sure you want to delete these languages? All translations will be lost!', 'delete');
		JToolBarHelper::editList();
		JToolBarHelper::addNew();
		JToolBarHelper::divider();

        //$bar = JToolBar::getInstance('toolbar');
        //$bar->appendButton( 'Popup', 'help', 'Help', Nooku::HELP_URL);
    }
}
