<?php defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); ?>
<script language="javascript" type="text/javascript">
// <![CDATA[
function submitbutton(pressbutton) {
    if (pressbutton == "cancel") {
        submitform(pressbutton);
        return;
    }
    // validation
    var value = document.adminForm.name.value;
    if (value == '') {
        alert("<?php echo JText::_('AVR_ERR_EMPTY_PLAYERNAME', true); ?>");
    } else if (!value.match(/^\w+$/)) {
        alert('<?php echo JText::_("AVR_ERR_INVALID_PLAYERNAME", true); ?>');
    } else {
        submitform(pressbutton);
    }
}
// ]]>
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
    <fieldset class="adminform">
        <legend><?php echo JText::_('Details');?></legend>
        <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
            <label for="name" class="hasTip" title="<?php echo JText::_('AVR_LBL_PLAYERNAME');?>::<?php echo JText::_('AVR_DSC_PLAYERNAME');?>">
                    <?php echo JText::_('AVR_LBL_PLAYERNAME');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="name" id="name" size="20" maxlength="25"
                    value="<?php echo htmlspecialchars($this->player->name);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="description" class="hasTip" title="<?php echo JText::_('AVR_LBL_PLAYERDESCRIPTION');?>::<?php echo JText::_('AVR_DSC_PLAYERDESCRIPTION');?>">
                    <?php echo JText::_('AVR_LBL_PLAYERDESCRIPTION');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="description" id="description" size="60" maxlength="255"
                    value="<?php echo htmlspecialchars($this->player->description);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="version" class="hasTip" title="<?php echo JText::_('AVR_LBL_PLAYERVERSION');?>::<?php echo JText::_('AVR_DSC_PLAYERVERSION');?>">
                    <?php echo JText::_('AVR_LBL_PLAYERVERSION');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="version" id="version" size="5" maxlenght="5"
                    value="<?php echo htmlspecialchars($this->player->version);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="minw" class="hasTip" title="<?php echo JText::_('AVR_LBL_PLAYERMINW');?>::<?php echo JText::_('AVR_DSC_PLAYERMINW');?>">
                    <?php echo JText::_('AVR_LBL_PLAYERMINW');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="minw" id="minw" size="5" maxlenght="5"
                    value="<?php echo htmlspecialchars($this->player->minw);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="minh" class="hasTip" title="<?php echo JText::_('AVR_LBL_PLAYERMINH');?>::<?php echo JText::_('AVR_DSC_PLAYERMINH');?>">
                    <?php echo JText::_('AVR_LBL_PLAYERMINH');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="minh" id="minh" size="5" maxlenght="5"
                    value="<?php echo htmlspecialchars($this->player->minh);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="isjw" class="hasTip" title="<?php echo JText::_('AVR_LBL_PLAYERISJW');?>::<?php echo JText::_('AVR_DSC_PLAYERISJW');?>">
                    <?php echo JText::_('AVR_LBL_PLAYERISJW');?>:
                </label>
            </td>
            <td>
                <input type="checkbox" name="isjw" id="isjw" value="1"
                    <?php echo $this->player->isjw ? 'checked="checked"' : ''; ?> />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="code" class="hasTip" title="<?php echo JText::_('AVR_LBL_PLAYERCODE');?>::<?php echo JText::_('AVR_DSC_PLAYERCODE');?>">
                    <?php echo JText::_('AVR_LBL_PLAYERCODE');?>:
                </label>
            </td>
            <td>
                <textarea class="text_area" name="code" id="code" rows="15" cols="80"
                ><?php echo htmlspecialchars($this->player->code);?></textarea>
            </td>
        </tr>
    </table>
    </fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="com_avreloaded" />
<input type="hidden" name="id" value="<?php echo $this->player->id;?>" />
<input type="hidden" name="cid[]" value="<?php echo $this->player->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="players" />
<?php echo JHTML::_('form.token'); ?>
</form>
