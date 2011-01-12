<? /** $Id: pie.php 462 2008-03-26 13:05:36Z mjaz $ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<?
// we don't need the red
@$color->set('red', null);

// get the chart
@$chart->title('');
@$chart->pie(60, '#FFFFFF', '{display: none;}', false);
@$chart->set_tool_tip( @text('Translated:').'<br>#x_label#: #val# '.@text('Items'));

$count = array(); $names = array();
foreach(@$data as $stat)
{
	$count[] = $stat->total;
	$names[] = $stat->name;
}
@$chart->pie_values($count, $names, array());
@$chart->pie_slice_colours( @$color->getSet() );