<?php /** $Id$ */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="page-header">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>
<p><?php echo nl2br($this->params->get('welcome_desc', JText::_( 'WELCOME_DESC' ))); ?></p>
