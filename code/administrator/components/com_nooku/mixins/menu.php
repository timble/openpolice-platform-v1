<?php
/**
 * @version		$Id: menu.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Mixins
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Menubar class
 * 
 * Used as a mixin in views to add the displayMenubar() method 
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Mixins
 */
class NookuMixinMenu
{
	/**
	 * Parent object
	 *
	 * @var object
	 */
	protected $_object;
	
	public function __construct($object) 
	{
    	$this->_object = $object;
    	KViewHelper::_('stylesheet', 'nooku_admin.css', 'media/com_nooku/css/');
    }
	
	public function displayMenubar()
	{
		$nooku	= KFactory::get('admin::com.nooku.model.nooku');
		$views  = array( 'dashboard' 	=> 'Dashboard');

		if( count($nooku->getTables())) 
        {
            $views['statistics'] = 'Statistics';
            $views['nodes']      = 'Items';
        }
        
        if(KFactory::get('admin::com.nooku.model.permissions')->canManage())
        {
	        $views['languages']		= 'Languages';
			$views['tables']  		= 'Tables';
			$views['translators']	= 'Translators';	
        }
                   
		foreach($views as $view => $title)
		{	
			$active = ($view == strtolower($this->_object->getClassName('suffix')) );
			JSubMenuHelper::addEntry(JText::_($title), 'index.php?option=com_nooku&view='.$view, $active );
		}
	}
	
	public function displayMenutitle($title = null)
	{
		$title = $title ? $title : ucfirst($this->_object->getClassName('suffix'));
		JToolBarHelper::title( JText::_($title), 'langmanager');
	}

}