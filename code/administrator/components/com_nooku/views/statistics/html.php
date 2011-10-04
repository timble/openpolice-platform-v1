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
 * Nooku Dashboard HTML View
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewStatistics extends KViewHtml
{
	public function display($tpl = null)
	{
        // Request
        $month      = KInput::get('month', 'get', 'digit', null, date('m'));
        $year       = KInput::get('year',  'get', 'int', null, date('Y'));        
        
        $graph      = KInput::get('graph', 	  'get', 'cmd', null, 'translations');
        $table_name = KInput::get('table_name', 'get', KFactory::tmp('admin::com.nooku.filter.tablename'), null, '');
        
        $this->assign('graph', $graph);
        $this->assign('table_name', $table_name);
        $this->assign('month', $month);
        $this->assign('year', $year);

        // URI
        $uri = & JURI::getInstance(JURI::base().JRoute::_('index.php?option=com_nooku&format=openflashchart'));
		$uri->setVar('table_name',  $table_name);
		$uri->setVar('layout', 'bar');

		$uri->setVar('view'  , 'statistics.translations');
		$this->assign('translations', $uri->toString());

		$uri->setVar('year', date('Y'));
		$uri->setVar('month', date('n'));
        $uri->setVar('view', 'statistics.translators');
        $this->assign('translators', $uri->toString());

        // panes
        Koowa::import('lib.joomla.html.pane');
        $this->assignRef('panes', JPane::getInstance('tabs'));
		
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
        //$bar = JToolBar::getInstance('toolbar');
        //$bar->appendButton( 'Popup', 'help', 'Help', Nooku::HELP_URL);
    }
}