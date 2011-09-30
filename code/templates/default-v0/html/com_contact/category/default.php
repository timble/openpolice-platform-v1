<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php $cparams =& JComponentHelper::getParams('com_media'); ?>
<div class="page-header">
	<h1>
	    <?php echo $this->escape($this->params->get('page_title')); ?>
	</h1>
</div>
<div class="article clearfix">
<?php if ($this->category->image || $this->category->description) : ?>
	<?php if ($this->params->get('image') != -1 && $this->params->get('image') != '') : ?>
		<img src="<?php echo $this->baseurl .'/'. 'images/stories' . '/'. $this->params->get('image'); ?>" align="<?php echo $this->params->get('image_align'); ?>" hspace="6" alt="<?php echo JText::_( 'Contacts' ); ?>" />
	<?php elseif ($this->category->image) : ?>
		<img src="<?php echo $this->baseurl .'/'. 'images/stories' . '/'. $this->category->image; ?>" align="<?php echo $this->category->image_position; ?>" hspace="6" alt="<?php echo JText::_( 'Contacts' ); ?>" />
	<?php endif; ?>
	<?php echo $this->category->description; ?>
<?php endif; ?>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<?php if ($this->params->get( 'show_headings' )) : ?>
	<thead>
		<tr>
			<th class="tbl-name">
				<?php echo JText::_('Name'); ?>
			</th>
			<?php if ( $this->params->get( 'show_position' ) ) : ?>
			<th class="tbl-position">
				<?php echo JText::_('Position'); ?>
			</th>
			<?php endif; if ( $this->params->get( 'show_email' ) ) : ?>
			<th class="tbl-email">
				<?php echo JText::_( 'Email' ); ?>
			</th>
			<?php endif; if ( $this->params->get( 'show_telephone' ) ) : ?>
			<th class="tbl-tel" width="90">
				<?php echo JText::_( 'Phone' ); ?>
			</th>
			<?php endif; if ( $this->params->get( 'show_mobile' ) ) : ?>
			<th class="tbl-mobile" width="90">
				<?php echo JText::_( 'Mobile' ); ?>
			</th>
			<?php endif; if ( $this->params->get( 'show_fax' ) ) : ?>
			<th class="tbl-fax" width="90">
				<?php echo JText::_( 'Fax' ); ?>
			</th>
			<?php endif; ?>
		</tr>
	</thead>
	<?php endif; ?>
	<tbody>
	    <?php echo $this->loadTemplate('items'); ?>
    </tbody>
</table>
<?php echo $this->pagination->getPagesLinks(); ?>
