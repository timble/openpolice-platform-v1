<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php
if( $feed != false )
{
	$actualItems 	= count( $feed->items );
	$setItems    	= $params->get('rssitems', 5);
	$account    	= $params->get('account', '');

	if ($setItems > $actualItems) {
		$totalItems = $actualItems;
	} else {
		$totalItems = $setItems;
	}
		for ($j = 0; $j < $totalItems; $j ++)
		{
			$currItem = & $feed->items[$j];
			// item title
			?>
			<p>
			<?php
				// item description
				$text = $currItem->get_description();
				$text = str_replace('&apos;', "'", $text);
				?>
				<?php echo $text; ?>
			</p>
			<?php
		}
	} ?>
<p><?php echo JText::_( 'Follow us on' ); ?> <a href="http://twitter.com/<?php echo $account ?>">twitter.com/<?php echo $account ?></a></p>