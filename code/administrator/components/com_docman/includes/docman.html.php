<?php
/**
 * @version		$Id: docman.html.php 1372 2010-06-11 14:22:50Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMDocman
{
    function _quickiconButton( $link, $image, $text, $path = '/administrator/images/', $target = '_self' )
    {
        ?>
        <div style="float:left;">
            <div class="icon">
                <a href="<?php echo $link; ?>" target="<?php echo $target;?>">
                    <?php echo  JHTML::_('image.administrator', $image, $path, NULL, NULL, $text); ?>
                    <span><?php echo $text; ?></span>
                </a>
            </div>
        </div>
        <?php
    }

    function showCPanel()
    {
        global $_DOCMAN;

        ?><script language="JavaScript" src="<?php echo JURI::root(true);?>/administrator/components/com_docman/includes/js/docmanjavascript.js"></script>

     	<?php JToolBarHelper::title('&nbsp;', 'dm_logo'); ?>

        <table class="adminform">
            <tr>
                <td width="55%" valign="top">
                    <div id="cpanel">
                    <?php
                        $link = "index2.php?option=com_docman&amp;section=files";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_files_48.png', _DML_FILES, _DM_ICONPATH);
                        $link = "index2.php?option=com_docman&amp;section=files&amp;task=upload";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_newfile_48.png', _DML_NEW_FILE, _DM_ICONPATH);

                        $link = "index2.php?option=com_docman&amp;section=documents";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_documents_48.png', _DML_DOCS, _DM_ICONPATH );
                        $link = "index2.php?option=com_docman&amp;section=documents&amp;task=new";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_newdocument_48.png', _DML_NEW_DOCUMENT, _DM_ICONPATH );

                        $link = "index2.php?option=com_docman&amp;section=categories";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_categories_48.png', _DML_CATS, _DM_ICONPATH);
                        $link = "index2.php?option=com_docman&amp;section=groups";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_groups_48.png', _DML_GROUPS, _DM_ICONPATH);
                        $link = "index2.php?option=com_docman&amp;section=licenses";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_licenses_48.png', _DML_LICENSES, _DM_ICONPATH );

                        $link = "index2.php?option=com_docman&amp;task=stats";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_stats_48.png', _DML_STATS, _DM_ICONPATH );
                        $link = "index2.php?option=com_docman&amp;section=logs";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_logs_48.png', _DML_DOWNLOAD_LOGS, _DM_ICONPATH);

                        $link = "index2.php?option=com_docman&amp;section=config";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_config_48.png', _DML_CONFIG, _DM_ICONPATH);
                        $link = "index2.php?option=com_docman&amp;section=themes";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_templatemanager_48.png', _DML_THEMES, _DM_ICONPATH);
                        $link = "index2.php?option=com_docman&amp;section=themes&amp;task=edit&amp;cid[0]=".$_DOCMAN->getCfg('icon_theme');
                        HTML_DMDocman::_quickiconButton( $link, 'dm_edittheme_48.png', _DML_EDIT_DEFAULT_THEME, _DM_ICONPATH);
                        $link = "index2.php?option=com_docman&amp;section=cleardata";
                        HTML_DMDocman::_quickiconButton( $link, 'dm_cleardata_48.png', _DML_CLEARDATA, _DM_ICONPATH);

                        HTML_DMDocman::_quickiconButton( _DM_HELP_URL, 'dm_help_48.png', _DML_HELP, _DM_ICONPATH, '_blank');

                    ?>
                    </div>
                </td>
                <td width="45%" valign="top">
                    <div style="width=100%;">
                        <form action="index2.php" method="post" name="adminForm">
                            <?php DOCMAN_Compat::mosLoadAdminModules('dmcpanel', 1);?>
                            <input type="hidden" name="sectionid" value="" />
                            <input type="hidden" id="cid" name="cid[]" value="" />
                            <input type="hidden" name="option" value="com_docman" />
                            <input type="hidden" name="task" value="" />
                        </form>
                    </div>
                </td>
            </tr>
        </table>
    <?php include_once(JPATH_ROOT.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }

    function showStatistics(&$row)
    {
        ?>
       <form action="index2.php?option=com_docman" method="post" name="adminForm" id="adminForm">

        <?php dmHTML::adminHeading( _DML_DOCSTATS, 'stats' )?>

        <table class="adminlist" width="98%" cellspacing="2" cellpadding="2" border="0" align="center">
            <thead>
            <tr>
                <th class="title" width="15%" align="left"><?php echo _DML_RANK;?></th>
                <th class="title" width="60%" align="left"><?php echo _DML_TITLE;?></th>
                <th class="title" width="25%" align="left"><?php echo _DML_DOWNLOADS;?></th>
            </tr>
            </thead>

            <tbody>
		<?php
        $enum = 1;
        $color = 0;
        foreach($row as $rows) {

            ?>
				<tr class="row<?php echo $color;?>">
					<td width="15%" align="left"><?php echo $enum;?></td>
					 <td width="60%" align="left"><?php echo $rows->dmname;?></td>
					 <td width="25%" align="left"><b><?php echo $rows->dmcounter;?></b></td>
				</tr>
				<?php
            if (!$color) {
                $color = 1;
            } else {
                $color = 0;
            }
            $enum++;
        }

        ?>
        </tbody>
		</table>
		<input type="hidden" name="task" value="">
        <input type="hidden" name="option" value="com_docman">
		</form>

        <?php include_once(JPATH_ROOT.DS.'components'.DS.'com_docman'.DS.'footer.php');
    }

}