<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="page-header">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>
<div class="article description clearfix">	
	<p>
	<?php if ( isset($this->newsfeed->image['url']) && isset($this->newsfeed->image['title']) && $this->params->get( 'show_feed_image' ) ) : ?>
		<img src="<?php echo $this->newsfeed->image['url']; ?>" alt="<?php echo $this->newsfeed->image['title']; ?>" />
	<?php endif; ?>
	
	<?php if ( $this->params->get( 'show_feed_description' ) ) : ?>
		<?php echo str_replace('&apos;', "'", $this->newsfeed->channel['description']); ?>
	<?php endif; ?>
	</p>
	
	<p>
		<a href="<?php echo $this->newsfeed->channel['link']; ?>" target="_blank">
			<?php echo str_replace('&apos;', "'", $this->newsfeed->channel['title']); ?>
		</a>
	</p>
</div>

<?php foreach ( $this->newsfeed->items as $item ) :  ?>
	<div class="article separator clearfix">
		<h2><?php echo $item->get_title(); ?></h2>
		<?php if ( $this->params->get( 'show_item_description' ) && $item->get_description()) : ?>
			<?php $text = $this->limitText($item->get_description(), $this->params->get( 'feed_word_count' ));
				echo str_replace('&apos;', "'", $text);
			?>
		<?php endif; ?>
		<?php if ( !is_null( $item->get_link() ) ) : ?>
			<p>
				<em>Source: <a href="<?php echo $item->get_link(); ?>" target="_blank">
				<?php echo $item->get_title(); ?></a></em>
			</p>
		<?php endif; ?>
	</div>
<?php endforeach; ?>