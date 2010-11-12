<?php defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); ?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {
    if (pressbutton == "cancel") {
        submitform(pressbutton);
        return;
    }
    // validation
    var value = document.adminForm.name.value;
    if (value == '') {
        alert("<?php echo JText::_('AVR_ERR_EMPTY_RIPPERNAME', true); ?>");
    } else if (!value.match(/^\w+$/)) {
        alert('<?php echo JText::_("AVR_ERR_INVALID_RIPPERNAME", true); ?>');
    } else {
        submitform(pressbutton);
    }
}
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
    <fieldset class="adminform">
        <legend><?php echo JText::_('Details');?></legend>
        <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
            <label for="name" class="hasTip" title="<?php echo JText::_('AVR_LBL_RIPPERNAME');?>::<?php echo JText::_('AVR_DSC_RIPPERNAME');?>">
                    <?php echo JText::_('AVR_LBL_RIPPERNAME');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="name" id="name" size="20" maxlength="25"
                    value="<?php echo htmlspecialchars($this->ripper->name);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="description" class="hasTip" title="<?php echo JText::_('AVR_LBL_RIPPERDESCRIPTION');?>::<?php echo JText::_('AVR_DSC_RIPPERDESCRIPTION');?>">
                    <?php echo JText::_('AVR_LBL_RIPPERDESCRIPTION');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="description" id="description" size="60" maxlength="255"
                    value="<?php echo htmlspecialchars($this->ripper->description);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="version" class="hasTip" title="<?php echo JText::_('AVR_LBL_RIPPERVERSION');?>::<?php echo JText::_('AVR_DSC_RIPPERVERSION');?>">
                    <?php echo JText::_('AVR_LBL_RIPPERVERSION');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="version" id="version" size="10" maxlength="4"
                    value="<?php echo htmlspecialchars($this->ripper->version);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="url" class="hasTip" title="<?php echo JText::_('AVR_LBL_RIPPERURL');?>::<?php echo JText::_('AVR_DSC_RIPPERURL');?>">
                    <?php echo JText::_('AVR_LBL_RIPPERURL');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="url" id="url" size="80" maxlength="255"
                    value="<?php echo htmlspecialchars($this->ripper->url);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="regex" class="hasTip" title="<?php echo JText::_('AVR_LBL_RIPPERREGEX');?>::<?php echo JText::_('AVR_DSC_RIPPERREGEX');?>">
                    <?php echo JText::_('AVR_LBL_RIPPERREGEX');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="regex" id="regex" size="80" maxlength="255"
                    value="<?php echo htmlspecialchars($this->ripper->regex);?>" />
                <a href="http://www.php.net/manual/en/regexp.reference.php" target="_blank"><img class="hasTip" title="PHP regex documentation" style="border:0" src="<?php echo JURI::root();?>includes/js/ThemeOffice/tooltip.png" alt="PHP regex documentation" /></a>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="cindex" class="hasTip" title="<?php echo JText::_('AVR_LBL_RIPPERCINDEX');?>::<?php echo JText::_('AVR_DSC_RIPPERCINDEX');?>">
                    <?php echo JText::_('AVR_LBL_RIPPERCINDEX');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="cindex" id="cindex" size="10" maxlength="4"
                    value="<?php echo htmlspecialchars($this->ripper->cindex);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="flags0" class="hasTip" title="<?php echo JText::_('AVR_LBL_RIPPERUDECODE');?>::<?php echo JText::_('AVR_DSC_RIPPERUDECODE');?>">
                    <?php echo JText::_('AVR_LBL_RIPPERUDECODE');?>:
                </label>
            </td>
            <td>
                <input type="checkbox" id="flags0" name="flags0"
                value="<?php echo ($this->ripper->flags & 1); ?>" />
            </td>
        </tr>
    </table>
    </fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="com_avreloaded" />
<input type="hidden" name="id" value="<?php echo $this->ripper->id;?>" />
<input type="hidden" name="cid[]" value="<?php echo $this->ripper->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="rippers" />
<?php echo JHTML::_('form.token'); ?>
</form>
