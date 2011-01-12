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
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewDashboard extends KViewHtml
{
	public function display($tpl = null)
	{
        $nooku  		= KFactory::get('admin::com.nooku.model.nooku');
        $dashboard  	= KFactory::get('admin::com.nooku.model.dashboard');
        $translations	= KFactory::get('admin::com.nooku.model.translations');
        $translators	= KFactory::get('admin::com.nooku.model.translators');
        
        // Mixin a menubar object
        $this->mixin(new NookuMixinMenu($this));

        $this->displayMenubar();
        $this->displayMenutitle();
        $this->displayToolbar();

		// Get data from the model

        // left panes
        $this->assignRef('additions',       $dashboard->getAdditions());
        $this->assignRef('changes',         $dashboard->getChanges());
        $this->assignRef('deletes',         $dashboard->getDeletes());
 
		$this->assignRef('all_translators', $nooku->getTranslators());
		$this->assignRef('all_languages', 	$nooku->getLanguages());
		$this->assignRef('all_tables', 		$nooku->getTables());

        // Pie chart URI's
        $this->assign('translations',  		$translations->getGoogleChartUrl());
        $this->assign('translators',   		$translators->getGoogleChartUrl());

        // Meta
        $this->assign('multiple_langs',   	count($nooku->getLanguages()) > 1);
		$this->assign('multiple_contributors', $translators->countContributors() > 1);
		$this->assign('has_tables',   		count($nooku->getTables()) > 0);
        
		// Display the layout
		parent::display($tpl);
	}

	public function displayToolbar()
	{
		// Add a preferences button
		//JToolBarHelper::preferences('com_nooku', '550');
        //JToolBarHelper::divider();

        //$bar = JToolBar::getInstance('toolbar');
        //$bar->appendButton( 'Popup', 'help', 'Help', Nooku::HELP_URL);
	}
}
