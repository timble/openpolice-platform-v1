<?php
/**
 * @version		$Id: upload.html.php 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMUpload
{
    function uploadMethodsForm($lists)
    {
    	$mainframe = JFactory::getApplication();
        ob_start();
        ?>
	   <form action="<?php echo JRoute::_($lists['action']);?>" method="post" id="dm_frmupload" class="dm_form">
       <fieldset class="input">
       		<p><label for="method"><?php echo _DML_UPLOADMETHOD;?></label><br />
			<?php echo $lists['methods'];?></p>
       </fieldset>
       <fieldset class="dm_button">
        	<p><input name="submit" class="button" value="<?php echo _DML_NEXT;?>" type="submit" /></p>
       </fieldset>
    	</form>
		<?php
 		$html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    function updateDocumentForm($list, $links, $paths, $data)
    {
    	$action = _taskLink('doc_update_process', $data->id);

		ob_start();
        ?>
       <form action="<?php echo JRoute::_($action) ?>" method="post" enctype="multipart/form-data" id="dm_frmupdate" class="dm_form" >
       <fieldset class="input">
       		<p>
       			<label for="upload"><?php echo _DML_SELECTFILE;?></label><br />
	   			<input id="upload" name="upload" type="file" />
	   		</p>
       </fieldset>
	   <fieldset class="dm_button">
	   		<p>
	   			<input name="submit" class="button" value="<?php echo _DML_UPLOAD ?>" type="submit" />
	   		</p>
	   </fieldset>
       <?php echo DOCMAN_token::render();?>
 	   </form>
        <?php
 		$html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}
