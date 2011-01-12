<?php
defined('_JEXEC') or die('Restricted access');
$user = &JFactory::getUser();
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
					
					<th class="title" width="80%"><?php echo JHTML::_('grid.sort',  'User', 'ratingusername', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
			
					
					
					<th width="5" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Rating', 'a.rating', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					
					<th width="15%"  class="title">
						<?php echo JHTML::_('grid.sort',  'Category', 'category', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
					<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'ID', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				$k = 0;
				for ($i=0, $n=count( $this->items ); $i < $n; $i++)
				{
					$row 			= &$this->items[$i];
					$checked 		= JHTML::_('grid.checkedout', $row, $i );
					$published 		= JHTML::_('grid.published', $row, $i );
					$row->cat_link 	= JRoute::_( 'index.php?option=com_phocagallery&controller=phocagalleryc&task=edit&cid[]='. $row->catid );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
					<td><?php echo $checked; ?></td>
					
					<td><?php echo $row->ratingusername; ?></td>
					
					<td align="center"><?php echo $row->rating; ?></td>
					
					
					<td><a href="<?php echo $row->cat_link; ?>" title="<?php echo JText::_( 'Edit Category' ); ?>"><?php echo $row->category; ?></a>
					</td>

					<td align="center"><?php echo $row->id; ?></td>
				</tr>
				<?php
				$k = 1 - $k;
				}
			?>
			</tbody>
			
			<tfoot>
				<tr>
					<td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
				</tr>
			</tfoot>
		</table>
	</div>

<input type="hidden" name="controller" value="phocagalleryra" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>