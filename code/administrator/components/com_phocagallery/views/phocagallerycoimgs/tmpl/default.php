<?php
defined('_JEXEC') or die('Restricted access');
$user 	=& JFactory::getUser();

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'a.ordering');

JHTML::_('behavior.tooltip');
?>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">
	<table>
		<tr>
			<td align="left" width="100%"><?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
				echo $this->lists['catid'];
				echo $this->lists['state'];
				?>
			</td>
		</tr>
	</table>

	<div id="editcell">
		<table class="adminlist">
			<thead>
				<tr>
					<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
					<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
					
					
					<th class="title" width="20%"><?php echo JHTML::_('grid.sort',  'User', 'commentusername', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th class="title" width="50%"><?php echo JHTML::_('grid.sort',  'Title', 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="15%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Date', 'a.date', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Published', 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="12%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',  'Order', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
						<?php echo JHTML::_('grid.order',  $this->items ); ?></th>
					
					<th width="10%"  class="title">
						<?php echo JHTML::_('grid.sort',  'Image', 'imgid', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
					
					<th width="10%"  class="title">
						<?php echo JHTML::_('grid.sort',  'Category', 'catid', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
					
					<th width="5" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'ID', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				$k = 0;
				for ($i=0, $n=count( $this->items ); $i < $n; $i++)
				{
					$row 			= &$this->items[$i];
				
					$link 			= JRoute::_( 'index.php?option=com_phocagallery&controller=phocagallerycoimg&task=edit&cid[]='. $row->id );
					$date		= JHTML::_('date',  $row->date, JText::_('DATE_FORMAT_LC2') );
					$checked 	= JHTML::_('grid.checkedout', $row, $i );
					$published 	= JHTML::_('grid.published', $row, $i );
					$row->cat_link 	= JRoute::_( 'index.php?option=com_phocagallery&controller=phocagalleryc&task=edit&cid[]='. $row->catid );
					$row->img_link 	= JRoute::_( 'index.php?option=com_phocagallery&controller=phocagallery&task=edit&cid[]='. $row->imgid );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
					<td><?php echo $checked; ?></td>
					
						<td><?php echo $row->commentusername;?></td>
					<td>
						<?php
						if (  JTable::isCheckedOut($this->user->get ('id'), $row->checked_out ) ) {
							echo $row->title;
						} else {
						?>
							<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit Phoca gallery' ); ?>">
								<?php echo $row->title; ?></a>
						<?php
						}
						?>
					</td>
					<td><?php echo $date;?></td>
					
					<td align="center"><?php echo $published;?></td>
					<td class="order">
						<span><?php echo $this->pagination->orderUpIcon( $i, ($row->imgid == @$this->items[$i-1]->imgid),'orderup', 'Move Up', $ordering ); ?></span>
						<span><?php echo $this->pagination->orderDownIcon( $i, $n, ($row->imgid == @$this->items[$i+1]->imgid), 'orderdown', 'Move Down', $ordering ); ?></span>
					<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
					</td>
					
					<td><a href="<?php echo $row->img_link; ?>" title="<?php echo JText::_( 'Edit Image' ); ?>"><?php echo $row->imgtitle; ?></a></td>

					<td><a href="<?php echo $row->cat_link; ?>" title="<?php echo JText::_( 'Edit Category' ); ?>"><?php echo $row->cattitle; ?></a></td>
					<td align="center"><?php echo $row->id; ?></td>
				</tr>
				<?php
				$k = 1 - $k;
				}
			?>
			</tbody>
			
			<tfoot>
				<tr>
					<td colspan="10"><?php echo $this->pagination->getListFooter(); ?></td>
				</tr>
			</tfoot>
		</table>
	</div>

<input type="hidden" name="controller" value="phocagallerycoimg" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>