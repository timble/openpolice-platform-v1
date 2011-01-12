<?php
defined('_JEXEC') or die('Restricted access');
$user 	=& JFactory::getUser();

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
					<th class="image" width="70" align="center"><?php echo JText::_( 'PHOCAGALLERY_AVATAR' ); ?></th>
					<th class="title" width="50%"><?php echo JHTML::_('grid.sort',  'Username', 'username', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					
					<th class="image" width="1%" align="center"><?php echo JText::_( 'PHOCAGALLERY_COUNT_USER_CAT' ); ?></th>
					<th class="image" width="1%" align="center"><?php echo JText::_( 'PHOCAGALLERY_COUNT_USER_IMG' ); ?></th>
					
					<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  JText::_('PHOCAGALLERY_PUBLISHED').'<br />(' .JText::_('PHOCAGALLERY_AVATAR').')', 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  JText::_('PHOCAGALLERY_APPROVED').'<br />(' .JText::_('PHOCAGALLERY_AVATAR').')', 'a.approved', $this->lists['order_Dir'], $this->lists['order'] ); ?>
					</th>
					<th width="14%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',  'Order', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
						<?php echo JHTML::_('grid.order',  $this->items ); ?></th>
					
					
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
					$link 			= JRoute::_( 'index.php?option=com_users&view=user&task=edit&cid[]='. $row->userid );
					$linkImage		= $this->tmpl['avtrpathrel'].$row->avatar;
					$checked 	= JHTML::_('grid.checkedout', $row, $i );
					$published 	= JHTML::_('grid.published', $row, $i );
					$approved 	= PhocaGalleryRenderAdmin::approved( $row, $i );
					
					
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td><?php echo $this->tmpl['pagination']->getRowOffset( $i ); ?></td>
					<td><?php echo $checked;  echo $this->tmpl['avatarpathabs'].$row->avatar ." ...<br>"; ?></td>
					<td align="center" valign="middle">
						<div class="phocagallery-box-file">
							<center>
								<div class="phocagallery-box-file-first">
									<div class="phocagallery-box-file-second">
										<div class="phocagallery-box-file-third">
											<center>
											<?php
											
											if (JFile::exists($this->tmpl['avatarpathabs'].$row->avatar)){
												echo '<a class="'. $this->button->modalname.'"'
												.' title="'. $this->button->text.'"'
												.' href="'.JURI::root().$linkImage.'" '
												.' rel="'. $this->button->options.'" >'
												. JHTML::_( 'image', $this->tmpl['avatarpathrel'].$row->avatar.'?imagesid='.md5(uniqid(time())), '')
												.'</a>';
											} else {
												echo JHTML::_( 'image.site', 'phoca_thumb_s_no_image.gif', '../administrator/components/com_phocagallery/assets/images/');
											}
											?>
											</center>
										</div>
									</div>
								</div>
							</center>
						</div>
					</td>
					<td>
						<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit User' ); ?>">
								<?php echo $row->username; ?></a>
					</td>
					
					<td align="center"><?php echo $row->countcid;?></td>
					<td align="center"><?php echo $row->countiid;?></td>
				
					<td align="center"><?php echo $published;?></td>
					<td align="center"><?php echo $approved;?></td>
					<td class="order">
						<span><?php echo $this->tmpl['pagination']->orderUpIcon( $i, true,'orderup', 'Move Up', $ordering ); ?></span>
						<span><?php echo $this->tmpl['pagination']->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>
					<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
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
					<td colspan="10"><?php echo $this->tmpl['pagination']->getListFooter(); ?></td>
				</tr>
			</tfoot>
		</table>
	</div>

<input type="hidden" name="controller" value="phocagalleryuser" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>