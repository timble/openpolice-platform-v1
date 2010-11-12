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
        alert("<?php echo JText::_('AVR_ERR_EMPTY_TAGNAME', true); ?>");
    } else if (!value.match(/^[\w-]+$/)) {
        alert('<?php echo JText::_("AVR_ERR_INVALID_TAGNAME", true); ?>');
    } else {
        submitform(pressbutton);
    }
}
function delprrow(obj) {
    var imgobj = obj;
    while (obj.getTag() != 'tr') {
        obj = obj.getParent();
    }
    var p = obj.getParent();
    imgobj.fireEvent('mouseleave'); // hide tooltip
    obj.remove();
    if (p.getChildren().length < 2) {
        var attr = {'id':'prtnone'};
        var s = new Element('span', attr);
        s.setHTML('<?php echo JText::_('AVR_LBL_NONE'); ?>,&nbsp;');
        s.injectBefore('nnb');
    }
}

function addprrow() {
    var tr = new Element('tr');
    var td = new Element('td');
    var attr = {
        'type': 'text',
        'name': 'pres[]',
        'size': '40',
        'maxlength': '255',
        'value': '',
        'class': 'text_area'
    };
    new Element('input', attr).injectInside(td);
    td.injectInside(tr);
    var td2 = new Element('td');
    attr = {
        'alt': '<?php echo $this->altarrow; ?>',
        'src': '<?php echo $this->imgarrow; ?>'
    };
    new Element('img', attr).injectInside(td2);
    td2.injectAfter(td);
    td = td2;
    td2 = new Element('td');
    attr = {
        'type': 'text',
        'name': 'prer[]',
        'size': '40',
        'maxlength': '255',
        'value': '',
        'class': 'text_area'
    };
    new Element('input', attr).injectInside(td2);
    td2.injectAfter(td);
    td = td2;
    td2 = new Element('td');
    attr = {
        'class': 'hasTip',
        'src': '<?php echo $this->imgdel; ?>',
        'alt': '',
        'title': '<?php echo JText::_('AVR_DSC_DELPPREP'); ?>'
    };
    var img = new Element('img', attr);
    img.injectInside(td2);
    img.addEvent('click', function(){delprrow(img);});
    td2.injectAfter(td);
    tr.injectAfter('prtfirst');
    var t = new Tips([img], {maxTitleChars: 50, fixed: false});
    var nr = $('prtnone');
    if (nr) {
        nr.remove();
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
            <label for="name" class="hasTip" title="<?php echo JText::_('AVR_LBL_TAGNAME');?>::<?php echo JText::_('AVR_DSC_TAGNAME');?>">
                    <?php echo JText::_('AVR_LBL_TAGNAME');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="name" id="name" size="20" maxlength="25"
                    value="<?php echo htmlspecialchars($this->tag->name);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="description" class="hasTip" title="<?php echo JText::_('AVR_LBL_TAGDESCRIPTION');?>::<?php echo JText::_('AVR_DSC_TAGDESCRIPTION');?>">
                    <?php echo JText::_('AVR_LBL_TAGDESCRIPTION');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="description" id="description" size="60" maxlength="255"
                    value="<?php echo htmlspecialchars($this->tag->description);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="version" class="hasTip" title="<?php echo JText::_('AVR_LBL_TAGVERSION');?>::<?php echo JText::_('AVR_DSC_TAGVERSION');?>">
                    <?php echo JText::_('AVR_LBL_TAGVERSION');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="version" id="version" size="10" maxlength="5"
                    value="<?php echo htmlspecialchars($this->tag->version);?>" />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="sampleregex" class="hasTip" title="<?php echo JText::_('AVR_LBL_TAGSREGEX');?>::<?php echo JText::_('AVR_DSC_TAGSREGEX');?>">
                    <?php echo JText::_('AVR_LBL_TAGSREGEX');?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="sampleregex" id="sampleregex" size="80" maxlength="255"
                    value="<?php echo htmlspecialchars($this->tag->sampleregex);?>" />
                <a href="http://devedge-temp.mozilla.org/library/manuals/2000/javascript/1.5/reference/regexp.html" target="_blank"><img class="hasTip" title="JavaScript RegEx documentation" style="border:0" src="<?php echo JURI::root();?>includes/js/ThemeOffice/tooltip.png" alt="JavaScript RegEx documentation" /></a>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="local" class="hasTip" title="<?php echo JText::_('AVR_LBL_TAGLOCAL');?>::<?php echo JText::_('AVR_DSC_TAGLOCAL');?>">
                    <?php echo JText::_('AVR_LBL_TAGLOCAL');?>:
                </label>
            </td>
            <td>
                <input type="checkbox" name="local" id="local" value="1"
                    <?php echo $this->tag->local ? 'checked="checked"' : ''; ?> />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="plist" class="hasTip" title="<?php echo JText::_('AVR_LBL_TAGPLIST');?>::<?php echo JText::_('AVR_DSC_TAGPLIST');?>">
                    <?php echo JText::_('AVR_LBL_TAGPLIST');?>:
                </label>
            </td>
            <td>
                <input type="checkbox" name="plist" id="lplist" value="1"
                    <?php echo $this->tag->plist ? 'checked="checked"' : ''; ?> />
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="player_id" class="hasTip" title="<?php echo JText::_('AVR_LBL_PLAYER');?>::<?php echo JText::_('AVR_DSC_PLAYER');?>">
                    <?php echo JText::_('AVR_LBL_PLAYER');?>:
                </label>
            </td>
            <td><?php echo $this->plist; ?></td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
            <label for="ripper_id" class="hasTip" title="<?php echo JText::_('AVR_LBL_RIPPER');?>::<?php echo JText::_('AVR_DSC_RIPPER');?>">
                    <?php echo JText::_('AVR_LBL_RIPPER');?>:
                </label>
            </td>
            <td><?php echo $this->rlist; ?></td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="prt" class="hasTip" title="<?php echo JText::_('AVR_LBL_TAGPOSTREPL');?>::<?php echo JText::_('AVR_DSC_TAGPOSTREPL');?>">
                    <?php echo JText::_('AVR_LBL_TAGPOSTREPL');?>:
                </label>
            </td>
            <td>
                 <?php echo $this->prtab; ?>
            </td>
        </tr>
    </table>
    </fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="com_avreloaded" />
<input type="hidden" name="id" value="<?php echo $this->tag->id;?>" />
<input type="hidden" name="cid[]" value="<?php echo $this->tag->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="tags" />
<?php echo JHTML::_('form.token'); ?>
</form>
