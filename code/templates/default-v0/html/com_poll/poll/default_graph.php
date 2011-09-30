<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<br />
<table class="pollstableborder" cellspacing="0" cellpadding="0" border="0">
<thead>
	<tr>
		<th colspan="4" class="sectiontableheader">
			<?php echo $this->escape($this->poll->title); ?>
		</th>
	</tr>
</thead>
<tbody>
<?php foreach($this->votes as $vote) : ?>
	<tr class="sectiontableentry<?php echo $vote->odd; ?>">
		<td>
			<?php echo $vote->text; ?>
		</td>
		<td width="25">
			<strong><?php echo $this->escape($vote->hits); ?></strong>&nbsp;
		</td>
		<td width="30" >
			<?php echo $this->escape($vote->percent); ?>%
		</td>
		<td width="100" >
			<div class="<?php echo $vote->class; ?>" style="height:<?php echo $vote->barheight; ?>px;width:<?php echo $vote->percent; ?>%"></div>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
<br />
<table cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr>
		<td>
			<?php echo JText::_( 'Number of Voters' ); ?>
		</td>
		<td>
			<?php if(isset($this->votes[0])) echo $this->votes[0]->voters; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo JText::_( 'First Vote' ); ?>
		</td>
		<td>
			<?php echo $this->escape($this->first_vote); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo JText::_( 'Last Vote' ); ?>
		</td>
		<td>
			<?php echo $this->escape($this->last_vote); ?>
		</td>
	</tr>
</tbody>
</table>
