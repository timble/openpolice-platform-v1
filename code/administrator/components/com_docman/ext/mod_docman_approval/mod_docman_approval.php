<?php
/**
 * @version		$Id: mod_docman_approval.php 954 2009-10-17 16:25:28Z mathias $
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
require_once($_DOCMAN->getPath('classes', 'token'));

$query = "SELECT id, dmname, catid, dmdate_published, dmlastupdateon, approved"
        ."\n FROM #__docman"
        ."\n WHERE approved = 0"
        ."\n ORDER BY dmlastupdateon DESC";
$database = JFactory::getDBO();
$database->setQuery( $query, 0, $params->get('limit', 10));
$rows = $database->loadObjectList();

?>
<table class="adminlist cpanelmodule">
    <tbody>
	<tr>
        <th align="center"><?php echo _DML_MOD_APPROVE;?></th>
        <th><?php echo _DML_MOD_UNAPPROVED_DOCUMENTS;?></th>
        <th><?php echo _DML_MOD_LAST_EDIT_DATE;?></th>
	</tr><?php
    if (!count($rows)) echo '<tr><td colspan="3">' . _DML_MOD_NO_UNAPPROVED_DOCUMENTS . '</td></tr>';
    foreach ($rows as $row) {
        ?>
    	<tr>
            <td width="5%" style="text-align:center">
                <a href="index.php?option=com_docman&amp;section=documents&amp;task=approve&cid[]=<?php echo $row->id?>&amp;<?php echo DOCMAN_Token::get();?>=1&amp;redirect=index.php%3Foption%3Dcom_docman">
                <img src="images/publish_r.png" border=0 alt="approve" />
                </a>
            </td>
            <td><a href="index.php?option=com_docman&amp;section=documents&task=edit&amp;cid[]=<?php echo $row->id ?>"><?php echo $row->dmname;?></a></td>
            <td align="right"><?php echo $row->dmlastupdateon;?></td>
    	</tr><?php
    }?>
    </tbody>
</table>