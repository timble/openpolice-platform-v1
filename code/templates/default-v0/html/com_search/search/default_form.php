<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<form id="filter" action="<?php echo JRoute::_( 'index.php?option=com_search' );?>" method="post" name="searchForm">
	<div class="well">
		<div class="group">
			<input type="text" name="searchword" id="search" size="30" maxlength="20" value="<?php echo $this->escape($this->searchword); ?>" class="search-input" />
			<button name="Search" onclick="this.form.submit()" class="search-button btn primary"><?php echo JText::_( 'Search' );?></button>
			<input type="hidden" name="task"   value="search" />
		</div>
		<div class="small"><?php echo $this->result; ?></div>
	</div>
</form>

<?php if($this->total == 0) : ?>
<?php echo JText::_('No results found') ?>
<?php endif; ?>
