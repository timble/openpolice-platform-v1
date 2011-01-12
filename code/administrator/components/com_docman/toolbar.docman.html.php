<?php
/**
 * @version		$Id: toolbar.docman.html.php 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class TOOLBAR_docman {
    function NEW_DOCUMENT_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::save();
        dmToolBar::apply();
        dmToolBar::cancel();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function MOVE_DOCUMENT_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::save('move_process');
        dmToolBar::cancel();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function COPY_DOCUMENT_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::save('copy_process');
        dmToolBar::cancel();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function DOCUMENTS_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::publishList();
        dmToolBar::unpublishList();
        dmToolBar::addNew();
        dmToolBar::editList();
        dmToolBar::copy('copy_form');
        dmToolBar::move('move_form');
        dmToolBar::deleteList();
        dmToolBar::divider();
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function UPLOAD_FILE_MENU()
    {
        $step = JRequest::getInt('step', '');
        dmToolBar::startTable();
        dmToolBar::logo();
        switch ($step) {
            case '2':
            case '4';
                dmToolBar::back( 'back',_DML_TOOLBAR_BACK, 'index.php?option=com_docman&amp;section=files&amp;task=upload');
                dmToolBar::divider();
                break;
            default:
                break;
        }
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function FILES_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::addNewDocument();
        dmToolBar::deleteList();
        dmToolBar::upload();
        dmToolBar::divider();
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function EDIT_CATEGORY_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::save();
        dmToolBar::apply();
        dmToolBar::cancel();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function CATEGORIES_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::publishList();
        dmToolBar::unpublishList();
        dmToolBar::addNew('new', _DML_ADD);
        dmToolBar::editList();
        dmToolBar::deleteList();
        dmToolBar::divider();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function LOGS_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::deleteList();
        dmToolBar::divider();
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function EDIT_GROUPS_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::save('saveg');
        dmToolBar::apply();
        dmToolBar::cancel();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function GROUPS_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::addNew('new', _DML_ADD);
        dmToolBar::editList();
        dmToolBar::deleteList();
        dmToolBar::divider();
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function EMAIL_GROUPS_MENU(){
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::sendEmail();
        dmToolBar::cancel();
        dmToolBar::divider();
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();

    }

    function EDIT_LICENSES_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::save();
        dmToolBar::apply();
        dmToolBar::cancel();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function LICENSES_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::addNew('edit', _DML_ADD);
        dmToolBar::editList();
        dmToolBar::deleteList();
        dmToolBar::divider();
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function STATS_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function NEW_THEME_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::back();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function EDIT_THEME_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::save();
        dmToolBar::apply();
        dmToolBar::cancel();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function CSS_THEME_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::save('save_css');
        dmToolBar::apply('apply_css');
        dmToolBar::cancel();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function THEMES_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::publishList( 'publish', _DML_TOOLBAR_DEFAULT);
        dmToolBar::addNew('new', _DML_ADD );
        dmToolBar::editList();
        dmToolBar::deleteList();
        dmToolBar::editCss();
        dmToolBar::divider();
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }



    function CONFIG_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::save();
        dmToolBar::apply();
        dmToolBar::cancel();
        dmToolBar::spacer();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }

    function CPANEL_MENU()
    {
        dmToolBar::startTable();
        dmToolBar::help();
        dmToolBar::endTable();
    }


    function CLEARDATA_MENU(){
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::clear();
        dmToolBar::divider();
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }
    function _DEFAULT()
    {
        dmToolBar::startTable();
        dmToolBar::logo();
        dmToolBar::addNew();
        dmToolBar::editList();
        dmToolBar::deleteList();
        dmToolBar::cpanel();
        dmToolBar::help();
        dmToolBar::spacer();
        dmToolBar::endTable();
    }
} // end class

