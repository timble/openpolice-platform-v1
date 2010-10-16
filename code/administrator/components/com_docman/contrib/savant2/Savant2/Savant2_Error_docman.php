<?php

/**
* Output a docman error
*
* $Id:Savant2_Error_docman.php 81 2007-02-14 16:19:06Z mjaz $
* @author Johan Janssens <johan.janssens@users.sourceforge.net>
* @package Savant2
* @license http://www.gnu.org/copyleft/lesser.html LGPL
*
*/

require_once dirname(__FILE__) . DS.'Error.php';

class Savant2_Error_docman extends Savant2_Error {
    /**
    * Extended behavior for docman
    *
    * @access public
    * @return void
    */

    function error()
    {
        ?><div class="dm_error" >
			<p><strong>There was an error displaying the template.</strong> </p>
			<p><?php echo $this->text . ' ( code :' . $this->code . ' )' ?></p>
    	</div>
    	<?php
    }
}

