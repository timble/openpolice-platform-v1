<? /** $Id: default.php 731 2008-09-25 15:55:25Z Johan $ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<? @helper('script', 'view.statistics.js', Nooku::getURL('js')); ?>
<? @helper('behavior.tooltip'); ?>

<form name="statstranslators_form">
    <input type="hidden" name="option" value="com_nooku" />
    <input type="hidden" name="format" value="openflashchart" />
    <input type="hidden" name="layout" value="bar" />
    <div style="float:left">
        <?= @text('Graph');?>:
        <?
        $arr = array(
            @helper('select.option', 'statistics.translations', @text('Translation Progress')),
            @helper('select.option', 'statistics.translators', @text('Translator Activity'))
        );
        echo @helper('select.genericlist', $arr, 'view', array('class'=>'inputbox statistics_filter'), 'value', 'text', 'statistics.'.@$graph);
        ?>
    </div>

    <div id="filters" style="float:right">
        <?= @text('Filter');?>:
        <?= @helper('nooku.select.tables', @$table_name, 'table_name', array('class' => 'inputbox statistics_filter', 'size' => '1'), '', true);?>
        <?= @helper('nooku.select.months', @$month, 'month',  array('class' => 'inputbox statistics_filter', 'size' => '1', 'disabled'=>'disabled') );?>
        <?= @helper('nooku.select.years', @$year, date('Y')-10, date('Y'), 'year',  array('class' => 'inputbox statistics_filter', 'size' => '1', 'disabled'=>'disabled') );?>
    </div>

    <?= @helper('openflashchart.swfobject', @{@graph}, 'graph_flash');?>
</form>
<div class="clr"></div>