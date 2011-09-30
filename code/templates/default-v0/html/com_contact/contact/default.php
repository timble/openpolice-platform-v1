<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php 
$cparams = JComponentHelper::getParams ('com_media');
?>
<div class="page-header"><h1><?php echo $this->params->get( 'page_title' ); ?></h1></div>
<div class="article separator clearfix">
<?php if ( $this->contact->image && $this->contact->params->get( 'show_image' ) ) : ?>
	<?php echo JHTML::_('image', 'images/stories' . '/'.$this->contact->image, JText::_( 'Contact' ), array('align' => 'right', 'class' => 'photo')); ?>
<?php endif; ?>

<?php echo $this->loadTemplate('address'); ?>

<?php if ( $this->contact->misc && $this->contact->params->get( 'show_misc' ) ) : ?>
<p>
	<?php echo nl2br($this->contact->misc); ?>
</p>
<?php endif; ?>
</div>
<?php if ( $this->contact->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id))
    echo $this->loadTemplate('form');
?>