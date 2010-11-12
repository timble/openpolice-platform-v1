<?php defined('_JEXEC') or die('Restricted access'); ?>
<script language="javascript" type="text/javascript">
// <![CDATA[
function submitbutton(pressbutton) {
    if (pressbutton == "remove") {
        if (!confirm('<?php echo JText::_('AVR_ASK_REALLYDELETE', true); ?>'))
            return;
    }
    submitform(pressbutton);
}
// ]]>
</script>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
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
				<?php echo JHTML::_('grid.sort', 'Name', 't.name', @$this->lists['order_Dir'], @$this->lists['order']);?>
			</th>
            <th class="title">
                <?php echo JHTML::_('grid.sort', 'Description', 't.description', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
            </th>
            <th class="title" width="10%">
                <?php echo JHTML::_('grid.sort', 'Player', 'player', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
            </th>
            <th class="title" width="10%">
                <?php echo JHTML::_('grid.sort', 'Ripper', 'ripper', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
            </th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="6">
                <?php echo $this->lists['page']->getListFooter(); ?>
            </td>
        </tr>
    </tfoot>
    <tbody>
<?php
$k = 0;
for ($i = 0, $n = count($this->items); $i < $n; $i++) {
    $row =& $this->items[$i];
    $checked = JHTML::_('grid.id', $i, $row->id, 0);
    $link = JRoute::_('index.php?option=com_avreloaded&controller=tags&task=edit&cid[]='.$row->id);
?>
        <tr class="<?php echo "row$k"; ?>">
            <td align="right"><?php echo $row->id;?></td>
            <td><?php echo $checked;?></td>
            <td><a href="<?php echo $link; ?>"><?php echo $row->name;?></a></td>
            <td><a href="<?php echo $link; ?>"><?php echo $row->description;?></a></td>
            <td><?php echo $row->player;?></td>
            <td><?php echo $row->ripper;?></td>
        </tr>
<?php
$k = 1 - $k;
}
?>
    </tbody>
    </table>
</div>
<input type="hidden" name="option" value="com_avreloaded" />
<input type="hidden" name="view" value="tags" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="tags" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_('form.token'); ?>
</form>
