<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

class PhocaGalleryCpControllerPhocaGalleryinstall extends PhocaGalleryCpController
{
	function __construct() {
		parent::__construct();
		$this->registerTask( 'install'  , 'install' );
		$this->registerTask( 'upgrade'  , 'upgrade' );		
	}

	function install() {		
		$db			= &JFactory::getDBO();
		//$dbPref 	= $db->getPrefix();
		$msgSQL 	= $msgFile = $msgError = '';		
		
		// ------------------------------------------
		// PHOCAGALLERY
		// ------------------------------------------
		$query =' DROP TABLE IF EXISTS '.$db->nameQuote('#__phocagallery').';';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query =' CREATE TABLE '.$db->nameQuote('#__phocagallery').'('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) unsigned NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('catid').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('sid').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('title').' varchar(250) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('alias').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('filename').' varchar(250) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('description').' text,'."\n";
		$query.=' '.$db->nameQuote('date').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('hits').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('latitude').' varchar(20) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('longitude').' varchar(20) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('zoom').' int(3) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('geotitle').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('videocode').' text,'."\n";
		$query.=' '.$db->nameQuote('vmproductid').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('imgorigsize').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('approved').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' '.$db->nameQuote('metakey').' text,'."\n";
		$query.=' '.$db->nameQuote('metadesc').' text,'."\n";
		$query.=' '.$db->nameQuote('extlink1').' text,'."\n";
		$query.=' '.$db->nameQuote('extlink2').' text,'."\n";
		$query.=' '.$db->nameQuote('extid').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('extl').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('extm').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('exts').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('exto').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('extw').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('exth').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').'),'."\n";
		$query.=' KEY '.$db->nameQuote('catid').' ('.$db->nameQuote('catid').','.$db->nameQuote('published').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		$query.=''."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// ------------------------------------------
		// PHOCAGALLERY CATEGORIES
		// ------------------------------------------
		$query=' DROP TABLE IF EXISTS '.$db->nameQuote('#__phocagallery_categories').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query=' CREATE TABLE '.$db->nameQuote('#__phocagallery_categories').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('parent_id').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('owner_id').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('title').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('name').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('alias').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('image').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('section').' varchar(50) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('image_position').' varchar(30) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('description').' text,'."\n";
		$query.=' '.$db->nameQuote('date').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('approved').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('editor').' varchar(50) default NULL,'."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('access').' tinyint(3) unsigned NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('count').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('hits').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('accessuserid').' text,'."\n";
		$query.=' '.$db->nameQuote('uploaduserid').' text,'."\n";
		$query.=' '.$db->nameQuote('deleteuserid').' text,'."\n";
		$query.=' '.$db->nameQuote('userfolder').' text,'."\n";
		$query.=' '.$db->nameQuote('latitude').' varchar(20) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('longitude').' varchar(20) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('zoom').' int(3) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('geotitle').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('extid').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('exta').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('extu').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('extauth').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' '.$db->nameQuote('metakey').' text,'."\n";
		$query.=' '.$db->nameQuote('metadesc').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').'),'."\n";
		$query.=' KEY '.$db->nameQuote('cat_idx').' ('.$db->nameQuote('section').','.$db->nameQuote('published').','.$db->nameQuote('access').'),'."\n";
		$query.=' KEY '.$db->nameQuote('idx_access').' ('.$db->nameQuote('access').'),'."\n";
		$query.=' KEY '.$db->nameQuote('idx_checkout').' ('.$db->nameQuote('checked_out').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';';
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// ------------------------------------------
		// PHOCAGALLERY VOTES
		// ------------------------------------------
		$query ='DROP TABLE IF EXISTS '.$db->nameQuote('#__phocagallery_votes').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query =' CREATE TABLE '.$db->nameQuote('#__phocagallery_votes').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('catid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('date').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('rating').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// ------------------------------------------
		// PHOCAGALLERY COMMENTS
		// ------------------------------------------
		$query ='DROP TABLE IF EXISTS '.$db->nameQuote('#__phocagallery_comments').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query =' CREATE TABLE '.$db->nameQuote('#__phocagallery_comments').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('catid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('date').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('title').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('comment').' text,'."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// ------------------------------------------
		// PHOCAGALLERY VOTES STATISTICS
		// ------------------------------------------
		$query ='DROP TABLE IF EXISTS '.$db->nameQuote('#__phocagallery_votes_statistics').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}

		$query =' CREATE TABLE '.$db->nameQuote('#__phocagallery_votes_statistics').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('catid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('count').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('average').' float(8,6) NOT NULL default \'0\','."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// ------------------------------------------
		// PHOCAGALLERY USER CATEGORY
		// ------------------------------------------
		// Removed in 2.6.0
	/*	$query ='DROP TABLE IF EXISTS '.$db->nameQuote('#__phocagallery_user_category').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
	
		$query =' CREATE TABLE '.$db->nameQuote('#__phocagallery_user_category').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('catid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').'),'."\n";
		$query.=' KEY '.$db->nameQuote('catid').' ('.$db->nameQuote('catid').','.$db->nameQuote('userid').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
	*/	
		// ------------------------------------------
		// PHOCAGALLERY IMAGE VOTES (2.5.0)
		// ------------------------------------------
		$query ='DROP TABLE IF EXISTS '.$db->nameQuote('#__phocagallery_img_votes').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
	
		$query =' CREATE TABLE '.$db->nameQuote('#__phocagallery_img_votes').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('imgid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('date').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('rating').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// ------------------------------------------
		// PHOCAGALLERY IMAGE VOTES STATISTICS (2.5.0)
		// ------------------------------------------
		$query ='DROP TABLE IF EXISTS '.$db->nameQuote('#__phocagallery_img_votes_statistics').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}

		$query =' CREATE TABLE '.$db->nameQuote('#__phocagallery_img_votes_statistics').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('imgid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('count').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('average').' float(8,6) NOT NULL default \'0\','."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
	
	
		// ------------------------------------------
		// PHOCAGALLERY USER (2.6.0)
		// ------------------------------------------
		$query ='DROP TABLE IF EXISTS '.$db->nameQuote('#__phocagallery_user').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
	
		$query =' CREATE TABLE '.$db->nameQuote('#__phocagallery_user').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('avatar').' varchar(40) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('approved').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').'),'."\n";
		$query.=' KEY '.$db->nameQuote('userid').' ('.$db->nameQuote('userid').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		
		// ------------------------------------------
		// PHOCAGALLERY IMAGES COMMENTS 2.6.0
		// ------------------------------------------
		$query ='DROP TABLE IF EXISTS '.$db->nameQuote('#__phocagallery_img_comments').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query =' CREATE TABLE '.$db->nameQuote('#__phocagallery_img_comments').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('imgid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('date').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('title').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('comment').' text,'."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
	
		
		// Error
		if ($msgSQL !='') {
			$msgError .= '<br />' . $msgSQL;
		}
		/*if ($msgFile !='') {
			$msgError .= '<br />' . $msgFile;
		}*/
		
		// End Message
		if ($msgError !='') {
			$msg = JText::_( 'Phoca Gallery not successfully installed' ) . ': ' . $msgError;
		} else {
			$msg = JText::_( 'Phoca Gallery successfully installed' );
		}
		
		$link = 'index.php?option=com_phocagallery';
		$this->setRedirect($link, $msg);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function upgrade() {
		
		$db			=& JFactory::getDBO();
		//$dbPref 	= $db->getPrefix();
		$msgSQL 	= $msgFile = $msgError = '';
		
		// UPGRADE PHOCA GALLERY 2 VERSION
		// ------------------------------------------
		// PHOCAGALLERY CATEGORIES
		// ------------------------------------------
		$updateHit 	= false;
		$errorMsg	= '';
		$updateHit = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "hits", "INT( 11 ) NOT NULL DEFAULT '0'", "count" );
		if (!$updateHit) {
			$msgSQL .= 'Error while updating HITS column';
		}
		
		// ------------------------------------------
		// PHOCAGALLERY VOTES
		// ------------------------------------------		
		$query =' CREATE TABLE IF NOT EXISTS '.$db->nameQuote('#__phocagallery_votes').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('catid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('date').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('rating').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// ------------------------------------------
		// PHOCAGALLERY COMMENTS
		// ------------------------------------------
		$query =' CREATE TABLE IF NOT EXISTS '.$db->nameQuote('#__phocagallery_comments').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('catid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('date').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('title').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('comment').' text,'."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// ------------------------------------------
		// PHOCAGALLERY VOTES STATISTICS
		// ------------------------------------------
		$query =' CREATE TABLE IF NOT EXISTS '.$db->nameQuote('#__phocagallery_votes_statistics').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('catid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('count').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('average').' float(8,6) NOT NULL default \'0\','."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// ------------------------------------------
		// PHOCAGALLERY USER CATEGORY
		// ------------------------------------------
		// Removed in 2.6.0
	/*	$query =' CREATE TABLE IF NOT EXISTS '.$db->nameQuote('#__phocagallery_user_category').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('catid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').'),'."\n";
		$query.=' KEY '.$db->nameQuote('catid').' ('.$db->nameQuote('catid').','.$db->nameQuote('userid').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
	*/	
		// UPGRADE PHOCA GALLERY 2.2 VERSION
		// ------------------------------------------
		// PHOCAGALLERY
		// ------------------------------------------
		$updateExtl1 	= false;
		$errorMsg		= '';
		$updateExtl1 = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "extlink1", "text", "params" );
		if (!$updateExtl1) {
			$msgSQL .= 'Error while updating Extlink1 column';
		}
		$updateExtl2 = false;
		$errorMsg	= '';
		$updateExtl2 = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "extlink2", "text", "extlink1" );
		if (!$updateExtl2) {
			$msgSQL .= 'Error while updating Extlink2 column';
		}
		
		// UPGRADE PHOCA GALLERY 2.2.2 VERSION
		// ------------------------------------------
		// PHOCAGALLERY CATEGORIES
		// ------------------------------------------
		$updateDate = false;
		$errorMsg	= '';
		$updateDate = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "date", "datetime NOT NULL default '0000-00-00 00:00:00'", "description" );
		if (!$updateDate) {
			$msgSQL .= 'Error while updating Date column';
		}
		
		// UPGRADE PHOCA GALLERY 2.5 VERSION
		// ------------------------------------------
		// New COLUMNS CATEGORY
		// ------------------------------------------
	
		// UPGRADE DATA SCRIPT NEEDS TO BE RUN
		$updateGeoT = false;
		$errorMsg	= '';
		$convertDataNeeded['cat-geotitle'] = 0;
		$updateGeoT = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "geotitle", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateGeoT) {
			$msgSQL .= 'Error while updating Geotitle (Category) column';
		} else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['cat-geotitle'] = 1;
			}
		}
		
		$updateZoom = false;
		$errorMsg	= '';
		$convertDataNeeded['cat-zoom'] = 0;
		$updateZoom = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "zoom", "int(3) NOT NULL default '0'", "hits" );
		if (!$updateZoom) {
			$msgSQL .= 'Error while updating Zoom (Category) column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['cat-zoom'] = 1;
			}
		}
		
		$updateLng = false;
		$errorMsg	= '';
		$convertDataNeeded['cat-longitude'] = 0;
		$updateLng = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "longitude", "varchar(20) NOT NULL default ''", "hits" );
		if (!$updateLng) {
			$msgSQL .= 'Error while updating Longitude (Category) column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['cat-longitude'] = 1;
			}
		}
		
		$updateLat = false;
		$errorMsg	= '';
		$convertDataNeeded['cat-latitude'] = 0;
		$updateLat = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "latitude", "varchar(20) NOT NULL default ''", "hits" );
		if (!$updateLat) {
			$msgSQL .= 'Error while updating Latitude (Category) column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['cat-latitude'] = 1;
			}
		}
		
		$updateUF = false;
		$errorMsg	= '';
		$convertDataNeeded['cat-userfolder'] = 0;
		$updateUF = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "userfolder", "text", "hits" );
		if (!$updateUF) {
			$msgSQL .= 'Error while updating Userfolder column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['cat-userfolder'] = 1;
			}
		}
		
		$updateDuid = false;
		$errorMsg	= '';
		$convertDataNeeded['cat-deleteuserid'] = 0;
		$updateDuid = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "deleteuserid", "text", "hits" );
		if (!$updateDuid) {
			$msgSQL .= 'Error while updating Deleteuserid column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['cat-deleteuserid'] = 1;
			}
		}
		
		$updateUuid = false;
		$errorMsg	= '';
		$convertDataNeeded['cat-uploaduserid'] = 0;
		$updateUuid = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "uploaduserid", "text", "hits" );
		if (!$updateUuid) {
			$msgSQL .= 'Error while updating Uploaduserid column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['cat-uploaduserid'] = 1;
			}
		}
		
		$updateAuid = false;
		$errorMsg	= '';
		$convertDataNeeded['cat-accessuserid'] = 0;
		$updateAuid = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "accessuserid", "text", "hits" );
		if (!$updateAuid) {
			$msgSQL .= 'Error while updating Accessuserid column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['cat-accessuserid'] = 1;
			}
		}
		
		// ------------------------------------------
		// New COLUMNS IMAGES
		// ------------------------------------------
		$updateGeoT = false;
		$errorMsg	= '';
		$convertDataNeeded['img-geotitle'] = 0;
		$updateGeoT = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "geotitle", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateGeoT) {
			$msgSQL .= 'Error while updating Geotitle column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['img-geotitle'] = 1;
			}
		}
		
		$updateZoom = false;
		$errorMsg	= '';
		$convertDataNeeded['img-zoom'] = 0;
		$updateZoom = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "zoom", "int(3) NOT NULL default '0'", "hits" );
		if (!$updateZoom) {
			$msgSQL .= 'Error while updating Zoom column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['img-zoom'] = 1;
			}
		}
		
		$updateLng = false;
		$errorMsg	= '';
		$convertDataNeeded['img-longitude'] = 0;
		$updateLng = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "longitude", "varchar(20) NOT NULL default ''", "hits" );
		if (!$updateLng) {
			$msgSQL .= 'Error while updating Longitude column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['img-longitude'] = 1;
			}
		}
		
		$updateLat = false;
		$errorMsg	= '';
		$convertDataNeeded['img-latitude'] = 0;
		$updateLat = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "latitude", "varchar(20) NOT NULL default ''", "hits" );
		if (!$updateLat) {
			$msgSQL .= 'Error while updating Latitude column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['img-latitude'] = 1;
			}
		}
		
		$updateVC = false;
		$errorMsg	= '';
		$convertDataNeeded['img-videocode'] = 0;
		$updateVC = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "videocode", "text", "hits" );
		if (!$updateVC) {
			$msgSQL .= 'Error while updating Video Code column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['img-videocode'] = 1;
			}
		}
		
		$updateVMPiD = false;
		$errorMsg	= '';
		$convertDataNeeded['img-vmproductid'] = 0;
		$updateVMPiD = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "vmproductid", "int(11) NOT NULL default '0'", "hits" );
		if (!$updateVMPiD) {
			$msgSQL .= 'Error while updating VirtueMart Product ID column';
		}else {
			if ($errorMsg == 'notexistcreated') {
				$convertDataNeeded['img-vmproductid'] = 1;
			}
		}
		
		
		
		// END UPGRADE DATA SCRIPT NEEDS TO BE RUN - - - 
		
		// ------------------------------------------
		// PHOCAGALLERY IMG VOTES
		// ------------------------------------------		
		$query =' CREATE TABLE IF NOT EXISTS '.$db->nameQuote('#__phocagallery_img_votes').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('imgid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('date').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('rating').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		// ------------------------------------------
		// PHOCAGALLERY IMG VOTES STATISTICS
		// ------------------------------------------
		$query =' CREATE TABLE IF NOT EXISTS '.$db->nameQuote('#__phocagallery_img_votes_statistics').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('imgid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('count').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('average').' float(8,6) NOT NULL default \'0\','."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		
		
		// UPGRADE PHOCA GALLERY 2.6 VERSION		
		// ------------------------------------------
		// PHOCAGALLERY USER (2.6.0)
		// ------------------------------------------
		$query =' CREATE TABLE IF NOT EXISTS '.$db->nameQuote('#__phocagallery_user').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('avatar').' varchar(40) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('approved').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').'),'."\n";
		$query.=' KEY '.$db->nameQuote('userid').' ('.$db->nameQuote('userid').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
	
		// UPGRADE DATA SCRIPT NEEDS TO BE RUN
		$updateIOS = false;
		$errorMsg	= '';
		$updateIOS = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "imgorigsize", "int(11) NOT NULL default '0'", "hits" );
		if (!$updateIOS) {
			$msgSQL .= 'Error while updating Image Original Size column';
		}
		
		$updateOID = false;
		$errorMsg	= '';
		$updateOID = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "owner_id", "int(11) NOT NULL default '0'", "parent_id" );
		if (!$updateOID) {
			$msgSQL .= 'Error while updating Owner ID column';
		}
		
		$updateIA = false;
		$errorMsg	= '';
		$updateIA = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "approved", "tinyint(1) NOT NULL default '0'", "published" );
		if (!$updateIA) {
			$msgSQL .= 'Error while updating Approved(Categories) column';
		}
		
		$updateCA = false;
		$errorMsg	= '';
		$updateCA = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "approved", "tinyint(1) NOT NULL default '0'", "published" );
		if (!$updateCA) {
			$msgSQL .= 'Error while updating Approved(Images) column';
		}
		
		
		$updateextID = false;
		$errorMsg	= '';
		$updateextID = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "extid", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextID) {
			$msgSQL .= 'Error while updating External Image Id column';
		}
		$updateextL = false;
		$errorMsg	= '';
		$updateextL = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "extl", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextL) {
			$msgSQL .= 'Error while updating External Large Image column';
		}
		$updateextM = false;
		$errorMsg	= '';
		$updateextM = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "extm", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextM) {
			$msgSQL .= 'Error while updating External Medium Image column';
		}
		$updateextS = false;
		$errorMsg	= '';
		$updateextS = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "exts", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextS) {
			$msgSQL .= 'Error while updating External Small Image column';
		}
		$updateextW = false;
		$errorMsg	= '';
		$updateextW = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "extw", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextW) {
			$msgSQL .= 'Error while updating External Image Width column';
		}
		$updateextH = false;
		$errorMsg	= '';
		$updateextH = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "exth", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextH) {
			$msgSQL .= 'Error while updating External Image Height column';
		}
		
		$updateextO = false;
		$errorMsg	= '';
		$updateextO = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "exto", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextO) {
			$msgSQL .= 'Error while updating External Image Original column';
		}
		
		$updateextIDC = false;
		$errorMsg	= '';
		$updateextIDC = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "extid", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextIDC) {
			$msgSQL .= 'Error while updating External Id (Category) column';
		}
		
		$updateextA = false;
		$errorMsg	= '';
		$updateextA = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "exta", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextA) {
			$msgSQL .= 'Error while updating External Image Album column';
		}
		$updateextU = false;
		$errorMsg	= '';
		$updateextU = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "extu", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextU) {
			$msgSQL .= 'Error while updating External Image User column';
		}
		
		
		// Upgrade 2.6.2
		$updateMK = false;
		$errorMsg	= '';
		$updateMK = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "metakey", "text", "params" );
		if (!$updateMK) {
			$msgSQL .= 'Error while updating Metakey column';
		}
		$updateMKC = false;
		$errorMsg	= '';
		$updateMKC = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "metakey", "text", "params" );
		if (!$updateMKC) {
			$msgSQL .= 'Error while updating Metakey column (Categories)';
		}
		$updateMD = false;
		$errorMsg	= '';
		$updateMD = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery", "metadesc", "text", "params" );
		if (!$updateMD) {
			$msgSQL .= 'Error while updating MetaDescription column';
		}
		$updateMDC = false;
		$errorMsg	= '';
		$updateMDC = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "metadesc", "text", "params" );
		if (!$updateMDC) {
			$msgSQL .= 'Error while updating MetaDescription column (Categories)';
		}
		
		
		
		
		// Check if there is obsolete table and try to move the author ids to owner ids
		$query=' SELECT * FROM '.$db->nameQuote('#__phocagallery_user_category').' LIMIT 1;'."\n";
		$db->setQuery( $query );
		$result = $db->loadResult();
		
		if ($db->getErrorNum()) {
			//$msgSQL .= $db->getErrorMsg(). '<br />';
		} else {
			$query=' SELECT catid, userid FROM '.$db->nameQuote('#__phocagallery_user_category').';'."\n";
			$db->setQuery( $query );
			$userIdInCatid = $db->loadObjectList();
			if (isset($userIdInCatid) && count($userIdInCatid) > 0) {
				foreach($userIdInCatid as $keyIIC => $valueIIC){
				
					if (isset($valueIIC->catid)) {
						$query=' UPDATE '.$db->nameQuote('#__phocagallery_categories')
						. ' SET '.$db->nameQuote('owner_id').' = '.(int)$valueIIC->userid
						. ' WHERE id = '.(int)$valueIIC->catid . ';'."\n";
						$db->setQuery( $query );
						
						
						if (!$db->query()) {
							$msgSQL .= $db->getErrorMsg(). '<br />';
						}
					}
				}
			}
			
		
			// Rename this table to obsolete, so in the next upgrade this converting (userids to ownerids) will be not used anymore
			$query=' RENAME TABLE '.$db->nameQuote('#__phocagallery_user_category').' TO '.$db->nameQuote('#__phocagallery_user_category_tmp').';'."\n";
			$db->setQuery( $query );
			if (!$db->query()) {
				$msgSQL .= $db->getErrorMsg(). '<br />';
			}
		}
		
		// - - -
		
		// ------------------------------------------
		// PHOCAGALLERY IMAGE COMMENTS
		// ------------------------------------------
		$query =' CREATE TABLE IF NOT EXISTS '.$db->nameQuote('#__phocagallery_img_comments').' ('."\n";
		$query.=' '.$db->nameQuote('id').' int(11) NOT NULL auto_increment,'."\n";
		$query.=' '.$db->nameQuote('imgid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('userid').' int(11) NOT NULL default 0,'."\n";
		$query.=' '.$db->nameQuote('date').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('title').' varchar(255) NOT NULL default \'\','."\n";
		$query.=' '.$db->nameQuote('comment').' text,'."\n";
		$query.=' '.$db->nameQuote('published').' tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out').' int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('checked_out_time').' datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' '.$db->nameQuote('ordering').' int(11) NOT NULL default \'0\','."\n";
		$query.=' '.$db->nameQuote('params').' text,'."\n";
		$query.=' PRIMARY KEY  ('.$db->nameQuote('id').')'."\n";
		$query.=') TYPE=MyISAM CHARACTER SET '.$db->nameQuote('utf8').';'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		

		
		// END 2.6
		
		// UPDATE 2.7.1
		$updateextAuth = false;
		$errorMsg	= '';
		$updateextAuth = $this->AddColumnIfNotExists( $errorMsg, "#__phocagallery_categories", "extauth", "varchar(255) NOT NULL default ''", "hits" );
		if (!$updateextAuth) {
			$msgSQL .= 'Error while updating External Image Album - Auth column';
		}
		
		//END 2.7.1
		
		
		// CHECK TABLES
		$query =' SELECT * FROM '.$db->nameQuote('#__phocagallery').' LIMIT 1;';
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		$query=' SELECT * FROM '.$db->nameQuote('#__phocagallery_categories').' LIMIT 1;'."\n";
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		$query=' SELECT * FROM '.$db->nameQuote('#__phocagallery_votes').' LIMIT 1;'."\n";
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		$query=' SELECT * FROM '.$db->nameQuote('#__phocagallery_comments').' LIMIT 1;'."\n";
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		$query=' SELECT * FROM '.$db->nameQuote('#__phocagallery_votes_statistics').' LIMIT 1;'."\n";
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
	/*	$query=' SELECT * FROM '.$db->nameQuote('#__phocagallery_user_category').' LIMIT 1;'."\n";
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
	*/	
		$query=' SELECT * FROM '.$db->nameQuote('#__phocagallery_img_votes').' LIMIT 1;'."\n";
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		$query=' SELECT * FROM '.$db->nameQuote('#__phocagallery_img_votes_statistics').' LIMIT 1;'."\n";
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}

		$query=' SELECT * FROM '.$db->nameQuote('#__phocagallery_img_comments').' LIMIT 1;'."\n";
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		$query=' SELECT * FROM '.$db->nameQuote('#__phocagallery_user').' LIMIT 1;'."\n";
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		// Error
		if ($msgSQL !='') {
			$msgError .= '<br />' . $msgSQL;
		}
		/*if ($msgFile !='') {
			$msgError .= '<br />' . $msgFile;
		}*/	
		// End Message
		if ($msgError !='') {
			$msg = JText::_( 'Phoca Gallery not successfully upgraded' ) . ': ' . $msgError;
		} else {
			$msg = JText::_( 'Phoca Gallery successfully upgraded' );
		}
		
		$linkUpgrade = '';
		foreach ($convertDataNeeded as $key => $value) {
			if ($value == 1) {
				$linkUpgrade .= '&'.$key.'=1';
			}
		}
		if ($linkUpgrade != '') {
			$link = 'index.php?option=com_phocagallery&view=phocagalleryupgrade'.$linkUpgrade;
		} else {
			$link = 'index.php?option=com_phocagallery';
		}
		$this->setRedirect($link, $msg);
	}
	
	
	function AddColumnIfNotExists(&$errorMsg, $table, $column, $attributes = "INT( 11 ) NOT NULL DEFAULT '0'", $after = '' ) {
		
		global $mainframe;
		$db				=& JFactory::getDBO();
		$columnExists 	= false;

		$query = 'SHOW COLUMNS FROM '.$table;
		$db->setQuery( $query );
		if (!$result = $db->query()){return false;}
		$columnData = $db->loadObjectList();
		
		foreach ($columnData as $valueColumn) {
			if ($valueColumn->Field == $column) {
				$columnExists = true;
				break;
			}
		}
		
		if (!$columnExists) {
			if ($after != '') {
				$query = 'ALTER TABLE '.$db->nameQuote($table).' ADD '.$db->nameQuote($column).' '.$attributes.' AFTER '.$db->nameQuote($after).';';
			} else {
				$query = 'ALTER TABLE '.$db->nameQuote($table).' ADD '.$db->nameQuote($column).' '.$attributes.';';
			}
			$db->setQuery( $query );
			if (!$result = $db->query()){return false;}
			$errorMsg = 'notexistcreated';
		}
		
		return true;
	}
}
// utf-8 test: ä,ö,ü,ř,ž
?>