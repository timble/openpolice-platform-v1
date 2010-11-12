<?php defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); ?>
<script language="javascript" type="text/javascript">
// <![CDATA[
function submitbutton(pressbutton) {
    if (pressbutton == "remove") {
        if (!confirm('<?php echo JText::_('AVR_ASK_REALLYDELETE', true); ?>'))
            return;
    }
    if (pressbutton == "edit") {
        var i;
        for (i = 0; true; i++) {
            var cb = $('cb'+i);
            if (cb == null) {
                break;
            }
            if (cb.checked) {
                $('track').value = cb.value;
                break;
            }
        }
    }
    submitform(pressbutton);
}
function doEdit(elem) {
    $('track').value = elem.getAttribute('rel');
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
                <td width="100" align="right" class="key">
                    <label for="title" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_PLSTITLE');?>::<?php 
                        echo JText::_('AVR_DSC_PLSTITLE');?>"><?php
                        echo JText::_('AVR_LBL_PLSTITLE');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="title" id="title" size="60"
                        value="<?php echo htmlspecialchars($this->data->title);?>" />
                </td>
                <td width="100" align="right" class="key">
                    <label for="info" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_PLSINFO');?>::<?php 
                        echo JText::_('AVR_DSC_PLSINFO');?>"><?php
                        echo JText::_('AVR_LBL_PLSINFO');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="info" id="info" size="60"
                        value="<?php echo htmlspecialchars($this->data->info);?>" />
                </td>
            </tr>
            <tr>
                <td width="100" align="right" class="key">
                    <label for="creator" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_PLSCREATOR');?>::<?php 
                        echo JText::_('AVR_DSC_PLSCREATOR');?>"><?php
                        echo JText::_('AVR_LBL_PLSCREATOR');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="creator" id="creator" size="60"
                        value="<?php echo htmlspecialchars($this->data->creator);?>" />
                </td>
                <td width="100" align="right" class="key">
                    <label for="license" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_PLSLICENSE');?>::<?php 
                        echo JText::_('AVR_DSC_PLSLICENSE');?>"><?php
                        echo JText::_('AVR_LBL_PLSLICENSE');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="license" id="license" size="60"
                        value="<?php echo htmlspecialchars($this->data->license);?>" />
                </td>
            </tr>
            <tr>
                <td width="100" align="right" class="key">
                    <label for="annotation" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_PLSCOMMENT');?>::<?php 
                        echo JText::_('AVR_DSC_PLSCOMMENT');?>"><?php
                        echo JText::_('AVR_LBL_PLSCOMMENT');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="annotation" id="annotation" size="60"
                        value="<?php echo htmlspecialchars($this->data->annotation);?>" />
                </td>
                <td width="100" align="right" class="key">
                    <label for="attribution" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_PLSATTRIBUTION');?>::<?php 
                        echo JText::_('AVR_DSC_PLSATTRIBUTION');?>"><?php
                        echo JText::_('AVR_LBL_PLSATTRIBUTION');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="attribution" id="attribution" size="60"
                        value="<?php echo htmlspecialchars($this->data->attribution);?>" />
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="adminform">
        <legend><?php echo JText::_('AVR_TITLE_TRACKS');?></legend>
<?php if (count($this->items)) { ?>
        <table class="adminlist">
        <thead>
            <tr>
                <th width="20">
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                </th>
                <th nowrap="nowrap" width="90px">
                    <?php echo JHTML::_('grid.sort', 'Order by', 'index', @$this->lists['order_Dir'], @$this->lists['order']
); ?>
                    <?php echo JHTML::_('grid.order', $this->items); ?>
                </th>
			    <th class="title">
				    <?php echo JHTML::_('grid.sort', 'Title', 'title', @$this->lists['order_Dir'], @$this->lists['order']);?>
			    </th>
                <th class="title">
                    <?php echo JHTML::_('grid.sort', 'Author', 'author', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
                </th>
                <th class="title">
                    <?php echo JHTML::_('grid.sort', 'URL', 'file', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
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
    $checked = JHTML::_('grid.id', $i, $row->index - 1, 0);
    $link = '<a rel="'.base64_encode(serialize($row)).'" href="#" onclick="doEdit(this);">';
?>
            <tr class="<?php echo "row$k"; ?>">
                <td><?php echo $checked;?></td>
                <td class="order">
                    <span><?php echo $this->lists['page']->orderUpIcon($i, ($i > 0), 'orderup', 'Move Up', 1); ?></span>
                    <span><?php echo $this->lists['page']->orderDownIcon($i, $n, ($i < $n), 'orderdown', 'Move Down', 1); ?></span>
                    <input type="text" name="order[]" size="5" value="<?php echo $row->index; ?>" class="text_area" style="text-align: center" />
                </td>
                <td><?php echo $link.$row->title;?></a></td>
                <td><?php echo $link.$row->author;?></a></td>
                <td><?php echo $link.$row->file;?></a></td>
            </tr>
<?php
$k = 1 - $k;
}
?>
        </tbody>
        </table>
<?php 
} else {
    echo JText::_('AVR_MSG_NO_TRACKS');
}
 ?>
    </fieldset>
</div>
<input type="hidden" name="option" value="com_avreloaded" />
<input type="hidden" name="view" value="playlist" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="filename" value="<?php echo htmlspecialchars($this->data->filename); ?>" />
<input type="hidden" id="track" name="track" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="playlist" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<input type="hidden" name="data" value="<?php echo base64_encode(serialize($this->data)); ?>" />
<?php echo JHTML::_('form.token'); ?>
</form>
