<?php
/**
 * @version     $Id: permissions.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * Simple placeholder permissions model
 * 
 * @todo 		Needs to be replaced by proper ACL
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 */
class NookuModelPermissions extends KModelAbstract
{
    /**
     * Check if the current user can translate
     * 
     * @return 	boolean
     */
    public function canTranslate()
    {
    	static $result;
    	
    	if(!isset($result))
    	{
    		$user = KFactory::get('lib.joomla.user');
    		
    		if($this->canManage()) {
    			$result = true;
    		} 
    		else 
    		{
    			$db  = KFactory::get('lib.joomla.database');
    			$query = $db->getQuery()
    				->count()
    				->from('nooku_translators')
    				->where('enabled', '=', '1')
    				->where('user_id', '=', $user->id);
    				
    			$db->setQuery($query);
    			$result = (bool) $db->loadResult();
    		}	
    	}
    	
    	return $result;
    }
    
    /**
     * Check if the user can manage langs, tables, translators
     *
     * @return	bool
     */
    public function canManage()
    {
   		$config 	= KFactory::get('admin::com.nooku.config.nooku');
   		$user 		= KFactory::get('lib.joomla.user');

   		$isSuper 	= ($user->gid == 25);
    	$isDemo 	= (in_array($user->gid, array(23, 24))) && $config->managersCanManage;
    	$result 	= $isSuper || $isDemo;

       	return $result;
    }
}