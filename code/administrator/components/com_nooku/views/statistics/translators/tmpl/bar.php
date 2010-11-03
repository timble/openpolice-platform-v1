<? /** $Id: bar.php 471 2008-04-11 10:57:00Z jinx $ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<?
// get the chart
@$chart->title(@text('Translator Activity'));

// Data
foreach(@$translators as $translator) {
 	@$chart->set_data( $this->data[$translator->user_id]->count );
   	@$chart->line( 2, $this->color->next(), $translator->name, 10 );
}

// Text
//set_x_label_style( $size, $colour='', $orientation=0, $step=-1, $grid_colour='')
@$chart->set_x_label_style( 10, '#909090', 2, -1, '#ADB5C7' );
@$chart->set_x_axis_steps( 1 );
@$chart->set_x_labels(@_formatDates(array_keys($this->dates)));
@$chart->set_x_legend(@$table_name ? KInflector::humanize(@$table_name).' '.@text('Table') : @text('All Tables'));

// Min, max and steps
$total = array();
foreach(@$translators as $translator) {
 	$total[] = $translator->total;
}

$max = KHelperMath::roundup(max($total), -1);

@$chart->set_y_max($max);
@$chart->set_y_min( 0 );
@$chart->set_y_label_steps( $max/5 );
@$chart->set_y_legend( @text('Items'), 14, '#000000' );