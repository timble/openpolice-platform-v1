<?php
/**
 * @version		$Id: files.html.php 1372 2010-06-11 14:22:50Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMFiles
{
    function showFiles($rows, $lists, $search, $pageNav)
    {
        global $_DOCMAN;
        global $option;

        $database = JFactory::getDBO();
        $my       = JFactory::getUser();
        ?>

        <form action="index.php" method="post" name="adminForm">

        <?php dmHTML::adminHeading( _DML_FILES, 'files' )?>

        <div class="dm_filters">
            <?php echo _DML_FILTER;?>
            <input class="text_area" type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
            <?php echo $lists['filter'];?>
        </div>

        <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
          <thead>
          <tr>
            <th width="2%" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows);?>);" /></th>
            <th width="15%" align="left"><?php echo _DML_NAME;?></th>
            <th width="15%" align="center"><?php echo _DML_DATE;?></th>
            <th width="15%"><?php echo _DML_EXT;?></th>
            <th width="15%"><?php echo _DML_MIME;?></th>
            <th width="5%"><?php echo _DML_SIZE;?></th>
            <th width="5%"># <?php echo _DML_LINKS;?></th>
            <th width="5%" align="center"><?php echo _DML_UPDATE;?></th>
          </tr>
          </thead>
          <tfoot><tr><td colspan="11"><?php echo $pageNav->getListFooter();?></td></tr></tfoot>
          <tbody>
          <?php
        $k = 0;
        for ($i = 0, $n = count($rows);$i < $n;$i++) {
            $row = &$rows[$i];
          	?>
        		<tr class="<?php echo "row$k";?>">
        		<td width="20">
				<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo htmlspecialchars($row->name)?>" onclick="isChecked(this.checked);" />
            	</td>
            	<td>
                    <a onclick="return listItemTask('cb<?php echo $i;?>','new')" href="#new">
                        <?php echo htmlspecialchars($row->name);?>
                    </a>
                </td>
            	<td align="center"><?php echo $row->getDate();?></td>
            	<td align="center"><?php echo $row->ext;?></td>
            	<td align="center"><?php echo $row->mime;?></td>
            	<td align="center"><?php echo $row->getSize();?></td>
            	<td align="center"><?php echo $row->links;?></td>
            	<td align="center">
                <a href="index.php?option=com_docman&section=files&task=update&old_filename=<?php echo $row->name;?>"><img src="<?php echo JURI::root(true) ?>/administrator/components/com_docman/images/dm_upload_16.png" alt="<?php echo _DML_UPDATE;?>" border="0" /></a>
            	</td>
			<?php
            $k = 1 - $k;
        }
        ?>
        </tbody>
      </table>



      <input type="hidden" name="option" value="com_docman" />
      <input type="hidden" name="section" value="files" />
      <input type="hidden" name="task" value="" />
      <input type="hidden" name="boxchecked" value="0" />
      <?php echo DOCMAN_token::render();?>
      </form>

      <?php include_once(JPATH_SITE.DS.'components'.DS.'com_docman'.DS.'footer.php');

    }

    function uploadWizard(&$lists)
    {
        ?>

       <?php dmHTML::adminHeading( _DML_UPLOADWIZARD, 'files' );?>

       	<form action="index.php?option=com_docman&section=files&task=upload&step=2" method="post">
       	<fieldset class="adminform">
    	<legend><?php echo _DML_UPLOADMETHOD;?></legend>
    	<table class="admintable">
	        <tr>
	          <td width="38%" rowspan="4" align="center">
		        <div align="right" >
		         <img src="<?php echo JURI::root(true);?>/administrator/components/com_docman/images/dm_upload_48.png">
	            </div>
			  </td>
	          <td width="4%" align="center"> <div align="right">
	              <?php echo $lists['methods'];?>
	            </div>
			  </td>
			  <td width="60%">&nbsp;</td>
	        </tr>
	        <tr>
	          <td><div align="center">
	              <input type="submit" name="Submit" value="<?php echo _DML_NEXT;?>>>>">
	            </div></td>
	          <td>&nbsp;</td>
	        </tr>
      	</table>
      	</fieldset>
	    <?php echo DOCMAN_token::render();?>
	    </form>
	    <form action="index.php" method="post" name="adminForm">
	        <input type="hidden" name="option" value="com_docman" />
	        <input type="hidden" name="section" value="files" />
	        <input type="hidden" name="task" value="" />
	        <input type="hidden" name="boxchecked" value="0" />
	    </form>
	<?php
    }

    function uploadWizard_http($old_filename = null)
    {
        ?>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<script language="Javascript" src="<?php echo JURI::root(true);?>/includes/js/overlib_mini.js"></script>
		<script language="Javascript" src="<?php echo JURI::root(true);?>/administrator/components/com_docman/includes/js/docmanjavascript.js"></script>

		<style type="text/css">
			<!--
			.style1 {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-weight: bold;
			}

			.style2 {color: #FF0000}
			.style3 {color: #FFFFFF}
			//-->
		</style>

		<form action="index.php?option=com_docman&section=files&task=upload&step=3&method=http&old_filename=<?php echo $old_filename;?>" method="post" enctype="multipart/form-data" onSubmit="MM_showHideLayers('Layer1','','show')" name="fm_upload">
		<div id="Layer1" style="position:absolute; margin-left: auto; margin-right: auto;  width:200px; height:130px; z-index:150; visibility: hidden; left: 14px; top: 11px; background-color: #99989D; layer-background-color: #FF0000; border: 3px solid #F19518;">

			<div align="center" class="style1">
				<p align="center" class="style2"><br />
					<span class="style3"><?php echo _DML_ISUPLOADING;?></span>
				</p>

				<p align="center" class="style2"><img src="<?php echo JURI::root(true);?>/components/com_docman/assets/images/dm_progress.gif" ></p>
				<p align="center" class="style3"><?php echo _DML_PLEASEWAIT;?><br /></p>
			</div>
		</div>

        <?php dmHTML::adminHeading( _DML_UPLOADDISK, 'files' )?>

        <fieldset class="adminform">
    	<legend><?php echo _DML_FILETOUPLOAD;?></legend>
    	<table class="admintable">
        <tr>
	    	<td class="key" nowrap ><?php echo _DML_FILETOUPLOAD;?>:</td>
            <td>
            	<input name="upload" type="file" id="upload" size="35">
	    	</td>
	    	<td align="center" rowspan="6">
				<div align="right"><img src="<?php echo JURI::root(true);?>/administrator/components/com_docman/images/dm_upload_48.png"></div>
            </td>
		 </tr>
       <?php if ($old_filename == '1') {?>
	   <tr>
	   <td class="key"><?php echo _DML_BATCHMODE;?>:</td>
	   <td>
            <div align="left">
                <input name="batch" type="checkbox" id="batch" value="1"
			onClick="if( ! document.fm_upload.localfile.disabled ){document.fm_upload.localfile.value='';}
				 document.fm_upload.localfile.disabled=!document.fm_upload.localfile.disabled;
				 return(true);">
                <?php echo DOCMAN_Utils::mosToolTip(_DML_BATCHMODETT. '</span>', _DML_CFG_DOCMANTT);?>
            </div>
	  </td>
        </tr>
        <?php } ?>
        <tr>
	    <td colspan="1" align="center">&nbsp;</td>
            <td align="center">
            	<div align="left">
                	<input type="button" name="Submit2" value="&lt;&lt;&lt;" onclick="window.history.back()">
                	<input type="submit" name="Submit" value="<?php echo _DML_SUBMIT ?>">
                </div>
            </td>
        </tr>
      </table>
      </fieldset>
    <?php echo DOCMAN_token::render();?>
    </form>

    <form action="index.php" method="post" name="adminForm">
        <input type="hidden" name="option" value="com_docman" />
        <input type="hidden" name="section" value="files" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
    </form>
    <?php
    }

    function uploadWizard_transfer()
    {
        ?>

		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
        <script language="Javascript" src="<?php echo JURI::root(true);?>/administrator/components/com_docman/includes/js/docmanjavascript.js"></script>
		<script language="Javascript" src="<?php echo JURI::root(true);?>/includes/js/overlib_mini.js"></script>
    	<style type="text/css">
		.style1 {
    		font-family: Verdana, Arial, Helvetica, sans-serif;
    		font-weight: bold;
		}
		.style2 {color: #FF0000}
		.style3 {color: #FFFFFF}
		</style>

		<div id="Layer1" style="position:absolute; margin-left: auto; margin-right: auto;  width:200px; height:130px; z-index:1; visibility: hidden; left: 14px; top: 11px; background-color: #99989D; layer-background-color: #FF0000; border: 3px solid #F19518;">
  		<div align="center" class="style1">
    		<p align="center" class="style2"><br />
    		<span class="style3"><?php echo _DML_DOCMANISTRANSF;?></span></p>
    		<p align="center" class="style2"><img src="<?php echo JURI::root(true);?>/components/com_docman/assets/images/dm_progress.gif" ></p>
    		<p align="center" class="style3"><?php echo _DML_PLEASEWAIT;?><br />
    	</p>
  		</div>
		</div>
    	<form action="index.php?option=com_docman&section=files&task=upload&step=3&method=transfer" method="post" onSubmit="MM_showHideLayers('Layer1','','show')">
        <?php dmHTML::adminHeading( _DML_TRANSFERFROMWEB, 'files' )?>
        <fieldset class="adminform">
    	<legend><?php echo _DML_TRANSFERFROMWEB ?></legend>
    	<table class="admintable">
        <tr>

	    <td class="key" nowrap><?php echo _DML_REMOTEURL;?>:</td>
            <td align="left">
            <div align="left">
                <input name="url" type="text" id="url" value="http://">
            </div></td>
	    <td align="left"><?php echo DOCMAN_Utils::mosToolTip(_DML_REMOTEURLTT . '</span>',  _DML_REMOTEURL);?></td>
	    <td rowspan="2"><img src="<?php echo JURI::root(true);?>/administrator/components/com_docman/images/dm_upload_48.png">
            </td>
	</tr>

	<tr>

            <td class="key"><?php echo _DML_LOCALNAME;?>:</td>
            <td align="left">
            <div align="left">
                <input name="localfile" type="text" id="localfile" value="">
            </div></td>
	    <td align="left" width="40%"><?php echo DOCMAN_Utils::mosToolTip(_DML_LOCALNAMETT . '</span>',  _DML_LOCALNAME);?></td>
        </tr>
        <tr>
            <td colspan="1" align="center">&nbsp;</td>
            <td align="center">
            	<div align="left">
                	<input type="button" name="Submit2" value="&lt;&lt;&lt;" onclick="window.history.back()">
                	<input type="submit" name="Submit" value="<?php echo _DML_SUBMIT;?>" onclick="if($('localfile').value == '')  { alert('Select a local name'); return false; }" >
                </div>
            </td>
        </tr>
      </table>
      </fieldset>
    <?php echo DOCMAN_token::render();?>
    </form>

    <form action="index.php" method="post" name="adminForm">
        <input type="hidden" name="option" value="com_docman" />
        <input type="hidden" name="section" value="files" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
    </form>
    <?php
    }

    function uploadWizard_sucess(&$file, $batch = 0, $old_filename = null, $show_completion = 1)
    {
    	$mainframe = JFactory::getApplication();
        if ($old_filename <> '1') {
            $mainframe->redirect("index.php?option=com_docman&section=files", "&quot;" . $old_filename . "&quot; - " . _DML_DOCUPDATED);
        }
        ?>

        <?php dmHTML::adminHeading( _DML_UPLOADWIZARD, 'files' )?>


        <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
  		<?php if ($show_completion) {
            /* backwards compatible */?>
        <tr>
          <td width="38%" align="center">
          	<div align="right">
          		<img src="<?php echo JURI::root(true);?>/administrator/components/com_docman/images/dm_upload_48.png" />
          	</div>
          </td>
          <td colspan="2"><div align="left">'<?php echo $file->name?>' -<?php echo _DML_FILEUPLOADED;?></div></td>
        </tr>
		<tr>
		  <td colspan=2><div align="center"><hr /></div></td>
		</tr>
	<?php } ?>

	<!-- Give them a nice sub menu -->
  	<?php
        if (!$batch && $old_filename == '1') {
            /* Can't create docs from a batch or existing file */?>
    	<tr>
    		<td>
    		<div align="right">
    			<a href="index.php?option=com_docman&section=documents&task=new&uploaded_file=<?php echo $file->name;?>">
    			<img src="<?php echo JURI::root(true);?>/administrator/images/edit_f2.png" border="0">
    			</a>
    		</div>
    		</td>

    		<td>
    		<div align="left"><?php echo _DML_MAKENEWENTRY;?></div>
    		</td>
    	</tr>
    	<?php } ?>

    <tr>

	<td>
		<div align="right">
			<a href="index.php?option=com_docman&section=files&task=upload">
			<img src="<?php echo JURI::root(true);?>/administrator/images/upload_f2.png" border="0">
			</a>
		</div>
	</td>
	<td><div align="left"><?php echo _DML_UPLOADMORE;?></div></td>
	</tr>
	<tr>
		<td>
			<div align="right">
				<a href="index.php?option=com_docman&section=files">
					<img src="<?php echo JURI::root(true);?>/administrator/images/next_f2.png" border="0">
				</a>
			</div>
		</td>
		<td>
			<div align="left"><?php echo _DML_DISPLAYFILES;?></div>
		</td>
	</tr>
	</table>

	<form action="index.php" method="post" name="adminForm">
        <input type="hidden" name="option" value="com_docman" />
        <input type="hidden" name="section" value="files" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
    </form>
	<?php
    }
}