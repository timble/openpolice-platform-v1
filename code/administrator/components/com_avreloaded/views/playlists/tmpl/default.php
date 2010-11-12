<?php defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); ?>
<script language="javascript" type="text/javascript">
// <![CDATA[
function submitbutton(pressbutton) {
    if (pressbutton == "remove") {
        if (!confirm('<?php echo JText::_('AVR_ASK_REALLYDELETE', true); ?>'))
            return;
    }
    if (pressbutton == "add") {
        var files = new Array(<?php echo $this->files; ?>);
        var found = false;
        var newname;
        do {
            var i;
            if (found) {
                newname = prompt(newname +
                    ': <?php echo JText::_('AVR_ERR_PLSFILEEXISTS', true);?>\n' +
                    '<?php echo JText::_('AVR_PROMPT_NEWPLSFILENAME', true);?>');
            } else {
                newname = prompt('<?php echo JText::_('AVR_PROMPT_NEWPLSFILENAME', true);?>');
            }
            if (newname == null) {
                return;
            }
            // Make shure, we have a lowercase xml extension
            if (!newname.match(/\.xml$/i)) {
                newname += '.xml';
            }
            newname = newname.replace(/\.xml$/i, '.xml');
            found = false;
            for (i = 0; i < files.length; i++) {
                if (files[i] == newname) {
                    found = true;
                    break;
                }
            }
        } while (found);
        $('efile').value = $('folder').value + '/' + newname;
    }
    if (pressbutton == "edit") {
        var i;
        for (i = 0; true; i++) {
            var cb = $('cb'+i);
            if (cb == null) {
                break;
            }
            if (cb.checked) {
                $('efile').value = cb.value;
                break;
            }
        }
    }
    submitform(pressbutton);
}
function doEdit(elem) {
    $('efile').value = elem.getAttribute('rel');
    submitbutton('edit');
}
// ]]>
</script>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
    <fieldset class="adminform">
        <legend><?php echo JText::_('Details');?></legend>
        <table class="admintable">
            <tr>
                <td class="key">
                    <label for="folder" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_PLFOLDER');?>::<?php 
                        echo JText::_('AVR_DSC_PLFOLDER');?>"><?php
                        echo JText::_('AVR_LBL_PLFOLDER');?>:</label>
                </td>
                <td><?php echo $this->fselect; ?></td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="adminform">
        <legend><?php echo JText::_('AVR_TITLE_PLAYLISTS');?></legend>
<?php if (count($this->items)) { ?>
        <table class="adminlist">
        <thead>
            <tr>
                <th width="5">
                    <?php echo JText::_('ID'); ?>
                </th>
                <th width="20">
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                </th>
			    <th class="title">
				    <?php echo JHTML::_('grid.sort', 'Name', 'filename', @$this->lists['order_Dir'], @$this->lists['order']);?>
			    </th>
                <th class="title">
                    <?php echo JHTML::_('grid.sort', 'Title', 'title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="5">
                    <?php echo $this->lists['page']->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
<?php
$k = 0;
for ($i = 0, $n = count($this->items); $i < $n; $i++) {
    $row =& $this->items[$i];
    $fn = $row->folder.DS.$row->filename;
    $checked = JHTML::_('grid.id', $i, $fn, false, 'cid');
    $link = '<a rel="'.$fn.'" href="#" onclick="doEdit(this);">';
?>
            <tr class="<?php echo "row$k"; ?>">
                <td align="right"><?php echo $row->id;?></td>
                <td><?php echo $checked;?></td>
                <td><?php echo $link.$row->filename;?></a></td>
                <td><?php echo $link.$row->title;?></a></td>
            </tr>
<?php
$k = 1 - $k;
}
?>
        </tbody>
        </table>
<?php } else {
    echo JText::_('AVR_MSG_NO_PLAYLISTS');
} ?>
    </fieldset>
</div>
<input type="hidden" name="option" value="com_avreloaded" />
<input type="hidden" name="view" value="playlists" />
<input type="hidden" name="task" value="" />
<input type="hidden" id="efile" name="filename" value="" />
<input type="hidden" id="dfile" name="dfiles[]" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="playlists" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_('form.token'); ?>
</form>
