<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<ul class="mostread <?php echo $params->get('moduleclass_sfx'); ?>">
<?php foreach ($list as $item) : ?>
	<li class="clearfix">
		<a href="<?php echo $item->link; ?>"><?php echo $item->text; ?></a>
	</li>
<?php endforeach; ?>
</ul>