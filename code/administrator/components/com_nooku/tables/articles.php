<?php
/**
 * @version		$Id: articles.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Site
 * @subpackage  Models
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */


/**
 * Nooku Articles Table
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Tables
 */
class NookuTableArticles extends  KDatabaseTableAbstract
{
	/**
	 * Object constructor to set table and key field
	 *
	 * @param	array 	An optional associative array of configuration settings.
	 */
	public function __construct( array $options = array() )
	{
       	//Force the table to use the core content table
		$options['table_name'] = 'content';

		parent::__construct($options);
	}
}
