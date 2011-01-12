<?php
/**
 * @version		$Id: installation.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Controllers
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Installation Controller
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Controllers
 */
class NookuControllerInstallation extends KControllerAbstract
{
	/**
	 * Tables that are to be activated during install or on first run
	 */
	protected $_defaultTables = array('categories', 'content', 'menu', 'modules', 'sections');
	
	/**
	 * Finish installation tasks
	 */
	public function finish()
	{	
		jimport('joomla.filesystem.file');
		$tables = KFactory::get('admin::com.nooku.model.tables')->getTranslatedTables();
		if(!count($tables)) 
		{			
			$this->enableTables();
			JFile::write(
				JPATH_ADMINISTRATOR.DS.'components'.DS.'com_nooku'.DS.'configs'.DS.'first_run.php', 
				'<?php $first_run=false;'
			);
			$this->setRedirect('view=dashboard');
			return;
		}
	}
	
	public function enableTables()
	{
		$model	= KFactory::get('admin::com.nooku.model.tables');
		$tbl	= KFactory::get('admin::com.nooku.table.tables');
		
		$tables	= $model->getTableData($this->_defaultTables);
		
		foreach($tables as $table)
		{
			$tbl->insert($table);
		}
	}
}