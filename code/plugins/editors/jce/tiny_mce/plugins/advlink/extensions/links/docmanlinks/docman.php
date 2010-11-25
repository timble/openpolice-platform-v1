<?php
/**
* @package JCE Docman Links
* @copyright Copyright (C) 2005 - 2010 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see licence.txt
* JCE Docman Links is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JCE_EXT' ) or die( 'Restricted access' );
class AdvlinkDocman{
	function getOptions(){
		$advlink =& AdvLink::getInstance();
		$list = '';
		if( $advlink->checkAccess( 'advlink_docmanlinks', '1' ) ){
			$list = '<li id="index.php?option=com_docman"><div class="tree-row"><div class="tree-image"></div><span class="folder docmanlinks nolink"><a href="javascript:;">' . JText::_('DOCMAN') . '</a></span></div></li>';
		}
		return $list;	
	}
	function getItems( $args ){		
		global $_DOCMAN, $mainframe;
		
		$advlink 	=& AdvLink::getInstance();
		$params 	= $advlink->getPluginParams();
		
		jimport('joomla.filesystem.file');

		require_once( JPATH_ADMINISTRATOR . DS. 'components' .DS. 'com_docman' .DS. 'docman.class.php');
		//DOCMan core interaction API
		$_DOCMAN = new dmMainFrame( _DM_TYPE_DOCLINK );

		// Load classes and language
	
		require_once( $_DOCMAN->getPath( 'classes', 'utils' ) );		
		$cid = isset( $args->gid ) ? $args->gid : 0;
		
		//get folders
        $categories = DOCMAN_Cats::getChildsByUserAccess( $cid );

		$items 	= array();
		$task	= isset( $args->task ) ? $args->task : '';
		
		switch( $task ){
			default:
				foreach( $categories as $category ){
					$items[] = array(
						'id'		=>	'index.php?option=com_docman&task=cat_view&gid=' . $category->id . AdvLink::getItemId( 'com_docman' ),
						'name'		=>	$category->name,
						'class'		=>	'folder docmanlinks'
					);
				}
				break;
			case 'cat_view':
				//get items
				if( $cid ){
					$categories = DOCMAN_Cats::getChildsByUserAccess( $cid );
					$documents 	= DOCMAN_Docs::getDocsByUserAccess( $cid, 'name', 'ASC', 999, 0 );
				}else{
					$categories = array();
					$documents 	= array();
				}
				foreach( $categories as $category ){					
					$items[] = array(
						'id'		=>	'index.php?option=com_docman&task=cat_view&gid=' . $category->id . AdvLink::getItemId( 'com_docman' ),
						'name'		=>	$category->name,
						'class'		=>	'folder docmanlinks'
					);
				}
				foreach( $documents as $document ){										
					$items[] = array(
						'id'		=>	'index.php?option=com_docman&task=doc_'. $params->get( 'advlink_docmanlinks_link', 'download' ) .'&gid=' . $document->id . AdvLink::getItemId( 'com_docman' ),
						'name'		=>	$document->dmname,
						'class'		=>	'file docmanlinks '. JFile::getExt( $document->dmfilename )
					);
				}
				break;
		}
		return $items;
	}
}
?>