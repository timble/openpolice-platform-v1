<?php
/**
 * @version		$Id: documents.html.php 1372 2010-06-11 14:22:50Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMDocuments
{
    function showDocuments($rows, $lists, $search, $pageNav, $number_pending, $number_unpublished, $view_type = 1)
    {
        global $_DOCMAN;
        $database = JFactory::getDBO();
        $my       = JFactory::getUser();
        ?>

        <form action="index.php" method="post" name="adminForm">

        <?php dmHTML::adminHeading( _DML_DOCS, 'documents' )?>

        <div class="dm_filters">
            <?php echo _DML_FILTER;?>
            <input class="text_area" type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
            <?php echo $lists['catid'];?>

            <span class="small">
                <?php if ($number_pending > 0) {
                    echo " [$number_pending " . _DML_DOCS_NOT_APPROVED . "] ";
                }
                if ($number_unpublished > 0) {
                    echo " [$number_unpublished " . _DML_DOCS_NOT_PUBLISHED . "] ";
                }
                if ($number_unpublished < 1 && $number_pending < 1) {
                    echo " [" . _DML_NO_PENDING_DOCS . "] ";
                }
                ?>
            </span>
        </div>

        <table class="adminlist">
          <thead>
          <tr>
            <th width="2%" align="left" >
            <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows);?>);" />
            </th>
            <th width="15%" align="left">
            <a href="index.php?option=com_docman&section=documents&sort=name"><?php echo _DML_NAME;?></a>
            </th>
            <th width="15%" align="left" >
            <a href="index.php?option=com_docman&section=documents&sort=filename"><?php echo _DML_FILE;?></a>
            </th>
            <th width="15%" align="left">
            <a href="index.php?option=com_docman&section=documents&sort=catsubcat"><?php echo _DML_CATEGORY;?></a>
            </th>
            <th width="10%" align="center">
            <a href="index.php?option=com_docman&section=documents&sort=date"><?php echo _DML_DATE;?></a>
            </th>
            <th width="10%">
            <?php echo _DML_OWNER;?>
            </th>
            <th width="5%">
            <?php echo _DML_PUBLISHED;?>
            </th>
            <th width="5%">
            <?php echo _DML_APPROVED;?>
            </th>
            <th width="5%">
            <?php echo _DML_SIZE;?>
            </th>
            <th width="5%">
            <?php echo _DML_HITS;?>
            </th>
            <th width="5%" nowrap="nowrap">
            <?php echo _DML_CHECKED_OUT;?>
            </th>
          </tr>
          </thead>

          <tfoot><tr><td colspan="11"><?php echo $pageNav->getListFooter();?></td></tr></tfoot>

          <tbody>
          <?php
        $k = 0;
        for ($i = 0, $n = count($rows);$i < $n;$i++) {
            $row = &$rows[$i];
            $task = $row->published ? 'unpublish' : 'publish';
            $img = $row->published ? 'publish_g.png' : 'publish_x.png';
            $alt = $row->published ? _DML_PUBLISHED : _DML_UNPUBLISH ;

            $file = new DOCMAN_File($row->dmfilename, $_DOCMAN->getCfg('dmpath'));

            ?><tr class="row<?php echo $k;?>">
                <td width="20">
				<?php echo JHTML::_('grid.id', $i, $row->id, ($row->checked_out && $row->checked_out != $my->id));?>
				</td>
				<td width="15%">
			<?php
            if ($row->checked_out && ($row->checked_out != $my->id)) {
            ?>
					<?php echo $row->dmname;?>
					&nbsp;[ <i><?php echo _DML_CHECKED_OUT;?></i> ]
			<?php
            } else {
            ?>
					<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
					<?php echo $row->dmname;?>
					</a>
					<?php
            }
            ?>
				</td>
                <td>
                <?php if ($file->exists()) {?>
                    <a href="index.php?option=com_docman&section=documents&task=download&bid=<?php echo $row->id;?>" >
                    <?php echo DOCMAN_Utils::urlSnippet($row->dmfilename);?></a>
               	<?php
            } else {
                echo _DML_FILE_MISSING;
            }
            ?>
            	</td>
            	<td width="15%"><?php echo $row->treename ?></td>
               	<td width="10%" align="center"><?php echo JHTML::_('date', $row->dmdate_published, JText::_('DATE_FORMAT_LC1')); ?></td>
               	<td align="center"><?php echo DOCMAN_Utils::getUserName($row->dmowner); ?></td>
                <td width="10%" align="center">
					<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
					<img src="images/<?php echo $img;?>" border="0" alt="<?php echo $alt;?>" />
					</a>
				</td>
			<?php
            if (!$row->approved) {
                ?>
	            	<td width="5%" align="center"><a href="#approve" onClick="return listItemTask('cb<?php echo $i;?>','approve')"><img src="images/publish_x.png" border=0 alt="approve" /></a></td>
	            <?php
            } else {
                ?>
	            	<td width="5%" align="center"><img src="images/tick.png" /></td>
	            <?php
            }
            ?>
	            <td width="5%" align="center">
	       	<?php
            if ($file->exists()) {
                echo $file->getSize();
            }
            ?>
            </td>
            <td width="5%" align="center"><?php echo $row->dmcounter;?></td>
			<?php
            if ($row->checked_out) {
                ?>
                	<td width="5%" align="center"><?php echo $row->editor;?></td>
            	<?php
            } else {
                ?>
                <td width="5%" align="center">---</td>
                <?php
            }

            ?></tr><?php
            $k = 1 - $k;
        }
        ?>
        </tbody>

      </table>


      <input type="hidden" name="option" value="com_docman" />
      <input type="hidden" name="section" value="documents" />
      <input type="hidden" name="task" value="" />
      <input type="hidden" name="boxchecked" value="0" />
      <?php echo DOCMAN_token::render();?>
      </form>

   	  <?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }

    function editDocument(&$row, &$lists, $last, $created, &$params)
    {
        JHTML::_('behavior.tooltip');

    	jimport('joomla.html.pane');
        $tabs = JPane::getInstance('tabs', array('useCookies' => true));
        JFilterOutput::objectHTMLSafe($row);

        DOCMAN_Compat::calendarJS();
        ?>
    	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
    	<script language="JavaScript" src="<?php echo JURI::root(true);?>/includes/js/overlib_mini.js" type="text/javascript"></script>
    	<script language="JavaScript" type="text/javascript">
    		<!--
    		function submitbutton(pressbutton) {
    		  var form = document.adminForm;
    		  if (pressbutton == 'cancel') {
    			submitform( pressbutton );
    			return;
    		  }
    		  // do field validation
			<?php dmHTML::docEditFieldsJS();/* Include all edits at once */?>
			if ( $msg != "" ){
					$msghdr = "<?php echo _DML_ENTRY_ERRORS;?>";
					$msghdr += '\n=================================';
					alert( $msghdr+$msg+'\n' );
			}else {
			<?php
			jimport('joomla.html.editor');
			$editor = &JFactory::getEditor();

        	echo $editor->save( 'dmdescription');
        	?>
				submitform( pressbutton );
				}
			}
			//--> end submitbutton
    	</script>

    	<style>
			select option.label { background-color: #EEE; border: 1px solid #DDD; color : #333; }
		</style>

        <?php
        $tmp = ($row->id ? _DML_EDIT : _DML_ADD).' '._DML_DOCUMENT;
        dmHTML::adminHeading( $tmp, 'documents' )
        ?>

    	<form action="index.php" method="post" name="adminForm" class="adminform" id="dm_formedit">
	        <fieldset class="adminform">
		        <legend><?php echo _DML_TITLE_DOCINFORMATION ?></legend>
		        <table class="admintable">

		        <?php HTML_DMDocuments::_showTabBasic($row, $lists, $last, $created);?>

		        </table>
	    	</fieldset>
			<?php
	        echo $tabs->startPane("content-pane");
	        echo $tabs->startPanel(_DML_DOC, "document-page");

			HTML_DMDocuments::_showTabDocument($row, $lists, $last, $created);

	        echo $tabs->endPanel();
	        echo $tabs->startPanel(_DML_TAB_PERMISSIONS, "ownership-page");

	        HTML_DMDocuments::_showTabPermissions($row, $lists, $last, $created);

	        echo $tabs->endPanel();
	        echo $tabs->startPanel(_DML_TAB_LICENSE, "license-page");

	        HTML_DMDocuments::_showTabLicense($row, $lists, $last, $created);

	        if(isset($params)) :
	        echo $tabs->endPanel();
	        echo $tabs->startPanel(_DML_TAB_DETAILS, "details-page");

	        HTML_DMDocuments::_showTabDetails($row, $lists, $last, $created, $params);
	        endif;

	        echo $tabs->endPanel();
	        echo $tabs->endPane();
	        ?>

			<input type="hidden" name="original_dmfilename" value="<?php echo htmlspecialchars($lists['original_dmfilename'])?>" />
	    	<input type="hidden" name="dmsubmitedby" value="<?php echo $row->dmsubmitedby;?>" />
	    	<input type="hidden" name="id" value="<?php echo $row->id;?>" />
	    	<input type="hidden" name="option" value="com_docman" />
	    	<input type="hidden" name="section" value="documents" />
	    	<input type="hidden" name="task" value="" />
	        <input type="hidden" name="dmcounter" value="<?php echo $row->dmcounter;?>" />
	        <?php echo DOCMAN_token::render();?>
    	</form>
        <?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }

    function _showTabBasic(&$row, &$lists, &$last, &$created)
    {
        ?>

        <tr>
            <td class="key"><?php echo _DML_NAME;?></td>
            <td colspan="2">
                <input class="inputbox" type="text" name="dmname" size="50" maxlength="100" value="<?php echo $row->dmname ?>" />
            </td>
        </tr>

        <tr>
            <td class="key"><?php echo _DML_CAT;?></td>
            <td><?php echo $lists['catid'];?></td>
        </tr>

        <?php if (!$row->approved) :?>
        <tr>
            <td class="key">
            	<label class="hasTip" title="<?php echo _DML_APPROVED.'::'._DML_APPROVED_TOOLTIP ?>"><?php echo _DML_APPROVED;?></label>
        	</td>
            <td>
            	<?php echo $lists['approved']; ?>
            </td>
        </tr>
        <?php else: ?>
        	<input type="hidden" value="<?php echo $row->approved?>"  name="approved" />
        <?php endif; ?>
        <tr>
            <td class="key">
            	<label class="hasTip" title="<?php echo _DML_PUBLISHED ?>"><?php echo _DML_PUBLISHED; ?></label>
        	</td>
            <td>
            	<?php echo $lists['published']; ?>
            </td>
        </tr>
        <tr>
        	<td class="key"><?php echo _DML_DESCRIPTION;?></td>
			<td colspan="2">
            <?php
            // parameters : areaname, content, hidden field, width, height, rows, cols
            DOCMAN_Compat::editorArea('editor1', $row->dmdescription , 'dmdescription', '500', '200', '50', '5') ;
            ?>
            </td>
        </tr>

        <?php
    }

    function _showTabDocument(&$row, &$lists, &$last, &$created)
    {
    	?>
    	<fieldset class="adminform">
    	<legend><?php echo _DML_TITLE_DOCINFORMATION ?></legend>
    	<table class="admintable">
	    	<tr>
	    		<td class="key">
				<?php echo _DML_THUMBNAIL;?>
				</td>
				<td>
				<?php echo $lists['image'];?>
				<br /><br />
					<script language="javascript" type="text/javascript">
					<!--
					if (document.forms[0].dmthumbnail.options.value){
						jsimg='../images/stories/' + getSelectedValue( 'adminForm', 'dmthumbnail' );
					} else {
						jsimg='../images/M_images/blank.png';
					}
						document.write('<img src=' + jsimg + ' name="imagelib" width="80" height="80" border="2" alt="Preview" />');
					//-->
				</script>
				</td>
	    	</tr>
	    	<tr>
	    		<td class="key"><?php echo _DML_FILE;?></td>
	    		<td><?php echo $lists['dmfilename']?></td>
	    	</tr>
	    	<tr>
	    		<td class="key"><?php echo _DML_DATE;?></td>
	    		<td>
	                <?php echo DOCMAN_Compat::calendar('dmdate_published', $row->dmdate_published);?>
	            </td>
	    	</tr>
			<tr>
				<td class="key">
					<label class="hasTip" title="<?php echo _DML_DOCURL.'::'._DML_DOCURL_TOOLTIP ?>"><?php echo _DML_DOCURL; ?></label>
				</td>
				<td>
				<input class="inputbox" type="text" name="document_url" size="50" maxlength="200" value="<?php echo htmlspecialchars($lists['document_url'], ENT_QUOTES); ?>" />
				</td>
			</tr>
	    	<tr>
	    		<td class="key">
	    			<label class="hasTip" title="<?php echo _DML_HOMEPAGE.'::'._DML_HOMEPAGE_TOOLTIP ?>"><?php echo _DML_HOMEPAGE;?></label>
	    		</td>
	    		<td>
	    			<input class="inputbox" type="text" name="dmurl" size="50" maxlength="200" value="<?php echo $row->dmurl;/*htmlspecialchars($row->dmurl, ENT_QUOTES);*/?>" />
	    		</td>
	    		<td><!--<i>(<?php echo _DML_MAKE_SURE;?>)</i>--></td>
	    	</tr>
    	</table>
    	</fieldset>
    	<?php
    }

    function _showTabPermissions(&$row, &$lists, &$last, &$created)
    {
   		?>
    	<fieldset class="adminform">
    	<legend><?php echo _DML_TITLE_DOCPERMISSIONS ?></legend>
    	<table class="admintable">
	    	<tr>
	    		<td class="key">
	    			<label class="hasTip" title="<?php echo _DML_OWNER.'::'._DML_OWNER_TOOLTIP ?>"><?php echo _DML_OWNER;?></label>
	    		</td>
	    		<td>
	    		<?php
	    		echo $lists['viewer'];
	        	?>
	        	</td>
	    	</tr>
	    	<tr>
	    		<td class="key">
	    			<label class="hasTip" title="<?php echo _DML_MAINTAINER.'::'._DML_MANT_TOOLTIP ?>"><?php echo _DML_MAINTAINER;?></label>
	    		</td>
	    		<td>
	    		<?php
	    		echo $lists['maintainer'];
	        	?>
	        	</td>
	    	</tr>
	    	<tr>
	    		<td class="key"><?php echo _DML_CREATED_BY;?></td>
	    		<td>[<?php echo $created[0]->name;?>] <i>on
	    		<?php echo JHTML::_('date', $row->dmdate_published,  JText::_('DATE_FORMAT_LC1')) ?>
	    		</i> </td>
	    	</tr>
	    	<tr>
	    		<td class="key"><?php echo _DML_UPDATED_BY;?></td>
	    		<td>[<?php echo $last[0]->name;?>]
	    		<?php
	        	if ($row->dmlastupdateon) {
	            	echo " <i>on " . JHTML::_('date', $row->dmlastupdateon, JText::_('DATE_FORMAT_LC1')).'</i>';
	        	}
	        	?>

	    		</td>
	    	</tr>
    	</table>
    	</fieldset>
    	<?php
    }

    function _showTabLicense(&$row, &$lists, &$last, &$created)
    {
   		?>
    	<fieldset class="adminform">
    	<legend><?php echo _DML_TITLE_DOCLICENSES ?></legend>
    	<table class="admintable">
	    	<tr>
	    		<td class="key">
	    			<label class="hasTip" title="<?php echo _DML_LICENSE_TYPE.'::'._DML_LICENSE_TOOLTIP ?>"><?php echo _DML_LICENSE_TYPE;?></label>
   				</td>
	    		<td>
	    		<?php
	    		echo $lists['licenses'];
	        	?>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td class="key">
	    			<label class="hasTip" title="<?php echo _DML_DISPLAY_LIC.'::'._DML_DISPLAY_LIC_TOOLTIP ?>"><?php echo _DML_DISPLAY_LICENSE;?></label>
	    		</td>
	    		<td>
	    		<?php
	    		echo $lists['licenses_display'];
	        	?>
	    		</td>
	    	</tr>
    	</table>
    	</fieldset>
    	<?php
    }

    function _showTabDetails(&$row, &$lists, &$last, &$created, &$params)
	{
		?>
		<fieldset class="adminform">
    	<legend><?php echo _DML_TITLE_DOCDETAILS ?></legend>
			<?php echo $params->render();?>
		</fieldset>
        <?php
	}

    function moveDocumentForm($cid, &$lists, &$items)
    {
        ?>

        <?php dmHTML::adminHeading( _DML_MOVETOCAT, 'categories' )?>


		<form action="index.php" method="post" name="adminForm" class="adminform" id="dm_moveform">
		<table class="adminform">
		<tr>
			<td align="left" valign="middle" width="10%">
			<strong><?php echo _DML_MOVETOCAT;?></strong>
			<?php echo $lists['categories'] ?>
			</td>
			<td align="left" valign="top" width="20%">
			<strong><?php echo _DML_DOCSMOVED;?></strong>
			<?php
        	echo "<ol>";
        	foreach ($items as $item) {
            	echo "<li>" . $item->dmname . "</li>";
        	}
        	echo "</ol>";?>
			</td>
		</tr>
		</table>
		<input type="hidden" name="option" value="com_docman" />
    	<input type="hidden" name="section" value="documents" />
    	<input type="hidden" name="task" value="move_process" />
		<input type="hidden" name="boxchecked" value="1" />
		<?php
        foreach ($cid as $id) {
            echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
        }
        ?>
        <?php echo DOCMAN_token::render();?>
		</form>
		<?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }

    function copyDocumentForm($cid, &$lists, &$items)
    {
        ?>
        <?php dmHTML::adminHeading( _DML_COPYTOCAT, 'categories' )?>

        <form action="index.php" method="post" name="adminForm" class="adminform" id="dm_moveform">
        <table class="adminform">
        <tr>
            <td align="left" valign="middle" width="10%">
            <strong><?php echo _DML_COPYTOCAT;?></strong>
            <?php echo $lists['categories'] ?>
            </td>
            <td align="left" valign="top" width="20%">
            <strong><?php echo _DML_DOCSCOPIED;?></strong>
            <?php
            echo "<ol>";
            foreach ($items as $item) {
                echo "<li>" . $item->dmname . "</li>";
            }
            echo "</ol>";?>
            </td>
        </tr>
        </table>
        <input type="hidden" name="option" value="com_docman" />
        <input type="hidden" name="section" value="documents" />
        <input type="hidden" name="task" value="copy_process" />
        <input type="hidden" name="boxchecked" value="1" />
        <?php
        foreach ($cid as $id) {
            echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
        }
        ?>
        <?php echo DOCMAN_token::render();?>
        </form>
        <?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }
}
