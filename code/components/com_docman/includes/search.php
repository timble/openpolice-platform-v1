<?php
/**
 * @version		$Id: search.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__) . DS.'search.html.php';
include_once dirname(__FILE__) . DS.'documents.php';
include_once dirname(__FILE__) . DS.'documents.html.php';

require_once($_DOCMAN->getPath('classes', 'mambots'));
require_once($_DOCMAN->getPath('classes', 'utils'));

$GLOBALS['search_mode']   = JRequest::getCmd('search_mode', 'any');
$GLOBALS['ordering']      = JRequest::getCmd('ordering', 'newest');
$GLOBALS['invert_search'] = JRequest::getInt('invert_search', 0);
$GLOBALS['reverse_order'] = JRequest::getInt('reverse_order', 0);
$GLOBALS['search_where']  = JRequest::getInt('search_where', 0);
$GLOBALS['search_phrase'] = JRequest::getString('search_phrase', '');
$GLOBALS['search_catid']  = JRequest::getInt('catid', 0);

function fetchSearchForm($gid, $itemid)
{
    global $search_mode, $ordering, $invert_search, $reverse_order, $search_where, $search_phrase, $search_catid;
    // category select list
    $options = array(JHTML::_('select.option','0', _DML_ALLCATS));
    $lists['catid'] = dmHTML::categoryList($search_catid , "", $options);

    $mode = array();
    $mode[] = JHTML::_('select.option','any' , _DML_SEARCH_ANYWORDS);
    $mode[] = JHTML::_('select.option','all' , _DML_SEARCH_ALLWORDS);
    $mode[] = JHTML::_('select.option','exact' , _DML_SEARCH_PHRASE);
    $mode[] = JHTML::_('select.option','regex' , _DML_SEARCH_REGEX);

    $lists['search_mode'] = JHTML::_('select.genericlist',$mode , 'search_mode', 'id="search_mode" class="inputbox"' , 'value', 'text', $search_mode);

    $orders = array();
    $orders[] = JHTML::_('select.option','newest', _DML_SEARCH_NEWEST);
    $orders[] = JHTML::_('select.option','oldest', _DML_SEARCH_OLDEST);
    $orders[] = JHTML::_('select.option','popular', _DML_SEARCH_POPULAR);
    $orders[] = JHTML::_('select.option','alpha', _DML_SEARCH_ALPHABETICAL);
    $orders[] = JHTML::_('select.option','category', _DML_SEARCH_CATEGORY);

    $lists['ordering'] = JHTML::_('select.genericlist',$orders, 'ordering', 'id="ordering" class="inputbox"',
        'value', 'text', $ordering);

    $lists['invert_search'] = '<input type="checkbox" class="inputbox" name="invert_search" '
     . ($invert_search ? ' checked ' : '')
     . '/>';
    $lists['reverse_order'] = '<input type="checkbox" class="inputbox" name="reverse_order" '
     . ($reverse_order ? ' checked ' : '')
     . '/>';

    $matches = array();
    if ($search_where && count($search_where) > 0) {
        foreach($search_where as $val) {
            $matches[ ] = JHTML::_('select.option',$val, $val);
        }
    } else {
        $matches[] = JHTML::_('select.option','search_description', 'search_description');
    }

    $where = array();
    $where[] = JHTML::_('select.option','search_name' , _DML_NAME);
    $where[] = JHTML::_('select.option','search_description' , _DML_DESCRIPTION);
    $lists['search_where'] = JHTML::_('select.genericlist',$where , 'search_where[]',
        'id="search_where" class="inputbox" multiple="multiple" size="2"' , 'value', 'text', $where);

    return HTML_DMSearch::searchForm($lists, $search_phrase);
}

function getSearchResult($gid, $itemid)
{
    global $search_mode, $ordering, $invert_search, $reverse_order, $search_where, $search_phrase, $search_catid;

    $search_mode = ($invert_search ? '-' : '') . $search_mode ;
    $searchList = array(
        array('search_mode' => $search_mode ,
            'search_phrase' => $search_phrase));
    $ordering = ($reverse_order ? '-' : '') . $ordering ;

    $rows = DOCMAN_Docs::search($searchList , $ordering , $search_catid , array(), $search_where);

    // This acts as the search header - so they can perform search again
    if (count($rows) == 0) {
        $msg = _DML_NOKEYWORD ;
    } else {
        $msg = sprintf(_DML_SEARCH . ' ' . _DML_SEARCH_MATCHES , count($rows));
    }

    $items = array();
    if (count($rows) > 0)
    {
        foreach($rows as $row) {
            // onFetchDocument event, type = list
            $bot = new DOCMAN_mambot('onFetchDocument');
            $bot->setParm('id' , $row->id);
            $bot->copyParm('type' , 'list');
            $bot->trigger();
            if ($bot->getError()) {
                _returnTo('cat_view', $bot->getErrorMsg());
            }

            // load doc
            $doc = & DOCMAN_Document::getInstance($row->id);

            // process content mambots
            DOCMAN_Utils::processContentBots( $doc, 'dmdescription' );

            $item = new StdClass();
            $item->buttons = &$doc->getLinkObject();
            $item->paths = &$doc->getPathObject();
            $item->data = &$doc->getDataObject();
            $item->data->category = $row->section;

            $items[] = $item;
        }
    }

    return $items;
}