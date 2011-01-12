<?php
/**
 * @version		$Id:articles.php 777 2008-10-19 22:18:08Z mathias $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Xmlrpc
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Article Xmlrpc Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Xmlrpc
 */
class NookuXmlrpcArticles extends KEventHandler 
{
	public function describe() 
	{
		global $xmlrpcI4, $xmlrpcInt, $xmlrpcBoolean, $xmlrpcDouble, $xmlrpcString, $xmlrpcDateTime, $xmlrpcBase64, $xmlrpcArray, $xmlrpcStruct, $xmlrpcValue;
		$services = array();

		$services['nooku.articles.delete'] = array(
			'function'	=> 'NookuXmlrpcArticles::delete',
			'signature'	=> array(array($xmlrpcBoolean, $xmlrpcInt))
		);

		$services['nooku.articles.retrieve'] = array(
			'function' 	=> 'NookuXmlrpcArticles::retrieve',
			'signature'	=> array(array($xmlrpcArray))
		);

		$services['nooku.articles.update'] = array(
			'function' 	=> 'NookuXmlrpcArticles::update',
			'signature' 	=> array(array($xmlrpcInt, $xmlrpcInt, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcInt, $xmlrpcBoolean, $xmlrpcInt, $xmlrpcInt, $xmlrpcInt, $xmlrpcInt, $xmlrpcDateTime, $xmlrpcDateTime, $xmlrpcDateTime))
		);

		$services['nooku.articles.create'] = array(
			'function' 	=> 'NookuXmlrpcArticles::create',
			'signature' 	=> array(array($xmlrpcInt, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcInt, $xmlrpcBoolean, $xmlrpcInt, $xmlrpcInt, $xmlrpcInt, $xmlrpcInt, $xmlrpcDateTime, $xmlrpcDateTime, $xmlrpcDateTime))
		);

		return $services;
	}

	/**
	 * Returns array of entries from given categories
	 *
	 * @param xmlrpcmsg $msg
	 * @return xmlrpcresp
	 */
	public function retrieve() 
	{
		$db =& JFactory::getDBO();

		$query =  "SELECT c.id AS id, c.sectionid AS sectionid, c.catid AS catid, c.state AS state, c.created_by_alias AS created_by_alias, "
				. "\nc.created_by AS created_by, UNIX_TIMESTAMP(c.created) AS created, UNIX_TIMESTAMP(c.publish_up) AS publish_up, c.version AS version, c.metakey AS metakey, c.metadesc AS metadesc, "
				. "\nUNIX_TIMESTAMP(c.publish_down) AS publish_down, c.access AS access, UNIX_TIMESTAMP(c.modified) AS modified, c.title AS title, c.attribs AS attribs, "
				. "\nc.title_alias AS title_alias, c.introtext AS introtext, c.fulltext AS `fulltext`, c.hits AS hits, f.content_id as frontpage "
				. "\nFROM #__content AS c "
				. "\nLEFT OUTER JOIN #__content_frontpage AS f on c.id = f.content_id "
				. "\nWHERE state != -2 "
				. "\nORDER BY title ASC";

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		$structArray = array();
		foreach ($rows as $row) 
		{
			if (strlen($row->fulltext) > 0) {
				$content = $row->introtext . "<hr id=\"system-readmore\" />" . $row->fulltext;
			} else {
				$content = $row->introtext;
			}

			$structArray[] = array(
			    'id'      			=> (int) $row->id,
			    'sectionid'   		=> (int) $row->sectionid,
			    'catid' 			=> (int) $row->catid,
			    'access'			=> (int) $row->access,
			    'state' 			=> (int) $row->state,
			    'created_by'		=> (int) $row->created_by,
			    'created_by_alias'	=> $row->created_by_alias,
			    'created'      		=> iso8601_encode($row->created),
			    'publish_up'   		=> iso8601_encode($row->publish_up),
			    'publish_down' 		=> iso8601_encode($row->publish_down),
			    'modified' 			=> iso8601_encode($row->modified),
			    'title'				=> $row->title,
			    'name'      		=> $row->title_alias,
			    'text'				=> $content,
			    'description'   	=> "Content Item " . $row->id,
			    'metakey'			=> $row->metakey,
			    'metadesc'			=> $row->metadesc,
			    'hits'				=> (int) $row->hits,
			    'revised'			=> (int) $row->version,
			    'attribs'			=> $row->attribs,
			    'frontpage'			=> (bool) $row->frontpage);
		}

		return $structArray;
	}

	/**
	 * Removes entry with given id. Returns true on success.
	 *
	 * @param xmlrpcmsg $msg
	 * @return xmlrpcresp
	 */
	public function delete($id) 
	{
		global $xmlrpcBoolean;
		$db =& JFactory::getDBO();

		$query = "UPDATE #__content " .
			"\nSET `state` = '-2' " .
			"\nWHERE `id` = '" . $id . "'";

		$db->setQuery($query);

		return $db->query();
	}

