<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php foreach( $this->results as $result ) : ?>
<div class="article separator">
	<h2><a href="<?php echo JRoute::_($result->href); ?>"><?php echo $this->escape($result->title); ?></a></h2>
		<p>
			<?php echo $result->text; ?>
		</p>
</div>
<?php endforeach; ?>

<div id="pagination-wrap" class="search-bottom">
	<div class="pagination-links">
		
	</div>
	<?php echo $this->pagination->getPagesLinks( ); ?>
</div>