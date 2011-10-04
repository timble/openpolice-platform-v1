<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php if ( $this->contact->con_position && $this->contact->params->get( 'show_position' ) ) : ?>
<h3><?php echo $this->escape($this->contact->con_position); ?></h3>
<?php endif; ?>

<?php if ( $this->contact->address && $this->contact->params->get( 'show_street_address' ) ) : ?>
<p>
    <?php if ( $this->contact->address && $this->contact->params->get( 'show_street_address' ) ) : ?>
    <span class="street-address"><?php echo nl2br($this->escape($this->contact->address)); ?></span><br />
    <?php endif; ?>
    
    <?php if ( $this->contact->postcode && $this->contact->params->get( 'show_postcode' ) ) : ?>
    <span class="postal-code"><?php echo $this->escape($this->contact->postcode); ?></span>
    <?php endif; ?>
    
    <?php if ( $this->contact->suburb && $this->contact->params->get( 'show_suburb' ) ) : ?>
    <span class="locality"><?php echo $this->escape($this->contact->suburb); ?></span><br />
    <?php endif; ?>
    
    <?php if ( $this->contact->state && $this->contact->params->get( 'show_state' ) ) : ?>
    <span class="region"><?php echo $this->escape($this->contact->state); ?></span><br />
    <?php endif; ?>
    
    <?php if ( $this->contact->country && $this->contact->params->get( 'show_country' ) ) : ?>
    <span class="country-name"><?php echo $this->escape($this->contact->country); ?></span>
    <?php endif; ?>
</p>
<?php endif; ?>

<?php if ( $this->contact->telephone && $this->contact->params->get('show_telephone') || $this->contact->fax && $this->contact->params->get('show_fax')
  || $this->contact->mobile && $this->contact->params->get('show_mobile') || $this->contact->email_to && $this->contact->params->get('show_email')) : ?>
  
    <ul>   
        <?php if ( $this->contact->telephone && $this->contact->params->get( 'show_telephone' ) ) : ?>
        <li>
              <strong><?php echo JText::_('Telephone'); ?>:</strong> <span class="value"><?php echo nl2br($this->escape($this->contact->telephone)); ?></span>
        </li>
        <?php endif; ?>
        
        <?php if ( $this->contact->fax && $this->contact->params->get( 'show_fax' ) ) : ?>
        <li>
              <strong><?php echo JText::_('Fax'); ?>:</strong> <span class="value"><?php echo nl2br($this->escape($this->contact->fax)); ?></span>
        </li>
        <?php endif; ?>
        
        <?php if ( $this->contact->mobile && $this->contact->params->get( 'show_mobile' ) ) :?>
        <li>
              <strong><?php echo JText::_('Mobile'); ?>:</strong> <span class="value"><?php echo nl2br($this->escape($this->contact->mobile)); ?></span>
        </li>
        <?php endif; ?>
        
        <?php if ( $this->contact->email_to && $this->contact->params->get( 'show_email' ) ) :?>
        <li>
              <strong><?php echo JText::_('Email'); ?>:</strong> <span class="value"><?php echo $this->contact->email_to; ?></span>
        </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>


<?php if ( $this->contact->webpage && $this->contact->params->get( 'show_webpage' )) : ?>
<p><strong><?php echo JText::_('Web'); ?>:</strong><a href="<?php echo $this->escape($this->contact->webpage); ?>">
<?php echo $this->escape($this->contact->webpage); ?></a></p>
<?php endif; ?>  
    
<?php if ( $this->contact->params->get( 'allow_vcard' ) ) : ?>
    <p class="vcard"><?php echo JText::_( 'Download information as a' );?>
	<a href="<?php echo JURI::base(); ?>index.php?option=com_contact&amp;task=vcard&amp;contact_id=<?php echo $this->contact->id; ?>&amp;format=raw&amp;tmpl=component">
		<?php echo JText::_( 'VCard' );?></a>.</p>
<?php endif; ?>