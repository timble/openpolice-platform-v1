<?php
/**
 * @version     $Id: html.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * Nooku Nodes HTML View
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewNodes extends KViewHtml
{
    public function display($tpl = null)
    {
        $nooku = KFactory::get('admin::com.nooku.model.nooku');
        $model = KFactory::get('admin::com.nooku.model.nodes');
         
        $filters = $model->getFilters();

        $this->assignRef('filters'    , $filters);
        $this->assignRef('items'      , $model->getList());
        $this->assignRef('pagination' , $model->getPagination());
        
        // This allows us to group items when sorting by table
        $group_tables = ($filters['order']=='table_name' && !$filters['iso_code'] && !$filters['status'] && !$filters['translator'] && !$filters['filter']);
        $this->assign('group_tables'  , $group_tables);
        
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