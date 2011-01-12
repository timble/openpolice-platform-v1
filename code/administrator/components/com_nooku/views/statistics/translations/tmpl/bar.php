<? /** $Id: bar.php 567 2008-07-07 23:22:39Z mathias $ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<?
// get the chart
@$chart->title(@text('Translation Progress'));

// Data
@$chart->set_data( @$data['MISSING'] );
@$chart->bar_3D( 75, @$color->get('red'), @text('Missing'), 10 );

@$chart->set_data( @$data['OUTDATED'] );
@$chart->bar_3D( 75, @$color->get('yellow'), @text('Outdated'), 10 );

@$chart->set_data( @$data['COMPLETED'] );
@$chart->bar_3D( 75, @$color->get('green'), @text('Completed'), 10 );

@$chart->set_data( @$data['ORIGINAL'] );
@$chart->bar_3D( 75, @$color->get('blue'), @text('Original'), 10 );

// Text
$labels = KHelperArray::getColumn(@$languages, 'name');
@$chart->set_x_labels( $labels );
@$chart->set_x_legend(@$table_name ? KInflector::humanize(@$table_name).' '.@text('Table') : @text('All Tables'));

// Min, max and steps
$max = KHelperMath::roundup(max(@$data['TOTAL']), -1);
@$chart->set_y_max($max);
@$chart->set_y_min( 0 );
@$chart->set_y_label_steps( $max/10 );
@$chart->set_y_legend( @text('Items'), 14, '#000000' );