<!-- AVRSYS_DISABLE --><!-- PLG_CLIPBOARD_DISABLE --><?php
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php<?php echo (empty($this->data['e_name']) ? '' : ('?e_name='.$this->data['e_name'])); ?>"
    method="post" name="adminForm" id="adminForm">
<div class="col100">
    <fieldset class="adminform">
        <legend><?php echo JText::_('AVR_TITLE_INSERT');?></legend>
<?php echo $this->pane->startPane("menu-pane").$this->pane->startPanel(JText::_('AVR_TITLE_REMOTEMEDIA'), "remote-page"); ?>
        <table class="admintable" width="100%">
        <tr>
            <td class="key"><?php $this->v->lbl('url'); ?></td>
            <td>
                <input class="text_area" type="text" name="url" id="url" size="70" maxlength="1024"
                    onchange="return avri.matchURL(this.value);" onkeydown="if(event.keyCode==13) return avri.matchURL(this.value);"
                    value="<?php echo $this->data['url']; ?>" /></td>
        </tr>
        <tr>
            <td class="key"><?php $this->v->lbl('provider'); ?></td>
            <td>
                <?php echo $this->data['provider'];?>
            </td>
        </tr>
        <tr>
            <td class="key"><?php $this->v->lbl('tagid'); ?></td>
            <td>
                <input class="text_area" type="text" name="tagid" id="tagid" size="50" maxlength="1024"
                    onchange="return avri.buildTag(0);" onkeydown="if(event.keyCode==13) return avri.buildTag(0);"
                    value="<?php echo $this->data['tagid']; ?>" />
            </td>
        </tr>
        <tr>
            <td class="key"><?php $this->v->lbl('width'); ?></td>
            <td>
                <input class="text_area" type="text" name="width" id="width" size="10" maxlength="4" 
                    onchange="return avri.buildTag(0);" onkeydown="if(event.keyCode==13) return avri.buildTag(0);"
                    value="<?php echo $this->data['width']; ?>" />
            </td>
        </tr>
        <tr>
            <td class="key"><?php $this->v->lbl('height'); ?></td>
            <td>
                <input class="text_area" type="text" name="height" id="height" size="10" maxlength="4"
                    onchange="return avri.buildTag(0);" onkeydown="if(event.keyCode==13) return avri.buildTag(0);"
                    value="<?php echo $this->data['height']; ?>" />
            </td>
        </tr>
        <tr>
            <td class="key"><?php $this->v->lbl('mtag'); ?></td>
            <td>
                <input class="text_area" type="text" name="mtag" id="mtag" size="50" maxlength="1024"
                    onchange="return avri.checkTag(0);" onkeydown="if(event.keyCode==13) return avri.checkTag(0);"
                value="<?php echo $this->data['mtag']; ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="float: right">
                    <button type="button" id="pv" onclick="avri.onpreview(0);"
                        ><?php echo JText::_('Preview') ?></button>
                    <button type="button" id="ins"
                        onclick="avri.onok(0);window.parent.document.getElementById('sbox-window').close();"
                        ><?php echo JText::_('AVR_LBL_INSERT') ?></button>
                    <button type="button"
                        onclick="window.parent.document.getElementById('sbox-window').close();"
                        ><?php echo JText::_('Cancel') ?></button>
                </div>
            </td>
        </tr>
    </table>
<?php echo $this->pane->endPanel().$this->pane->startPanel(JText::_('AVR_TITLE_LOCALMEDIA'), "local-page"); ?>
    <table class="admintable" width="100%">
        <tr>
            <td class="key"><?php $this->v->lbl('mloc'); ?></td>
            <td>
                <?php echo $this->data['mselector']; ?>
            </td>
        </tr>
        <tr>
            <td class="key"><?php $this->v->lbl('lprovider'); ?></td>
            <td>
                <?php echo $this->data['lprovider'];?>
            </td>
        </tr>
        <tr>
            <td class="key"><?php $this->v->lbl('ltagid'); ?></td>
            <td>
                <input class="text_area" type="text" name="ltagid" id="ltagid" size="50" maxlength="1024"
                    onchange="return avri.buildTag(1);" onkeydown="if(event.keyCode==13) return avri.buildTag(1);"
                    value="<?php echo $this->data['ltagid']; ?>" />
            </td>
        </tr>
        <tr>
            <td class="key"><?php $this->v->lbl('lwidth'); ?></td>
            <td>
                <input class="text_area" type="text" name="lwidth" id="lwidth" size="10" maxlength="4" 
                    onchange="return avri.buildTag(1);" onkeydown="if(event.keyCode==13) return avri.buildTag(1);"
                    value="<?php echo $this->data['lwidth']; ?>" />
            </td>
        </tr>
        <tr>
            <td class="key"><?php $this->v->lbl('lheight'); ?></td>
            <td>
                <input class="text_area" type="text" name="lheight" id="lheight" size="10" maxlength="4"
                    onchange="return avri.buildTag(1);" onkeydown="if(event.keyCode==13) return avri.buildTag(1);"
                    value="<?php echo $this->data['lheight']; ?>" />
            </td>
        </tr>
        <tr>
            <td class="key"><?php $this->v->lbl('lmtag'); ?></td>
            <td>
                <input class="text_area" type="text" name="lmtag" id="lmtag" size="50" maxlength="1024"
                    onchange="return avri.checkTag(1);" onkeydown="if(event.keyCode==13) return avri.checkTag(1);"
                value="<?php echo $this->data['lmtag']; ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="float: right">
                    <button type="button" id="lpv" onclick="avri.onpreview(1);"
                        ><?php echo JText::_('Preview') ?></button>
                    <button type="button" id="lins"
                        onclick="avri.onok(1);window.parent.document.getElementById('sbox-window').close();"
                        ><?php echo JText::_('AVR_LBL_INSERT') ?></button>
                    <button type="button"
                        onclick="window.parent.document.getElementById('sbox-window').close();"
                        ><?php echo JText::_('Cancel') ?></button>
                </div>
            </td>
        </tr>
    </table>
<?php echo $this->pane->endPanel().$this->pane->endPane(); ?>
    <p align="center"><?php echo JText::_('Preview') ?></p>
    <div style="background-color: #DDD; width:100%" id="preview">
        <p align="center"><?php echo $this->data['mediacode']; ?></p>
    </div>
    </fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="com_avreloaded" />
<input type="hidden" name="view" value="insert" />
<input type="hidden" name="tmpl" value="component" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="local" id="local" value="<?php echo $this->data['local']; ?>" />
<input type="hidden" name="playlist" value="<?php echo $this->data['playlist']; ?>" />
<input type="hidden" name="noplists" value="<?php echo $this->data['noplists']; ?>" />
<?php echo JHTML::_('form.token'); ?>
</form>
