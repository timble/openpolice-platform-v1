<?php
/**
 * @version		$Id: download.html.php 1010 2009-12-04 17:07:02Z tom $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMDownload
{
    function licenseDocumentForm(&$links, &$paths, &$data, $inline=0)
    {
        $action = _taskLink('license_result', JRequest::getInt('gid', 0) , array('bid' => $data->id));

        ob_start();
        ?>
		<form action="<?php echo DOCMAN_Compat::sefRelToAbs($action);?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="inline" value="<?php echo $inline?>" />
			<input type="radio" name="agree" value="0" checked /><?php echo _DML_DONT_AGREE;?>
			<input type="radio" name="agree" value="1" /><?php echo _DML_AGREE;?><br /><br />
			<input name="submit" value="<?php echo _DML_PROCEED;?>" type="submit" />
		</form>

		<?php

		$html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}

