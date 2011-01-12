<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');

if (isset($this->tmpl['notapproved']->count) && (int)$this->tmpl['notapproved']->count > 0 ) {
	echo '<div class="notapproved">'.JText::_('PHOCAGALLERY_NOT_APPROVED_CATEGORY_IN_GALLERY').': '.(int)$this->tmpl['notapproved']->count.'</div>';
}
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
					
					<th class="title" width="80%"><?php echo JHTML::_('grid.sort',  'Title', 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  JText::_('PHOCAGALLERY_PUBLISHED'), 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  JText::_('PHOCAGALLERY_APPROVED'), 'a.approved', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="13%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',  'Order', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
						<?php echo JHTML::_('grid.order',  $this->items ); ?></th>
					<th width="7%">
					<?php //echo JHTML::_('grid.sort',   'Access', 'groupname', @$lists['order_Dir'], @$lists['order'] );
					echo JTEXT::_('Access');

					?>
					</th>
				
					<th width="15%"  class="title">
						<?php echo JHTML::_('grid.sort',  'Parent Category', 'category', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
				
					<th width="5%"><?php echo JHTML::_('grid.sort',  'PHOCAGALLERY_OWNER', 'a.owner_id', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
					
					<th width="5%"><?php echo JHTML::_('grid.sort',  'Rating', 'v.average', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th width="5%"><?php echo JHTML::_('grid.sort',  'Hits', 'a.hits', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>				
						
					<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'ID', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				
				$k = 0;
				$i = 0;
				$n = count( $this->items );
				$rows = &$this->items;
				if (is_array($rows)) {
					foreach ($rows as $row) {
						$link 	= JRoute::_( 'index.php?option=com_phocagallery&controller=phocagalleryc&task=edit&cid[]='. $row->id );
						$checked 	= JHTML::_('grid.checkedout', $row, $i );
						$published 	= JHTML::_('grid.published', $row, $i );
						$access 	= JHTML::_('grid.access',   $row, $i );
						$approved 	= PhocaGalleryRenderAdmin::approved( $row, $i );
						$row->cat_link 	= JRoute::_( 'index.php?option=com_phocagallery&controller=phocagalleryc&task=edit&cid[]='. $row->parent_id );
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $this->tmpl['pagination']->getRowOffset( $i );?></td>
						<td><?php echo $checked; ?></td>
						
						<td>
							<?php
							if (  JTable::isCheckedOut($this->user->get ('id'), $row->checked_out ) ) {
								echo $row->title;
							} else {
							?>
								<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit Category' ); ?>">
									<?php echo $row->title; ?></a>
							<?php
							}
							?>
						</td>
						
						<td align="center"><?php echo $published;?></td>
						<td align="center"><?php echo $approved;?></td>
						<td class="order">
							<span><?php echo $this->tmpl['pagination']->orderUpIcon( $i, $row->orderup == 1, 'orderup', 'Move Up', $this->tmpl['ordering']); ?></span>
					<span><?php echo $this->tmpl['pagination']->orderDownIcon( $i, $n, $row->orderdown == 1, 'orderdown', 'Move Down', $this->tmpl['ordering'] ); ?></span>
						<?php $disabled = $this->tmpl['ordering'] ?  '' : 'disabled="disabled"'; ?>
							<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
						</td>
						<td align="center">
							<?php echo $access;?>
						</td>  
					
						<td><a href="<?php echo $row->cat_link; ?>" title="<?php echo JText::_( 'Edit Parent Category' ); ?>"><?php echo $row->parentname; ?></a>
						</td>

						<td align="center"><?php echo $row->usercatname; ?></td>
						
						<td align="center"><?php
							$voteAvg 		= round(((float)$row->ratingavg / 0.5)) * 0.5;
							$voteAvgWidth	= 16 * $voteAvg;
							echo '<ul class="star-rating-small">'
							.'<li class="current-rating" style="width:'.$voteAvgWidth.'px"></li>'
							.'<li><span class="star1"></span></li>';
					
							for ($ir = 2;$ir < 6;$ir++) {
								echo '<li><span class="stars'.$ir.'"></span></li>';
							}
							echo '</ul>';
						
						?></td>
						<td align="center"><?php echo $row->hits; ?></td>
						<td align="center"><?php echo $row->id; ?></td>
					</tr>
					<?php
					$k = 1 - $k;
					$i++;
			
					}
				}
			?>
			</tbody>
			
			<tfoot>
				<tr>
					<td colspan="12"><?php echo $this->tmpl['pagination']->getListFooter(); ?></td>
				</tr>
			</tfoot>
		</table>
	</div>

<input type="hidden" name="controller" value="phocagalleryc" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>