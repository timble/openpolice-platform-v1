<?php
/**
 * @version		$Id: select.php 1135 2010-07-02 13:06:03Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Helpers
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * View helper for creating different select lists
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @author      Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Helpers
 */
class NookuHelperSelect extends KViewHelperSelect
{
	public static function languages($selected, $name = 'filter_language_id', $attribs = array('class' => 'inputbox', 'size' => '1'), $idtag = null, $allowAny = false)
 	{
        $items = KFactory::get('admin::com.nooku.model.nooku')->getLanguages();

		// Build Language list
        $list = array();
		if($allowAny) {
			$list[] =  self::option('', JText::_( '- Select Language -' ), 'iso_code', 'name' );
		}

		$list = array_merge( $list, $items );

		// build the HTML list
		return self::genericlist($list, $name, $attribs, 'iso_code', 'name', $selected, $idtag );
 	}

    public static function statuses($selected, $name = 'filter_status', $attribs = array('class' => 'inputbox', 'size' => '1'), $idtag = null, $allowAny = false)
    {
        // Build list
        $list = array();
        if($allowAny) {
            $list[] = self::option('', JText::_( '- Select Status -' ), 'id', 'title' );
        }

        //$list[] = self::option(Nooku::STATUS_ORIGINAL,   JText::_('Original'),   'id', 'title' );
        $list[] = self::option(Nooku::STATUS_MISSING,    JText::_('Missing'),    'id', 'title' );
        $list[] = self::option(Nooku::STATUS_OUTDATED,   JText::_('Outdated'),   'id', 'title' );
        $list[] = self::option(Nooku::STATUS_COMPLETED,  JText::_('Completed'),  'id', 'title' );
        $list[] = self::option(Nooku::STATUS_PENDING,    JText::_('Pending'),  'id', 'title' );
        //$list[] = self::option(Nooku::STATUS_DELETED,    JText::_('Deleted'),    'id', 'title' );

        // build the HTML list
        return self::genericlist($list, $name, $attribs, 'id', 'title', $selected, $idtag );
    }

    public static function tables($selected, $name = 'filter_table_name', $attribs = array('class' => 'inputbox', 'size' => '1'), $idtag = null, $allowAny = false)
    {
         $tables = KFactory::get('admin::com.nooku.model.nooku')->getTables();
         
         //Don't show the modules
         unset($tables['modules']);
         foreach($tables as & $table) {
         	$table->value = $table->table_name;
         }

        // Build list
        $list = array();
        if($allowAny) {
            $list[] = self::option('', JText::_( '- Select Table -' ) , 'value', 'table_name' );
        }

        $list = array_merge( $list, $tables );

        // build the HTML list
        return self::genericlist($list, $name, $attribs, 'value', 'table_name', $selected, $idtag );
    }

    public static function translators($selected, $name = 'filter_translator', $attribs = array('class' => 'inputbox', 'size' => '1'), $idtag = null, $allowAny = false)
    {
       $items = KFactory::get('admin::com.nooku.model.nooku')->getTranslators();

        // Build list
        $list = array();
        if($allowAny) {
            $list[] = self::option('', JText::_( '- Select Translator -' ), 'id', 'name' );
        }

        $list = array_merge( $list, $items );

        // build the HTML list
        return self::genericlist($list, $name, $attribs, 'id', 'name', $selected, $idtag );
    }

    public static function months($selected, $name = 'filter_month', $attribs = array('class' => 'inputbox', 'size' => '1'), $idtag = null, $allowAll = false)
    {
        $list = array();
        if($allowAll)
        {
        	$list[] = self::option(0, JText::_( 'All' ), 'id', 'title' );
        }

        $months = KDate::getMonthNames();
        foreach($months as $key=>$month) {
            $list[] = self::option($key, $month, 'id', 'title' );
        }

        return self::genericlist($list, $name, $attribs, 'id', 'title', $selected, $idtag );
    }

    public static function years($selected, $start, $stop, $name = 'filter_year', $attribs = array('class' => 'inputbox', 'size' => '1'), $idtag = null)
    {
        $list = array();
        for($i = $start; $i <= $stop; $i++) {
            $list[] = self::option($i, $i, 'id', 'title' );
        }

        return self::genericlist($list, $name, $attribs, 'id', 'title', $selected, $idtag );
    }

	public static function operations($operations)
	{
		$selected = array();
		if($operations & KDatabase::OPERATION_INSERT) {
			$selected[] = KDatabase::OPERATION_INSERT;
		}

		if($operations & KDatabase::OPERATION_UPDATE) {
			$selected[] = KDatabase::OPERATION_UPDATE;
		}

		if($operations & KDatabase::OPERATION_DELETE) {
			$selected[] = KDatabase::OPERATION_DELETE;
		}

		$list 	= array();
		$list[] 	= KViewHelper::_('select.option',  KDatabase::OPERATION_INSERT, JText::_( 'Add'    ));
		$list[] 	= KViewHelper::_('select.option',  KDatabase::OPERATION_UPDATE, JText::_( 'Edit'   ));
		$list[] 	= KViewHelper::_('select.option',  KDatabase::OPERATION_DELETE, JText::_( 'Delete' ));

		return self::checklist($list, 'operations', $selected);
	}

	public static function flags() 
	{
		$result = '';
		$url	= Nooku::getUrl('flags');
		$flags = KFactory::get('admin::com.nooku.model.flags')->getList();
		foreach($flags as $code => $country) 
		{
			$result .=	'<a href="javascript:clickFlag(\''.$code.'\')" class="flag_select_wrapper">'
					   		.'<img class="flag_select_img" src="'.$url.$code.'.png" />'
					   		.'<div class="flag_select_country">'.$country.'</div>'
					   	.'</a>'.PHP_EOL;
		}
		return $result;
	}
	
	public static function langpacks($selected = null)
	{
		$list 	= KFactory::get('admin::com.nooku.model.langpacks')->getList();
		$unused = KFactory::get('admin::com.nooku.model.langpacks')->getUnused();
		
		$empty 				= new stdClass;
		$empty->name 		= '- '.JText::_('Select a language pack').' -';
		$empty->iso_code 	= '';

		$custom 			= new stdClass;
		$custom->name 		= JText::_('Custom');
		$custom->iso_code 	= 'custom';
		
		$install 			= new stdClass;
		$install->name 		= JText::_('Install a language pack...');
		$install->iso_code 	= 'install';
		
		
		
		if(empty($selected))
		{
			// new item
			$disabled	= null;
			$selected 	= '';
			$arr		= $unused;
		} else 
		{
			// existing record
			 $disabled 	=  'disabled="disabled"';
			 $selected 	= in_array($selected, array_keys($list)) ? $selected : 'custom';
			 $arr 		= $list;
		}
				
		array_unshift($arr, $empty);
		array_push($arr, $custom);
		array_push($arr, $install);
		
		$html = KViewHelper::_('select.genericlist', $arr, 'langpack', $disabled, 'iso_code', 'name', $selected);
		return $html;
	}
}