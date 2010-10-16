<?php
/**
 * @version		$Id: groups.html.php 1372 2010-06-11 14:22:50Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

require_once($_DOCMAN->getPath('classes', 'file'));

class HTML_DMGroups
{
    function showGroups($option, $rows, $search, $pageNav)
    {
        $database = JFactory::getDBO();
        $my       = JFactory::getUser();

        ?>
        <form action="index.php" method="post" name="adminForm">
        <?php dmHTML::adminHeading( _DML_TITLE_GROUPS, 'groups' )?>
        <div class="dm_filters">
            <?php echo _DML_FILTER_NAME;?>:
            <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
        </div>
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
            <thead>
			<tr>
				<th width="2%" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows);?>);" /></th>
				<th class="title" width="30%"><div align="center"><?php echo _DML_GROUP;?></div></th>
				<th class="title" width="65%"><div align="center"><?php echo _DML_DESCRIPTION;?></div></th>
				<th class="title" width="5%"><div align="center"><?php echo _DML_EMAIL;?></div></th>
			</tr>
            </thead>
            <tfoot><tr><td colspan="11"><?php echo $pageNav->getListFooter();?></td></tr></tfoot>
            <tbody>
			<?php
            $k = 0;
            for ($i = 0, $n = count($rows);$i < $n;$i++) {
                $row = &$rows[$i]; ?>
                <tr class="row<?php echo $k?>">
                <td width="20">
    				<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->groups_id;?>" onclick="isChecked(this.checked);" />
    			</td>
    			<td align="center">
    				<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
    			<?php echo $row->groups_name;?>
    				</a>
    			</td>
    			<td width="60%" align="center"><?php echo $row->groups_description;?></td>
    			<td width="10%" align="center"><a href="index.php?option=com_docman&section=groups&task=emailgroup&gid=<?php echo $row->groups_id;?>"><img src="<?php echo JURI::root(true)?>/administrator/components/com_docman/images/dm_sendemail_16.png" border=0></a></td>
    			</tr>
    			  <?php
                $k = 1 - $k;
            }
        ?>
        </tbody>
		</table>

	  <input type="hidden" name="option" value="com_docman" />
      <input type="hidden" name="section" value="groups" />
	  <input type="hidden" name="task" value="" />
	  <input type="hidden" name="boxchecked" value="0" />
      <?php echo DOCMAN_token::render();?>
	</form>

  <?php require_once (JPATH_SITE. DS.'components'.DS.'com_docman'.DS.'footer.php');
    }

    function editGroup($option, &$row, $usersList, $toAddUsersList)
    {
        JFilterOutput::objectHTMLSafe($row);
        JHTML::_('behavior.tooltip');

        ?>
		<script>
			function submitbutton(pressbutton) {

			  var form = document.adminForm;

			  if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			  }

			  // do field validation

			  if (form.groups_name.value == ""){
				alert( "<?php echo _DML_ENTRY_NAME;?>" );
			  } else {
				allSelected(document.adminForm['users_selected[]']);
				submitform( pressbutton );
			  }
			}
		</script>

		<script>
			// moves elements from one select box to another one
			function moveOptions(from,to) {
			  // Move them over
			  for (var i=0; i<from.options.length; i++) {
				var o = from.options[i];
				if (o.selected) {
				  to.options[to.options.length] = new Option( o.text, o.value, false, false);
				}
			  }
			  // Delete them from original
			  for (var i=(from.options.length-1); i>=0; i--) {
				var o = from.options[i];
				if (o.selected) {
				  from.options[i] = null;
				}
			  }
			  from.selectedIndex = -1;
			  to.selectedIndex = -1;
			}

			function allSelected(element) {

			   for (var i=0; i<element.options.length; i++) {
					var o = element.options[i];
					o.selected = true;

				}
			 }
		</script>

		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<script language="Javascript" src="<?php echo JURI::root(true);?>/includes/js/overlib_mini.js"></script>

		<?php $tmp = ($row->groups_id ? _DML_EDIT : _DML_ADD).' '._DML_GROUP;
        dmHTML::adminHeading( $tmp, 'groups' )
        ?>
        <form action="index.php" method="post" name="adminForm" id="adminForm">

            <div class="col width-50">
			<fieldset class="adminform">
			<legend><?php echo _DML_GROUP?></legend>
			<table class="admintable">
				<tr>
					<td class="key"><?php echo _DML_GROUP;?>:</td>
					<td>
                        <input class="inputbox" type="text" name="groups_name" size="40" maxlength="100" value="<?php echo htmlspecialchars($row->groups_name, ENT_QUOTES);?>" />
					</td>
				</tr>
				<tr>
					<td class="key"><?php echo _DML_DESCRIPTION;?>:</td>
					<td valign="top">
						<textarea name="groups_description" cols="36" rows="20"><?php echo htmlspecialchars($row->groups_description, ENT_QUOTES);?></textarea>
					</td>
				</tr>
    		</table>
    		</fieldset>
            </div>

            <div class="col width-50">
               <fieldset class="adminform">
				<legend><?php echo _DML_MEMBERS_IN_GROUP?></legend>
				<table class="admintable">
                    <tr>
                        <td class="key" width="40%" style="text-align:center;">
                            <label class="hasTip" title="<?php echo _DML_ADDING_USERS.'::'._DML_ADD_GROUP_TIP; ?>"><?php echo _DML_USERS_AVAILABLE;?></label>
                        </td>
                        <td width="20%">&nbsp;</td>
                        <td class="key" width="40%" style="text-align:center;"><?php echo _DML_MEMBERS_IN_GROUP;?></td>
                    </tr>
                    <tr>
                        <td width="40%"><?php echo $toAddUsersList;?></td>
                        <td width="20%">
                            <input style="width: 50px" type="button" name="Button" value="&gt;" onClick="moveOptions(document.adminForm.users_not_selected, document.adminForm['users_selected[]'])" />
                            <br /><br />
                            <input style="width: 50px" type="button" name="Button" value="&lt;" onClick="moveOptions(document.adminForm['users_selected[]'],document.adminForm.users_not_selected)" />
                            <br /><br />
                        </td>
                        <td width="40%"><?php echo $usersList;?></td>
                    </tr>
                </table>
                </fieldset>
            </div>

            <input type="hidden" name="groups_id" value="<?php echo $row->groups_id;?>" />
            <input type="hidden" name="option" value="com_docman" />
            <input type="hidden" name="section" value="groups" />
            <input type="hidden" name="task" value="" />
            <?php echo DOCMAN_token::render();?>
        </form><?php
        include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }

    function messageForm($group, $list)
    {
        ?>
        <form action="index.php" name="adminForm" method="POST">
        <?php dmHTML::adminHeading( _DML_EMAIL_GROUP, 'sendemail' )?>

        <table cellpadding="5" cellspacing="1" border="0" width="100%" class="adminform">
            <tr>
                <td width="150"><?php echo _DML_GROUP;?>:</td>
                <td width="85%"><?php echo $group->groups_name;?></td>
			</tr>
            <tr>
                <td width="150"><?php echo _DML_SUBJECT;?>:</td>
                <td width="85%"><input class="inputbox" type="text" name="mm_subject" value="" size="50"></td>
            </tr>
            <tr>
                <td width="150"><?php echo _DML_EMAIL_LEADIN;?>:</td>
                <td width="85%"><textarea cols="50" rows="2" name="mm_leadin" wrap="virtual"
					class="inputbox"><?php echo $list['leadin'];?></textarea></td>
			</tr>
            <tr>
                <td width="150" valign="top"><?php echo _DML_MESSAGE;?>:</td>
                <td width="85%"><textarea cols="50" rows="5" name="mm_message" wrap="virtual" class="inputbox"></textarea></td>
            </tr>
        </table>
        <!--<input type="submit" name="submit" value="<?php echo _DML_SEND_EMAIL;?>">-->
        <input type="hidden" name="option" value="com_docman" />
        <input type="hidden" name="section" value="groups" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="gid" value="<?php echo $group->groups_id;?>" />
        <?php echo DOCMAN_token::render();?>
        </form>
        <?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }
}