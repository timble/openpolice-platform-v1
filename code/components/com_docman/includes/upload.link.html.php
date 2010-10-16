<?php
/**
 * @version		$Id: upload.link.html.php 1009 2009-12-04 13:29:59Z tom $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMUploadMethod
{
    function linkFileForm($lists)
    {
        ob_start();
        ?>
    	<form action="<?php echo DOCMAN_Compat::sefRelToAbs($lists['action']) ;?>" method="post" id="dm_frmupload" class="dm_form">
    	<fieldset class="dm_adminform">
        <table class="dm_admintable">
        <tr>
			<td class="dm_key">
				<label for="url" class="hasTip" title="<?php echo _DML_REMOTEURL.'::'._DML_LINKURLTT; ?>"><?php echo _DML_REMOTEURL;?></label>
			</td>
			<td>
				<input name="url" type="text" id="url" value="<?php /*echo $parms['url'];*/ ?>" />
			</td>
		</tr>
		</table>
		</fieldset>
	   	<fieldset class="dm_button">
	   		<input name="submit" id="dm_btn_back"   class="button" value="<?php echo _DML_BACK;?>" onclick="window.history.back()" type="button" >
			<input name="submit" id="dm_btn_submit" class="button" value="<?php echo _DML_LINK;?>" type="submit" />
       	 </fieldset>
       	 <input type="hidden" name="method" value="link" />
         <?php echo DOCMAN_token::render();?>
       	</form>
   		<?php
		$html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}

