<?php
/**
 * @version		$Id: logs.html.php 1372 2010-06-11 14:22:50Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMLogs
{
    function showLogs($option, $rows, $search, $pageNav)
    {
        $database = JFactory::getDBO();
        $my       = JFactory::getUser();

        ?>
		<form action="index.php" method="post" name="adminForm">
        <?php dmHTML::adminHeading( _DML_DOWNLOAD_LOGS, 'logs' )?>
			<div class="dm_filters">
                <?php echo _DML_FILTER;?>
				<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
            </div>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
            <thead>
				<tr>
					<th width="2%" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows);?>);" /></th>
					<th class="title" width="10%" nowrap="nowrap"><div align="center"><?php echo _DML_DATE;?></div></th>
					<th class="title" width="20%" nowrap="nowrap"><div align="center"><?php echo _DML_USER;?></div></th>
					<th class="title" width="20%" nowrap="nowrap"><div align="center"><?php echo _DML_IP;?></div></th>
					<th class="title" width="20%" nowrap="nowrap"><div align="center"><?php echo _DML_DOCUMENT;?></div></th>
					<th class="title" width="10%" nowrap="nowrap"><div align="center"><?php echo _DML_BROWSER;?></div></th>
					<th class="title" width="10%" nowrap="nowrap"><div align="center"><?php echo _DML_OS;?></div></th>
				</tr>
             </thead>

             <tfoot><tr><td colspan="11"><?php echo $pageNav->getListFooter();?></td></tr></tfoot>

             <tbody>

				<?php
        $k = 0;
        for ($i = 0, $n = count($rows);$i < $n;$i++) {
            $row = &$rows[$i];?>
            <tr class="row<?php echo $k?>">
            <td width="20">

			<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id;?>" onclick="isChecked(this.checked);" />
					</td>
					<td align="center">
						<?php echo $row->log_datetime;?>
					</td>
					<td align="center">
						<?php echo $row->user;?>
					</td>
					<td align="center">
						<a href="http://ws.arin.net/cgi-bin/whois.pl?queryinput=<?php echo $row->log_ip;?>" target="_blank"><?php echo $row->log_ip;?></a>
					</td>
					<td align="center">
						 <?php echo $row->dmname;?>
					</td>
					<td align="center">
						 <?php echo $row->log_browser;?>
					</td>
					<td align="center">
						 <?php echo $row->log_os;?>
					</td>
				</tr>
				<?php
            $k = 1 - $k;
        }

        ?>
        </tbody>
		</table>

		<input type="hidden" name="option" value="com_docman" />
		<input type="hidden" name="section" value="logs" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
        <?php echo DOCMAN_token::render();?>
		</form>

		<?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }
}