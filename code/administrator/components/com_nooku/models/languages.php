<?php
/**
 * @version		$Id: languages.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Languages Model
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 */
class NookuModelLanguages extends KModelTable
{
    /**
     * Adds an 'primary' flag to the language objects
     */
    public function getList( )
    {
        $languages = parent::getList();

        $primary = KFactory::get('admin::com.nooku.model.nooku')
                        ->getPrimaryLanguage()
                        ->iso_code;

        foreach($languages as $lang) {
        	$lang->primary = ($lang->iso_code == $primary);
        }

        return $languages;
    }
}
