<?php
/**
 * @version		$Id: categories.html.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMCategories
{
    function show(&$rows, $myid, &$pageNav, &$lists, $type)
    {
        $my = JFactory::getUser();

        $section = "com_docman";
        $section_name = "DOCman";

        ?>
		<form action="index.php" method="post" name="adminForm">

        <?php dmHTML::adminHeading( _DML_CATS, 'categories' )?>


		<table class="adminlist">
        <thead>
		<tr>
			<th width="20">
			#
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows);?>);" />
			</th>
			<th class="title"><?php echo _DML_CATNAME;?></th>
			<th width="10%"><?php echo _DML_PUBLISHED;?></th>
			<th colspan="2"><?php echo _DML_REORDER;?></th>
			<th width="10%"><?php echo _DML_ACCESS;?></th>
			<th width="12%"><?php echo _DML_CATEGORY;?> ID</th>
			<th width="12%"># <?php echo _DML_DOCS;?></th>
			<th width="12%"><?php echo _DML_CHECKED_OUT;?></th>
		  </tr>
        </thead>
        <tfoot><tr><td colspan="11"><?php echo $pageNav->getListFooter();?></td></tr></tfoot>
        <tbody>
		<?php
        $k = 0;
        $i = 0;
        $n = count($rows);
        foreach ($rows as $row) {
            $img = $row->published ? 'tick.png' : 'publish_x.png';
            $task = $row->published ? 'unpublish' : 'publish';
            $alt = $row->published ? 'Published' : 'Unpublished';
            if (!$row->access) {
                $color_access = 'style="color: green;"';
                $task_access = 'accessregistered';
            } else if ($row->access == 1) {
                $color_access = 'style="color: red;"';
                $task_access = 'accessspecial';
            } else {
                $color_access = 'style="color: black;"';
                $task_access = 'accesspublic';
            }

            ?>
			<tr class="<?php echo "row$k";?>">
				<td width="20" align="right">
				<?php echo $pageNav->rowNumber($i);?>
				</td>
				<td width="20">
				<?php echo JHTML::_('grid.id', $i, $row->id, ($row->checked_out_contact_category && $row->checked_out_contact_category != $my->id));?>
				</td>
				<td width="35%">
				<?php
            if ($row->checked_out_contact_category && ($row->checked_out_contact_category != $my->id)) {

                ?>
					<?php echo $row->treename . ' ( ' . $row->title . ' )';?>
					&nbsp;[ <i><?php echo _DML_CHECKED_OUT?></i> ]
					<?php
            } else {

                ?>
					<a href="#edit" onClick="return listItemTask('cb<?php echo $i;?>','edit')">
					<?php echo $row->treename . ' ( ' . $row->title . ' )';?>
					</a>
					<?php
            }

            ?>
				</td>
				<td align="center">
				<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>"  border="0" alt="<?php echo $alt;?>" />
				</a>
				</td>
				<?php
            if ($section <> 'content') {

                ?>
					<td>
					<?php echo $pageNav->orderUpIcon($i);?>
					</td>
					<td>
					<?php echo $pageNav->orderDownIcon($i, $n);?>
					</td>
					<?php
            }

            ?>
				<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task_access;?>')" <?php echo $color_access;?>>
				<?php echo $row->groupname;?>
				</a>
				</td>
				<td align="center">
				<?php echo $row->id;?>
				</td>
				<td align="center">
				<?php echo $row->documents;?>
				</td>
				<td align="center">
				<?php echo $row->checked_out_contact_category ? $row->editor : "";?>
				</td>
				<?php
            $k = 1 - $k;

            ?>
			</tr>
			<?php
            $k = 1 - $k;
            $i++;
        }

        ?>
        </tbody>
		</table>


		<input type="hidden" name="option" value="com_docman" />
		<input type="hidden" name="section" value="categories" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="chosen" value="" />
		<input type="hidden" name="act" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="type" value="<?php echo $type;?>" />
        <?php echo DOCMAN_token::render();?>
		</form>
		<?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }

    /**
    * Writes the edit form for new and existing categories
    *
    * @param mosCategory $ The category object
    * @param string $
    * @param array $
    */
    function edit(&$row, $section, &$lists, $redirect)
    {
        if ($row->image == "") {
            $row->image = 'blank.png';
        }
        JFilterOutput::objectHTMLSafe($row, ENT_QUOTES, 'description');
		jimport('joomla.html.editor');
		$editor = &JFactory::getEditor();

        ?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton, section) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( form.name.value == "" || form.title.value == "") {
				alert('<?php echo _DML_CAT_MUST_SELECT_NAME;?>');
			} else {
				<?php echo $editor->save( 'description') ;?>
				submitform(pressbutton);
			}
		}
		</script>

		<form action="index.php" method="post" name="adminForm">

        <?php
        $tmp = ($row->id ? _DML_EDIT : _DML_ADD).' '._DML_CAT.' '.$row->name;
		dmHTML::adminHeading( $tmp, 'categories' )
        ?>
		<div class="col width-50">
			<fieldset class="adminform">
				<legend><?php echo _DML_CATDETAILS;?></legend>

				<table class="admintable">
				<tr>
					<td class="key"><label><?php echo _DML_CATTITLE;?>:</label></td>
					<td colspan="2">
						<input class="text_area" type="text" name="title" value="<?php echo $row->title;?>" size="50" maxlength="50" title="A short name to appear in menus" />
					</td>
				</tr>
				<tr>
					<td class="key"><?php echo _DML_CATNAME;?>:</td>
					<td colspan="2">
						<input class="text_area" type="text" name="name" value="<?php echo $row->name;?>" size="50" maxlength="255" title="<?php echo _DML_LONGNAME;?>" />
					</td>
				</tr>
				<tr>
					<td class="key"><?php echo _DML_PARENTITEM;?>:</td>
					<td><?php echo $lists['parent'];?></td>
				</tr>
				<tr>
					<td class="key"><?php echo _DML_IMAGE;?>:</td>
					<td><?php echo $lists['image'];?><br /><br />

						<script language="javascript" type="text/javascript">
						if (document.forms[0].image.options.value!=''){
						  jsimg='../images/stories/' + getSelectedValue( 'adminForm', 'image' );
						} else {
						  jsimg='../images/M_images/blank.png';
						}
						document.write('<img src=' + jsimg + ' name="imagelib" width="80" height="80" border="2" alt="<?php echo _DML_PREVIEW;?>" />');
						</script>
					</td>
				</tr>
				<tr>
					<td class="key"><?php echo _DML_IMAGEPOS;?>:</td>
					<td><?php echo $lists['image_position'];?></td>
				</tr>
				<tr>
					<td class="key"><?php echo _DML_ORDERING;?>:</td>
					<td><?php echo $lists['ordering'];?></td>
				</tr>
				<tr>
					<td class="key"><?php echo _DML_ACCESSLEVEL;?>:</td>
					<td><?php echo $lists['access'];?></td>
				</tr>
				<tr>
					<td class="key"><?php echo _DML_PUBLISHED;?>:</td>
					<td><?php echo $lists['published'];?></td>
				</tr>
				</table>
			</fieldset>
		</div>
		<div class="col width-50">
			<fieldset class="adminform">
				<legend><?php echo _DML_DESCRIPTION;?></legend>
				<?php
        		// parameters : areaname, content, hidden field, width, height, rows, cols
        		DOCMAN_Compat::editorArea('editor1', $row->description , 'description', '440', '282', '50', '5') ;
        		?>
			</fieldset>
		</div>
		<div style="clear: both;"></div>

		<input type="hidden" name="option" value="com_docman" />
		<input type="hidden" name="section" value="categories" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="oldtitle" value="<?php echo $row->title ;?>" />
		<input type="hidden" name="id" value="<?php echo $row->id;?>" />
		<input type="hidden" name="sectionid" value="com_docman" />
		<input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
        <?php echo DOCMAN_token::render();?>
		</form>
        <?php include_once(JPATH_ROOT.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }
}