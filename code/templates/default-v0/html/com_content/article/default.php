<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
include_once(dirname(__FILE__).'/../icon.php');
$can_edit = $this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own');
?>

<div class="article clearfix">
	<div class="page-header">
		<h1><?php echo $this->escape($this->article->title); ?><?php if ($can_edit) : ?> <?php echo articleIcons::edit($this->article, $this->params, $this->access); ?><?php endif; ?></h1>
		
		<?php if ($this->params->get('show_create_date')) : ?>
		<p class="article-info">   
			<span>
				<strong><?php echo JHTML::_('date', $this->article->publish_up, JText::_('%a %d/%m/%Y - %H:%M')); ?></strong>
			</span>
			<?php if(intval($this->article->modified) != 0 && $this->params->get('show_modify_date')) : ?>
				<span class="modified">
					<em><?php echo JText::_('Update'); ?>: <?php echo JHTML::_('date', $this->article->modified, JText::_('%d/%m/%Y - %H:%M')); ?></em>
				</span>
			<?php endif; ?>
			<?php if ($this->params->get('show_share_icon', 0)) : ?>
			<span class='st_sharethis' displayText='ShareThis'></span>
			<?php endif; ?>
		</p>
		<?php endif; ?>
	</div>
	
	<?php  if (!$this->params->get('show_intro')) :	echo $this->article->event->afterDisplayTitle; endif; ?>
	
	<?php echo $this->article->event->beforeDisplayContent; ?>
	
	<?php echo $this->article->text; ?>
	
	<?php echo $this->article->event->afterDisplayContent; ?>
</div>