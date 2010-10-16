<?php
/**
 * @version		$Id: mod_docman_top.php 954 2009-10-17 16:25:28Z mathias $
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

$query = "SELECT * FROM #__docman "
        ."\n ORDER BY dmcounter DESC ";
$database = JFactory::getDBO();
$database->setQuery( $query, 0, $params->get('limit', 10));
$rows = $database->loadObjectList();
?>

<table class="adminlist cpanelmodule">
	<tr>
	    <th><?php echo _DML_MOD_MOST_TITLE;?></th>
        <th><?php echo _DML_MOD_MOST_HITS;?></th>
	</tr><?php
    if (!count($rows)) echo '<tr><td>' . _DML_MOD_MOST_NODOCUMENTS . '</tr></td>';
    foreach ($rows as $row) {
        ?>
    	<tr>
    	    <td><a href="#edit" onClick="submitcpform('<?php echo $row->id;?>', '<?php echo $row->id;?>')"><?php echo $row->dmname;?></a>
    	    </td>
    	    <td align="right"><?php echo $row->dmcounter;?></td>
    	</tr><?php
    }?>
</table>