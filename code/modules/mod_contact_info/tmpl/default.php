<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<p>
<?php echo $params->get('street'); ?><br />
<?php echo $params->get('zip'); ?> <?php echo $params->get('city'); ?><br />
<?php if ($params->get('phone')) : ?>T: <?php echo $params->get('phone'); ?><br /><?php endif ?>
<?php if ($params->get('fax')) : ?>F: <?php echo $params->get('fax'); ?><?php endif ?>
</p>

<?php if($params->get('link_url') && $params->get('link_text') ) : ?>
<p><a href="<?php echo $params->get('link_url'); ?>"><?php echo $params->get('link_text'); ?></a></p>
<?php endif ?>