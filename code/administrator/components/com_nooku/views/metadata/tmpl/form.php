<? /** $Id: form.php 971 2009-04-12 22:21:57Z johan $ */ ?>
<? defined('_JEXEC') or die('Restricted access'); ?>

<?=@token(true)?>
<input type="hidden" name="table_name" value="<?=@$metadata->table_name; ?>" />
<input type="hidden" name="row_id" value="<?=@$metadata->row_id; ?>" />

<h3 class="jpane-toggler title" id="metadata-page"><span><?= JText::_('Metadata Information') ?></span></h3>
<div class="jpane-slider content">
<table cellspacing="1" width="100%" class="paramlist admintable">
<tbody>
<tr>
	<td class="paramlist_key">
		<span class="editlinktip">
			<label class="hasTip" title="<?=@text('Description')?>::<?=@text('Metadata description for better search engine optimization')?>" for="metadata_description">
				<?=@text('Description')?>
			</label>
		</span>
	</td>
	<td class="paramlist_value">
		<textarea id="metadata_description" name="metadata_description" class="text_area" rows="4" cols="30"><?=@$metadata->description?></textarea>
	</td>	
</tr>
<tr>
	<td class="paramlist_key">
		<span class="editlinktip">
			<label class="hasTip" title="<?=@text('Keywords')?>::<?=@text('Metadata keywords for better search engine optimization')?>" for="metadata_keywords">
				<?=@text('Keywords')?>
			</label>
		</span>
	</td>
	<td class="paramlist_value">
		<textarea id="metadata_keywords" name="metadata_keywords" class="text_area" rows="4" cols="30"><?=@$metadata->keywords?></textarea>
	</td>	
</tr>
<tr>
	<td class="paramlist_key">
		<span class="editlinktip">
			<label class="hasTip"  title="<?=@text('Author')?>::<?=@text('Metadata author for this page')?>" for="metadata_author">
				<?=@text('Author')?>
			</label>
		</span>
	</td>
	<td class="paramlist_value">
		<input id="metadata_author" type="text" name="metadata_author" value="<?=@$metadata->author?>" />
	</td>	
</tr>
</tbody>
</table>
</div>