	/**
	 * Updates entry with given id. Returns true on success.
	 *
	 * @param xmlrpcmsg $msg
	 * @return xmlrpcresp
	 */
	public function update($id, $title, $titleAlias, $authorAlias, $text, $metakey, $metadesc, $state, $frontpage, $access, $sectionid, $catid, $authorId, $datePublished, $dateUnpublished, $dateCreated)
	{
		global $xmlrpcerruser;
		$db =& JFactory::getDBO();

		$tagPos = JString::strpos($text, '<hr id="system-readmore" />');

		if ($tagPos === false) {
			$introtext = $text;
			$fulltext = null;
		} else {
			$introtext = JString::substr($text, 0, $tagPos);
			$fulltext = JString::substr($text, $tagPos +10);
		}

		$query = "SELECT `version` FROM #__content WHERE `id` = '" . $id . "'";
		$db->setQuery($query);

		if ($db->query()) {
			$version = $db->loadResult();
			$version++;
		}

		$query = "UPDATE #__content " .
				"\nSET `title` = '" . $db->getEscaped($title) ."', " .
				"\n`title_alias` = '" . $db->getEscaped($titleAlias) ."', " .
				"\n`introtext` = '" . $db->getEscaped($introtext) . "', " .
				"\n`fulltext` = '" . $db->getEscaped($fulltext) . "', " .
				"\n`state` = '" . $state . "', " .
				"\n`access` = '" . $access . "', " .
				"\n`created_by_alias` = '" . $db->getEscaped($authorAlias) . "', " .
				"\n`created_by` = '" . $authorId . "', " .
				"\n`modified_by` = '" . $authorId . "', " .
				"\n`modified` = NOW(), " .
				"\n`version` = '" . $version . "', " .
				"\n`sectionid` = '" . $sectionid . "', " .
				"\n`catid` = '" . $catid . "', " .
				"\n`publish_up` = '" . self::convertDate($datePublished) . "', " .
				"\n`created` = '" . self::convertDate($dateCreated) . "', " .
				"\n`metakey` = '" . $db->getEscaped($metakey) . "', " .
				"\n`metadesc` = '" . $db->getEscaped($metadesc) . "', " .
				"\n`publish_down` = '" . self::convertDate($dateUnpublished) . "' " .
				"\nWHERE `id` = '" . $id . "'";

		$db->setQuery($query);
		if (!$db->query()) {
			return new xmlrpcresp(0, $xmlrpcerruser+1, "DB Error: " . $db->getErrorMsg());
		}

		$id = $db->insertid();

		if ($frontpage) {
			$query = "SELECT * FROM #__content_frontpage WHERE `content_id` = '" . $id . "'";
			$db->setQuery($query);
			$db->query();

			if ($db->getNumRows() == 0) {
				$query = "INSERT INTO #__content_frontpage (`content_id`) VALUES ('" . $id . "')";
				$db->setQuery($query);
				if (!$db->query()) {
					return new xmlrpcresp(0, $xmlrpcerruser+1, "DB Error: " . $db->getErrorMsg());
				}
			}
		} else {
			$query = "DELETE FROM #__content_frontpage WHERE `content_id` = '" . $id . "'";
			$db->setQuery($query);
			if (!$db->query()) {
				return new xmlrpcresp(0, $xmlrpcerruser+1, "DB Error: " . $db->getErrorMsg());
			}
		}

		return $id;
	}


	public function create($title, $titleAlias, $authorAlias, $body, $metakey, $metadesc, $state, $frontpage, $access, $sectionid, $catid, $authorId, $datePublished, $dateUnpublished, $dateCreated)
	{
		global $xmlrpcerruser;
		$db =& JFactory::getDBO();

		$body = str_replace("'", "\'", $body);

		$query = "INSERT INTO #__content " .
				"(`title`, `title_alias`, `introtext`, `version`, `created`, `created_by`, `created_by_alias`, `state`, `access`, `sectionid`, `catid`, `publish_up`, `publish_down`, `metakey`, `metadesc`) " .
				"VALUES ('" . 	$title . "', '" . $titleAlias . "', '" . $body . "', '1', '" . self::convertDate($dateCreated) . "', '" . $authorId . "', '" . $authorAlias . "', '" . $state . "', '" . $access . "', " .
				"'" . $sectionid . "', '" . $catid . "', '" . self::convertDate($datePublished) . "', '" . self::convertDate($dateUnpublished) . "', '" . $metakey . "', '" . $metadesc . "')";

		$db->setQuery($query);
		if (!$db->query()) {
			return new xmlrpcresp(0, $xmlrpcerruser+1, "DB Error: " . $db->getErrorMsg());
		}

		$id = $db->insertid();

		if ($frontpage == true) {
			$query = "INSERT INTO #__content_frontpage (`content_id`) VALUES ('" . $id . "')";
			$db->setQuery($query);
			if (!$db->query()) {
				return new xmlrpcresp(0, $xmlrpcerruser+1, "DB Error: " . $db->getErrorMsg());
			}
		}

		return $id;
	}

	public function getDate($date) 
	{
		global $xmlrpcerruser;
		return new xmlrpcresp(0, $xmlrpcerruser+1, "DB Error: " . var_dump($date));
	}

	public function convertDate($unixDate) 
	{
		jimport('joomla.utilities.date');
		$date = new JDate(iso8601_decode($unixDate));

		if (date('Y', $date->toUnix()) == 1970 && date('m', $date->toUnix()) == 1 && date('d', $date->toUnix()) == 1) {
			return '0000-00-00 00:00:00';
		} else {
			return $date->toMySQL();
		}
	}
}