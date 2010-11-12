<?php defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); ?>
<script language="javascript" type="text/javascript">
// <![CDATA[
function submitbutton(pressbutton) {
    if (pressbutton == "save") {
        var fn = $('file').value;
        if (fn.match(/^\s*$/)) {
            alert('<?php echo JText::_('AVR_ERR_TRKFILEEMPTY', true);?>');
            return;
        }
        if (($('type').value == 'rtmp') || fn.match(/^rtmp:/)) {
            if ($('id').value.match(/^\s*$/)) {
                alert('<?php echo JText::_('AVR_ERR_TRKSIDEMPTY', true);?>');
                return;
            }
        }
    }
    submitform(pressbutton);
}

function plinsert(txt) {
    var lre = /^local:(.*)/;
    var match = lre.exec(txt);
    if (match) {
        txt = match[1];
        txt = ((txt.match(/\.mp3$/)) ? '<?php echo $this->aloc;?>' : '<?php echo $this->vloc;?>') + txt;
    }
    $('file').value = txt;
}

function jInsertEditorText(tag, editor) {
    var lre = /src\s*=\s*"([^"]+)"/;
    var match = lre.exec(tag);
    if (match) {
        $('image').value = '<?php echo $this->root;?>' + match[1];
    }
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
                    <label for="title" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_TRKTITLE');?>::<?php 
                        echo JText::_('AVR_DSC_TRKTITLE');?>"><?php
                        echo JText::_('AVR_LBL_TRKTITLE');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="title" id="title" size="60"
                        value="<?php echo htmlspecialchars($this->track->title);?>" />
                </td>
            </tr>
            <tr>
                <td class="key">
                    <label for="author" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_TRKAUTHOR');?>::<?php 
                        echo JText::_('AVR_DSC_TRKAUTHOR');?>"><?php
                        echo JText::_('AVR_LBL_TRKAUTHOR');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="author" id="author" size="60"
                        value="<?php echo htmlspecialchars($this->track->author);?>" />
                </td>
            </tr>
            <tr>
                <td class="key">
                    <label for="category" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_TRKCATEGORY');?>::<?php 
                        echo JText::_('AVR_DSC_TRKCATEGORY');?>"><?php
                        echo JText::_('AVR_LBL_TRKCATEGORY');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="category" id="category" size="60"
                        value="<?php echo htmlspecialchars($this->track->category);?>" />
                </td>
            </tr>
            <tr>
                <td class="key">
                    <label for="file" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_TRKFILE');?>::<?php 
                        echo JText::_('AVR_DSC_TRKFILE');?>"><?php
                        echo JText::_('AVR_LBL_TRKFILE');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="file" id="file" size="100"
                    value="<?php echo htmlspecialchars($this->track->file);?>" />
                </td>
                <td><?php echo $this->mbutton;?></td>
            </tr>
            <tr>
                <td class="key">
                    <label for="type" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_TRKTYPE');?>::<?php 
                        echo JText::_('AVR_DSC_TRKTYPE');?>"><?php
                        echo JText::_('AVR_LBL_TRKTYPE');?>:</label>
                </td>
                <td><?php echo $this->types; ?></td>
            </tr>
            <tr>
                <td class="key">
                    <label for="link" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_TRKLINK');?>::<?php 
                        echo JText::_('AVR_DSC_TRKLINK');?>"><?php
                        echo JText::_('AVR_LBL_TRKLINK');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="link" id="license" size="100"
                        value="<?php echo htmlspecialchars($this->track->link);?>" />
                </td>
            </tr>
            <tr>
                <td class="key">
                    <label for="captions" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_TRKCAPTIONS');?>::<?php 
                        echo JText::_('AVR_DSC_TRKCAPTIONS');?>"><?php
                        echo JText::_('AVR_LBL_TRKCAPTIONS');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="captions" id="captions" size="100"
                        value="<?php echo htmlspecialchars($this->track->captions);?>" />
                </td>
            </tr>
            <tr>
                <td class="key">
                    <label for="audio" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_TRKAUDIO');?>::<?php 
                        echo JText::_('AVR_DSC_TRKAUDIO');?>"><?php
                        echo JText::_('AVR_LBL_TRKAUDIO');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="audio" id="audio" size="100"
                        value="<?php echo htmlspecialchars($this->track->audio);?>" />
                </td>
            </tr>
            <tr>
                <td class="key">
                    <label for="id" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_TRKID');?>::<?php 
                        echo JText::_('AVR_DSC_TRKID');?>"><?php
                        echo JText::_('AVR_LBL_TRKID');?>:</label>
                </td>
                <td>
                    <input class="text_area" type="text" name="id" id="id" size="60"
                        value="<?php echo htmlspecialchars($this->track->id);?>" />
                </td>
            </tr>
            <tr>
                <td class="key">
                    <label for="image" class="hasTip" title="<?php
                        echo JText::_('AVR_LBL_TRKIMAGE');?>::<?php 
                        echo JText::_('AVR_DSC_TRKIMAGE');?>"><?php
                        echo JText::_('AVR_LBL_TRKIMAGE');?>:</label>
                </td>
                <td nowrap="nowrap">
                    <input class="text_area" type="text" name="image" id="image" size="100"
                        value="<?php echo htmlspecialchars($this->track->image);?>" />
                </td>
                <td><?php echo $this->ibutton;?></td>
            </tr>
        </table>
    </fieldset>
</div>
<input type="hidden" name="option" value="com_avreloaded" />
<input type="hidden" name="view" value="track" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="index" value="<?php echo $this->track->index;?>" />
<input type="hidden" name="data" value="<?php echo $this->data;?>" />
<input type="hidden" name="controller" value="track" />
<?php echo JHTML::_('form.token'); ?>
</form>
