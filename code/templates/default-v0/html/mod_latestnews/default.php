<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<ul class="latestnews <?php echo $params->get('moduleclass_sfx'); ?>">
<?php foreach ($list as $item) :  ?>
	<li class="clearfix">
		<span><?php echo JHTML::_('date',  $item->publish_up, JText::_('%d-%m') ); ?></span>
		<a href="<?php echo $item->link; ?>"><?php echo $item->text; ?></a>
	</li>
<?php endforeach; ?>
</ul>