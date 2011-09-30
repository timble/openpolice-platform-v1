<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
include_once(dirname(__FILE__).'/../icon.php');
$canEdit = ($this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own'));
?>
<div class="page-header">
	<h1>
		<?php if ($this->item->readmore != '0') : ?>
		<a href="<?php echo $this->item->readmore_link; ?>"><?php echo $this->escape($this->item->title); ?></a>
		<?php else : ?>
		<?php echo $this->escape($this->item->title); ?>
		<?php endif; ?>
	    
	    <?php if ($canEdit) : ?>
	    	<?php echo articleIcons::edit($this->item, $this->params, $this->access); ?>
	    <?php endif; ?>
	</h1>
	<?php if ($this->item->params->get('show_create_date')) : ?>
	<p class="article-info">   
	    <span>
	    	<strong><?php echo JHTML::_('date', $this->item->publish_up, JText::_('%a %d/%m/%Y - %H:%M')); ?></strong> 
	    </span>
	    <?php if(intval($this->item->modified) != 0 && $this->item->params->get('show_modify_date')) : ?>
	    	<span class="modified">
	    		<em><?php echo JText::_('Update'); ?>: <?php echo JHTML::_('date', $item->modified, JText::_('%d/%m/%Y - %H:%M')); ?></em>
	    	</span>
	    <?php endif; ?>
	</p>
	<?php endif; ?>		
</div>
<?php echo $this->item->event->beforeDisplayContent; ?>

<?php echo JFilterOutput::ampReplace($this->item->text);  ?>
    <?php if ($this->item->params->get('show_readmore') && $this->item->readmore) : ?>
    <p class="readon">
    	<a href="<?php echo $this->item->readmore_link; ?>">
    		<?php echo $this->item->params->get('readmore') ? $this->item->params->get('readmore') : JText::_('READMORE'); ?>  &rarr;
    	</a>
    </p>
    <?php endif; ?>
<?php echo $this->item->event->afterDisplayContent;