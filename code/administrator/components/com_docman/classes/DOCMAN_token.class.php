<?php
/**
 * @version		$Id: DOCMAN_token.class.php 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Utility class to work with form tokens
 *
 * @example:
 * In a form:
 * <code>
 * <?php echo DOCMAN_token::render();?>
 * </code>
 * Where the form is submitted:
 * <code>
 * <?php DOCMAN_token::check() or die('Invalid Token'); ?>
 * </code>
 *
 * @static
 */
class DOCMAN_Token
{
    /**
     * Generate new token and store it in the session
     *
     * @see render()
     * @return	string	Token
     */
    function get($forceNew = false)
    {
        return JUtility::getToken($forceNew);
    }

    /**
     * Render the hidden input field with the token
     *
     * @return	string	Html
     */
    function render()
    {
    	return JHTML::_( 'form.token' );  
    }

    /**
     * Check if a valid token was submitted
     *
     * @todo	When all forms are updated to fully use $_POST, so should this
     *
     * @return	boolean	True on success
     */
    function check($method = 'post')
    {
    	return JRequest::checkToken($method);
    }
}