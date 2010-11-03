<?php
/**
 * @version     $Id: flag.php 1140 2010-07-23 09:59:24Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Helpers
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * View helper for dealing with flags
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Helpers
 */
class NookuHelperFlag
{   
    public static function url($lang, $icons_url = null, $ext='.png')
    {
    	if(!$icons_url) {
        	$icons_url = Nooku::getURL('media').'images/flags/';
        }
        
       	$languages = KFactory::get('admin::com.nooku.model.nooku')->getLanguages();
        	
      	if(isset($languages[$lang->iso_code])) { 
        	$result = $icons_url. $languages[$lang->iso_code]->image;
        } else {
        	$result = $icons_url. KViewHelper::_('nooku.flag.country',$lang) .$ext;
        }
        	
        return $result;
    }
   
    public static function country($lang)
    {
    	if(!strpos($lang->iso_code, '-')) {
        	return 'unknown';
        }
        
        list($language, $country) = explode('-', $lang->iso_code, 2);
        return strtolower($country);
    }
    
    public static function image($lang, $icons_url = null, $ext=".png")
    {
    	KViewHelper::_('behavior.tooltip');
        
    	$url 	= KViewHelper::_('nooku.flag.url', $lang, $icons_url, $ext);

        return  '<div class="nooku_flag hasTip"'
                .' style="background-image: url('.$url.');" '
                .' title="'.$lang->iso_code.'">'
                .'</div>';
    }
}