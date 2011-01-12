<?php
/**
 * @version		$Id: licenses.html.php 1372 2010-06-11 14:22:50Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMLicenses
{
    function editLicense($option, &$row)
    {
        JFilterOutput::objectHTMLSafe($row);
        ?>

        <script language="javascript" type="text/javascript">
            function submitbutton(pressbutton) {
				  var form = document.adminForm;
				  if (pressbutton == 'cancel') {
					submitform( pressbutton );
					return;
				  }


				  <?php
				   	jimport('joomla.html.editor');
					$editor = &JFactory::getEditor();
				  	echo $editor->save('license');
				  ?>
				  submitform( pressbutton );

			}
        </script>
		<form action="index.php" method="post" name="adminForm" id="adminForm">
		<?php
        $tmp = ($row->id ? _DML_EDIT : _DML_ADD) .' '._DML_LICENSES;
        dmHTML::adminHeading( $tmp, 'licenses' )
        ?>

        <fieldset class="adminform">
    	<legend><?php echo _DML_LICENSE ?></legend>
    	<table class="admintable">
				<tr>
					<td class="key"><?php echo _DML_NAME;?>:</td>
					<td>
						<input class="inputbox" type="text" name="name" size="50" maxlength="100" value="<?php echo $row->name;?>" />
					</td>
				</tr>
				<tr>
					<td class="key"><?php echo _DML_LICENSE_TEXT;?>:</td>
				<td>
					<?php
        			DOCMAN_Compat::editorArea('editor1', $row->license, 'license', '700', '600', '60', '30');
        			?>
				</td>
			  </tr>


	    </table>
		</fieldset>
		<input type="hidden" name="id" value="<?php echo $row->id;?>" />
		<input type="hidden" name="option" value="com_docman" />
		<input type="hidden" name="section" value="licenses" />
		<input type="hidden" name="task" value="" />
        <?php echo DOCMAN_token::render();?>
		</form>

    <?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }

    function showLicenses($option, $rows, $search, $pageNav)
    {
        $database = JFactory::getDBO();
        $my       = JFactory::getUser();

        ?>
		<form action="index.php" method="post" name="adminForm">
        <?php dmHTML::adminHeading( _DML_LICENSES, 'licenses' )?>
        <div class="dm_filters">
            <?php echo _DML_FILTER_NAME;?>
            <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
        </div>

		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
            <thead>
			<tr>
				<th width="2%" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows);?>);" /></th>
				<th class="title" width="30%" nowrap="nowrap"><div align="left"><?php echo _DML_NAME?></div></th>
                <th class="title" width="68%"><div align="left"><?php echo _DML_LICENSE_TEXT?></div></th>
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
    			<td align="left">
    				<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
    				<?php echo $row->name;?>
    				</a>
    			</td>
                <td align="left">
                    <?php echo $row->license;?>
                </td>
    			</tr>
    				<?php
                $k = 1 - $k;
            }

            ?>
            </tbody>
		  </table>


		  <input type="hidden" name="option" value="com_docman" />
		  <input type="hidden" name="section" value="licenses" />
		  <input type="hidden" name="task" value="licenses" />
		  <input type="hidden" name="boxchecked" value="0" />
          <?php echo DOCMAN_token::render();?>
		</form>
	  <?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }
}