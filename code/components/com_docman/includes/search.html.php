<?php
/**
 * @version		$Id: search.html.php 1303 2010-03-06 14:08:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMSearch
{
    function searchForm(&$lists, $search_phrase)
    {
        global $_DOCMAN;

        $action = _taskLink('search_result');

        ob_start();
        ?>
        <fieldset class="input">

        <form action="<?php echo JRoute::_($action);?>" method="post" name="adminForm" id="dm_frmsearch" class="dm_searchform">
        <table width="100%" class="contentpaneopen">
            <tr height="30px">
                <td nowrap="nowrap" width="150px">
                    <label for="search_phrase"><?php echo _DML_PROMPT_KEYWORD;?></label>:
                </td>
                <td nowrap="nowrap" width="150px">
                    <input type="text" class="inputbox" id="search_phrase" name="search_phrase"  value="<?php echo htmlspecialchars(stripslashes($search_phrase), ENT_QUOTES); ?>" />
                </td>
                <td nowrap="nowrap">
                </td>
            </tr>
            <tr height="30px">
                <td nowrap="nowrap">
                    <label for="catid"><?php echo _DML_SELECCAT;?></label>:
                </td>
                <td nowrap="nowrap">
                    <?php echo $lists['catid'] ;?>
                </td>
                <td nowrap="nowrap">
                </td>
            </tr>
            <tr height="30px">
                <td nowrap="nowrap">
                    <label for="ordering"><?php echo _DML_CMN_ORDERING;?></label>:
                </td>
                <td nowrap="nowrap">
                    <?php echo $lists['ordering'] ;?>
                </td>
                <td nowrap="nowrap">
                    <?php echo $lists['reverse_order'] . _DML_SEARCH_REVRS;?>
                </td>
            </tr>
            <tr height="30px">
                <td nowrap="nowrap">
                    <label for="search_mode"><?php echo _DML_SEARCH_MODE;?></label>:
                </td>
                <td>
                    <?php echo $lists['search_mode']?>
                </td>
                <td>
                    <?php echo $lists['invert_search'] . _DML_NOT ;?>
                </td>
            </tr>
            <tr height="30px">
                <td nowrap="nowrap">
                    <label for="search_where"><?php echo _DML_SEARCH_WHERE;?></label>:
                </td>
                <td>
                    <?php echo $lists['search_where'] ;?>
                </td>
                <td nowrap="nowrap">
                </td>
            </tr>
            <tr height="30px">
                <td nowrap="nowrap">
                </td>
                <td>
                    <input type="submit" class="button" value="<?php echo _DML_SEARCH;?>" />
                </td>
                <td>
                </td>
            </tr>

        </table>
        </form>
        </fieldset>
        <?php
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}