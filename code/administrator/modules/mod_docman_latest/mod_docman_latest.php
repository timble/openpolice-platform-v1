<?php
/**
 * @version		$Id: mod_docman_latest.php 954 2009-10-17 16:25:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

global $_DOCMAN;
$_DOCMAN->setType(_DM_TYPE_MODULE);
$_DOCMAN->loadLanguage('modules');
require_once($_DOCMAN->getPath('classes', 'utils'));

$query = "SELECT id, dmname, approved, published, catid, dmdate_published"
     . "\n FROM #__docman"
     . "\n ORDER BY dmdate_published DESC";
$limit = $params->get('limit', 10);
$database = JFactory::getDBO();
$database->setQuery( $query, 0, $limit );
$rows = $database->loadObjectList();

?>
<table class="adminlist cpanelmodule">
	<tr>
	    <th><?php echo _DML_MOD_LAST_TITLE;?></th>
        <th><?php echo _DML_MOD_DATE_ADDED;?></th>
	</tr><?php
    if (!count($rows)) echo '<tr><td>' . _DML_MOD_LAST_NODOCUMENTS . '</td></tr>';
    foreach ($rows as $row) {
        ?>
    	<tr>
    	    <td><a href="index.php?option=com_docman&amp;section=documents&task=edit&amp;cid[]=<?php echo $row->id ?>"><?php echo $row->dmname;?></a>
    	    <?php if ($row->approved == '0') echo "(not approved)";?>
    	    <?php if ($row->published == '0') echo "(not published)";?>
    	    </td>
    	    <td align="right"><?php echo $row->dmdate_published;?></td>
    	</tr><?php
    }?>
</table>