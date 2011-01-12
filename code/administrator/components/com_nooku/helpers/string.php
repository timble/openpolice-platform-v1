<?php
/**
 * @version     $Id: string.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Helpers
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * View helper for styling strings
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Helpers
 */
class NookuHelperString
{
    public static function status($status, $original = 0, $deleted = 0)
    {
        $arr = array(
            Nooku::STATUS_UNKNOWN    => 'Unknown',
            Nooku::STATUS_COMPLETED  => 'Completed',
            Nooku::STATUS_MISSING    => 'Missing',
            Nooku::STATUS_OUTDATED   => 'Outdated',
            Nooku::STATUS_PENDING    => 'Pending'
      	);

        if($original) {
        	$text  = 'Original';
            $class = 'original';
        } else {
        	$text  = $arr[$status];
            $class = strtolower($arr[$status]);
        }

        $class = $deleted ? 'deleted' : $class;

        return '<span class="nooku_status '.$class.'">'
                .JText::_($text)
                .'</span>';
    }

    public static function operations($operations)
    {
        $text = array();
		if($operations & KDatabase::OPERATION_INSERT) {
			$text[] = JText::_('add');
		}

		if($operations & KDatabase::OPERATION_UPDATE) {
			$text[] = JText::_('edit');
		}

		if($operations & KDatabase::OPERATION_DELETE) {
			$text[] = JText::_('delete');
		}

        return '<span class="nooku_operations">'
					.implode(', ', $text)
                .'</span>';
    }
}