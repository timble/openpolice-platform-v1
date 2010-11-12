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
 * Playlist View
 */
class AvReloadedViewPlaylist extends JView {
    /**
     * Playlist view display method
     * @return void
     **/
    function display($tpl = null) {
        AvrGenericHelper::addCSS(
            '.icon-48-avreloaded {background-image:url('.
            JURI::root().'/administrator/components/com_avreloaded/assets/avreloaded-48x48.png);}');
        // Get data from the model
        $lists =& $this->_getViewLists();
        $model =& $this->getModel();
        $data =& $model->getData();
        $items = $data->items;
        $isNew = (!file_exists($data->filename));
        $text = $isNew ? JText::_('New') : JText::_('Edit');
        JToolBarHelper::title($text.' '.JText::_('AVR_TITLE_PLAYLIST').' - AllVideos Reloaded', 'avreloaded');
        JToolBarHelper::save();
        if ($isNew)  {
            JToolBarHelper::cancel();
        } else {
            // for existing items the button is renamed `close`
            JToolBarHelper::apply();
            JToolBarHelper::cancel('cancel', 'Close');
        }
        if (count($items)) {
            JToolBarHelper::deleteList();
            JToolBarHelper::editListX();
        }
        JToolBarHelper::addNewX();
        JToolBarHelper::help('playlist', true);

        $this->assignRef('items', $items);
        $this->assignRef('data', $data);
        $this->assignRef('lists', $lists);
        parent::display($tpl);
    }

    function &_getViewLists() {
        $app = JFactory::getApplication();
        $filter_order = $app->getUserStateFromRequest("com_avreloaded.filter_playlist_order",
            'filter_order', 'filename', 'cmd');
        $filter_order_Dir = $app->getUserStateFromRequest("com_avreloaded.filter_playlist_order_Dir",
            'filter_order_Dir', 'asc', 'word');
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit',
            $app->getCfg('list_limit'), 'int');
        $limitstart	= $app->getUserStateFromRequest('com_avreloaded.limitstart_playlist', 'limitstart', 0, 'int');

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
