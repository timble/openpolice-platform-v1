<?php
/**
 * @version		$Id: upload.http.html.php 1110 2010-01-11 14:02:43Z tom $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMUploadMethod
{
    function uploadFileForm($lists)
    {
        $progressImg = JURI::root(true).'/components/com_docman/assets/images/dm_progress.gif';
        ob_start();
        ?>
		<form action="<?php echo JRoute::_($lists['action']) ;?>" method="post" enctype="multipart/form-data" id="dm_frmupload" class="dm_form">
		<fieldset class="dm_adminform">
        <table class="dm_admintable">
        <tr>
        	<td colspan="2"><div id="progress" style="display:none;"><img style="border:1px solid black;" src="<?php echo $progressImg?>" alt="Upload Progress" />&nbsp;<?php echo _DML_ISUPLOADING?></div></td>
        </tr>
        <tr>
			<td class="dm_key">
				<label for="upload"><?php echo _DML_SELECTFILE;?></label>
			</td>
			<td>
				<input id="upload" name="upload" type="file" name="file" />
			</td>
		</tr>
		</table>
       	</fieldset>
	   	<fieldset class="dm_button">
	   		<input name="submit" id="dm_btn_back"   class="button" value="<?php echo _DML_BACK;?>" onclick="window.history.back()" type="button" >
	   		<input name="submit" id="dm_btn_submit" class="button" value="<?php echo _DML_UPLOAD;?>" type="submit" onclick="document.getElementById('progress').style.display = 'block';" />
	   	</fieldset>
	   	<input type="hidden" name="method" value="http" />
        <?php echo DOCMAN_token::render();?>
		</form>

		<?php
		$html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}

