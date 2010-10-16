<?php

/**
* Output a <script></script> link to a JavaScript file.
*
* $Id:Savant2_Plugin_validator.php 81 2007-02-14 16:19:06Z mjaz $
* @author Johan Janssens <johan.janssens@users.sourceforge.net>
* @package Savant2
* @license http://www.gnu.org/copyleft/lesser.html LGPL
*
*/

require_once dirname(__FILE__) . DS.'Plugin.php';

class Savant2_Plugin_validator extends Savant2_Plugin
{
    /**
    * Output a <script></script> link to a dynamic generated JavaScript file.
    *
    * @access public
    * @return string
    */

    function plugin($params = null)
    {
        global $task, $gid;

        $link = JURI::root(true)."/index.php?option=com_docman&task=$task&tmpl=component";
        if (is_array($params)) {
            $link .= "&" . DOCMAN_Utils::implode_assoc('=', '&', $params);
        }
        $link .= "&script=1";

        ob_start();
        ?>
        <script language="javascript" type="text/javascript" src="<?php echo $link ?>"></script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}
