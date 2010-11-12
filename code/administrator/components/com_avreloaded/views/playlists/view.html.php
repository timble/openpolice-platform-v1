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
 * Playlists View
 */
class AvReloadedViewPlaylists extends JView {
    /**
     * Playlists view display method
     * @return void
     **/
    function display($tpl = null) {
        AvrGenericHelper::addCSS(
            '.icon-48-avreloaded {background-image:url('.
            JURI::root().'/administrator/components/com_avreloaded/assets/avreloaded-48x48.png);}');
        JToolBarHelper::title(JText::_('AVR_TITLE_MANAGE_PLAYLISTS').' - AllVideos Reloaded', 'avreloaded');

        $vdir = AvrGenericHelper::getVdir();
        $app =& JFactory::getApplication();
        $folder	= $app->getUserStateFromRequest('com_avreloaded.playlists_folder', 'folder', $vdir);

        // Get data from the model
        $fselect = $this->_getFolderSelect($vdir, $folder);
        $lists =& $this->_getViewLists($app, $folder);
        $model =& $this->getModel();
        $items =& $model->getData();
        if (count($items)) {
            JToolBarHelper::deleteList();
            JToolBarHelper::editListX();
        }
        JToolBarHelper::addNewX();
        JToolBarHelper::help('playlists', true);
        $files = '';
        foreach ($items as $i => $item) {
            if ($i > 0) {
                $files .= ',';
            }
            $files .= "'".basename($item->filename)."'";
        }
        $this->assignRef('items', $items);
        $this->assignRef('lists', $lists);
        $this->assignRef('fselect', $fselect);
        $this->assignRef('files', $files);
        parent::display($tpl);
    }

    function _getFolderSelect($top, $current) {
        jimport('joomla.filesystem.folder');
        $subdirs =& JFolder::folders($top, '.', true, true);
        $top_displayname = basename($top);
        $list = array(JHTML::_('select.option', htmlspecialchars($top), htmlspecialchars($top_displayname)));
        foreach ($subdirs as $dir) {
            $displayname = str_replace($top, $top_displayname, $dir);
            $list[] = JHTML::_('select.option', htmlspecialchars($dir), htmlspecialchars($displayname));
        }
        return JHTML::_('select.genericlist', $list, 'folder',
            'class="inputbox" size="1" onchange="document.adminForm.submit();"',
            'value', 'text', $current);
    }

    function &_getViewLists(&$app, $folder) {
        $filter_order = $app->getUserStateFromRequest("com_avreloaded.filter_playlists_order",
            'filter_order', 'filename', 'cmd');
        $filter_order_Dir = $app->getUserStateFromRequest("com_avreloaded.filter_playlists_order_Dir",
            'filter_order_Dir', 'asc', 'word');
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit',
            $app->getCfg('list_limit'), 'int');
        $limitstart	= $app->getUserStateFromRequest('com_avreloaded.limitstart_playlists', 'limitstart', 0, 'int');
        $m = $this->getModel();
        // Tell the model how to sort
        $m->setState('folder', $folder);
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
