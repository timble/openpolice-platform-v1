<?php
/**
 * @version		$Id: view.html.php 1027 2008-07-06 22:46:07Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'avrgeneric.php');

/**
 * Players View
 */
class AvReloadedViewPlayers extends JView {
    /**
     * Players view display method
     * @return void
     **/
    function display($tpl = null) {
        AvrGenericHelper::addCSS(
            '.icon-48-avreloaded {background-image:url('.
            JURI::root().'/administrator/components/com_avreloaded/assets/avreloaded-48x48.png);}');
        JToolBarHelper::title(JText::_('AVR_TITLE_MANAGE_PLAYERS').' - AllVideos Reloaded', 'avreloaded');
        JToolBarHelper::deleteList();
        JToolBarHelper::editListX();
        JToolBarHelper::addNewX();
        JToolBarHelper::help('players', true);

        // Get data from the model
        $lists =& $this->_getViewLists();
        $items =& $this->get('Data');
        $this->assignRef('items', $items);
        $this->assignRef('lists', $lists);
        parent::display($tpl);
    }

    function &_getViewLists() {
        $app = JFactory::getApplication();
        $filter_order = $app->getUserStateFromRequest("com_avreloaded.filter_player_order",
            'filter_order', 'p.name', 'cmd');
        $filter_order_Dir = $app->getUserStateFromRequest("com_avreloaded.filter_player_order_Dir",
            'filter_order_Dir', 'ASC', 'word');
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit',
            $app->getCfg('list_limit'), 'int');
        $limitstart	= $app->getUserStateFromRequest('com_avreloaded.limitstart_player', 'limitstart', 0, 'int');

        $m = $this->getModel();
        // Tell the model how to sort
        $m->setState('filter_order', $filter_order);
        $m->setState('filter_order_Dir', $filter_order_Dir);
        $total = $m->getTotal();
        jimport('joomla.html.pagination');
        $page = new JPagination($total, $limitstart, $limit);
        // Tell the model the limits
        $m->setState('limit', $limit);
        $m->setState('limitstart', $limitstart);

        // table ordering
        $lists['order_Dir']	= $filter_order_Dir;
        $lists['order'] = $filter_order;
        $lists['page'] = $page;
        $lists['limit'] = $limit;
        $lists['limitstart'] = $limitstart;

        return $lists;
    }
}
