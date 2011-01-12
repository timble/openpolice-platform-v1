<? /** $Id:default.php 222 2007-12-13 21:48:32Z mjaz $ */ ?>
<? defined('_JEXEC') or die; ?>

<? @helper('stylesheet', 'grid.css', Nooku::getURL('css')); ?>

<form action="<?= @route()?>" method="post" name="adminForm">
    <table>
        <tr>
            <td align="left" width="100%">
                <?= @text('SEARCH'); ?>
                <input id="search" name="filter" value="<?= @$filters['filter']; ?>" />
                <button onclick="this.form.submit();"><?= @text('SEARCH'); ?></button>
                <button onclick="document.getElementById('search').value='';this.form.submit();"><?= @text('RESET'); ?></button>
            </td>
            <td nowrap="nowrap">
                <? $attribs = array('class' => 'inputbox', 'size' => '1', 'onchange' => 'document.adminForm.submit();'); ?>
                <?= @helper('nooku.select.tables',     @$filters['table_name'], 'filter_table_name', $attribs, 'table_name', true); ?>
                <?= @helper('nooku.select.languages',  @$filters['iso_code'],   'filter_iso_code',   $attribs, 'iso_code', true); ?>
                <?= @helper('nooku.select.statuses',   @$filters['status'],     'filter_status',     $attribs, 'status', true); ?>
                <?= @helper('nooku.select.translators',@$filters['translator'], 'filter_translator', $attribs, 'translator', true); ?>
            </td>
        </tr>
    </table>

    <table class="adminlist" style="clear: both;">
        <thead>
            <tr>
                <th width="5">
                    <?= @text('NUM'); ?>
                </th>
                <th width="20">
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count(@$items); ?>);" />
                </th>
                <th class="title">
                    <?= @helper('grid.sort',   'Table', 'table_name', @$filters['direction'], @$filters['order'] ); ?>
                </th>
                <th class="title" width="5">
                    <?= @text('Id'); ?>
                </th>
                <th class="title" width="31px">
                    <?= @helper('grid.sort',   'ISO Code', 'iso_code', @$filters['direction'], @$filters['order'] ); ?>
                </th>
                <th class="title">
                    <?= @helper('grid.sort',   'Title', 'title', @$filters['direction'], @$filters['order'] ); ?>
                </th>
                <th class="title" width="70">
                    <?= @helper('grid.sort',   'Status', 'status', @$filters['direction'], @$filters['order'] ); ?>
                </th>
                <th class="title">
                    <?= @helper('grid.sort',   'Created by', 'created_by_name', @$filters['direction'], @$filters['order'] ); ?>
                </th>
                <th class="title">
                    <?= @helper('grid.sort',   'Modified by', 'modified_by_name', @$filters['direction'], @$filters['order'] ); ?>
                </th>
                 <th class="title" width="120">
                    <?= @helper('grid.sort',   'Created', 'created', @$filters['direction'], @$filters['order'] ); ?>
                </th>
                 <th class="title" width="120">
                    <?= @helper('grid.sort',   'Modified', 'modified', @$filters['direction'], @$filters['order'] ); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?= @$group_tables ? @template('tbody_groupitems') : @template('tbody');?>
            <? if (!count(@$items)) : ?>
            <tr>
                <td colspan="20" align="center">
                    <?= @text('No items found'); ?>
                </td>
            </tr>
            <? endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="20">
                    <?= @$pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <input type="hidden" name="controller" value="statistics" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?= @$filters['order']; ?>" />
    <input type="hidden" name="filter_direction" value="<?= @$filters['direction']; ?>" />
</form>