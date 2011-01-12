/**
 * @version		$Id: view.flags.js 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Media
 * @subpackage  Javascript
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

function clickFlag(code) {
	window.parent.changeFlag(code);
	window.parent.document.getElementById('sbox-window').close();
}