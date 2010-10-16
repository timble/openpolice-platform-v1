<?php
/**
 * @version		$Id: cleardata.html.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMClear
{
    function showClearData( $rows )
    {
    	?><form action="index.php" method="post" name="adminForm">
        <?php dmHTML::adminHeading( _DML_CLEARDATA, 'cleardata' )?>

        <table class="adminlist">
          <thead>
          <tr>
            <th width="20" align="left">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows);?>);" />
            </th>
            <th width="98%" align="left">
                <?php echo _DML_CLEARDATA_ITEM;?>
            </th>
          </tr>
          </thead>
          <tbody>
          <?php
          $k = 0;
          foreach( $rows as $i => $row ){?>
            <tr class="row<?php echo $k;?>">
                <td width="20">
                    <?php echo JHTML::_('grid.id', $i, $row->name);?>
                </td>
                <td>
                    <?php echo $row->friendlyname; ?>
                </td>
            </tr><?php
            $k = 1-$k;
          };?>
          </tbody>
        </table>
        <input type="hidden" name="option" value="com_docman" />
        <input type="hidden" name="section" value="cleardata" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <?php echo DOCMAN_token::render();?>
        </form>
        <?php include_once(JPATH_ROOT.DS.'components'.DS.'com_docman'.DS.'footer.php');

    }
}
