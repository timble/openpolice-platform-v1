<? /** $Id: pie.php 550 2008-06-29 15:14:54Z mathias $ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<?
// little hack to skip the first color
@$color->next();
@$color->next();

//we don't need to show the totals
unset(@$data['ALL']['TOTAL']);
unset(@$data['ALL']['ORIGINAL']);
unset(@$data['ALL']['DELETED']);

@$chart->title('');
@$chart->pie(60, '#FFFFFF', '{display: none;}', false);
@$chart->set_tool_tip( @text('Progress:').'<br>#x_label#: #val# '.@text('Items'));

// send labels through JText
$labels = array_filter(array_keys(@$data['ALL']), array('JText', '_'));

// TODO add links
@$chart->pie_values(@$data['ALL'], $labels, array());

@$chart->pie_slice_colours( array(
		@$color->get('green'),
		@$color->get('red'),
		@$color->get('yellow')
));